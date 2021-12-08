<?php

namespace frontend\controllers;
use common\models\general\UserWish;
use common\models\package\PackageWish;
use common\models\rating\Rating;
use common\models\rating\RatingLike;
use Yii;
use yii\web\Controller;
use yii\db\Query;
use common\components\ClaHost;
use yii\web\Response;

class AjaxController extends Controller {

    public function actionGenShopXml() {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $node = $doc->createElement('shop');
        //$fileXML = 'tblPhanLoai.xml';
        $parnode = $doc->appendChild($node);
        $data = (new Query())->from('shop')->select("id, name, alias, lat, lng")->where(['status' => 1])->all();
        header("Content-type: text/xml");
        // Iterate through the rows, adding XML nodes for each
        foreach ($data as $row) {
            // ADD TO XML DOCUMENT NODE
            $node = $doc->createElement("shop");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("title", $row['name']);
            $newnode->setAttribute("lat", $row['lat']);
            $newnode->setAttribute("lng", $row['lng']);
            $newnode->setAttribute("url", \yii\helpers\Url::to(['/shop/shop/detail', 'id' => $row['id'], 'alias' => $row['alias']]));
        }
        $xmlfile = $doc->saveXML();
        echo $xmlfile;
        exit;
    }

    public function actionWishList($package_id){
        $user_id = Yii::$app->user->getId();
        $message = '';
        $errors = [];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->user->getId()){
                $package_wish = PackageWish::find()->where(['user_id' => $user_id, 'package_id' => $package_id])->one();
                if ($package_wish) {
                    if ($package_wish->delete()) {
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Xóa khỏi danh sách yêu thích thành công'
                        ]);
                    } else {
                        $message = $package_wish->getErrors();
                    }
                }
                else {
                    $package_wish = new PackageWish();
                    $package_wish->user_id = $user_id;
                    $package_wish->package_id = $package_id;
                    if ($package_wish->save()) {
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Thêm vào danh sách yêu thích thành công'
                        ]);
                    } else {
                        $errors = $package_wish->getErrors();
                    }
                }
            }
            else {
                $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
            }
        }
        return json_encode([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionWishListUser($user_id,$type){
        $u_id = Yii::$app->user->getId();
        $message = '';
        $errors = [];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->user->getId()){
                $user_wish = UserWish::find()->where(['user_id_from' => $u_id, 'user_id' => $user_id])->one();
                if ($user_wish) {
                    if ($user_wish->delete()) {
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Xóa khỏi danh sách yêu thích thành công'
                        ]);
                    } else {
                        $message = $user_wish->getErrors();
                    }
                }
                else {
                    $user_wish = new UserWish();
                    $user_wish->user_id_from = $u_id;
                    $user_wish->user_id = $user_id;
                    $user_wish->type = $type;
                    if ($user_wish->save()) {
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Thêm vào danh sách yêu thích thành công'
                        ]);
                    } else {
                        $errors = $user_wish->getErrors();
                    }
                }
            }
            else {
                $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
            }
        }
        return json_encode([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function actionLikeComment(){
        $message = '';
        $errors = [];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $request = $_POST;
            if(Yii::$app->user->getId()){
                $like = RatingLike::find()->where(['rating_id' => $request['id'],'user_id' => Yii::$app->user->id])->one();
                if ($like) {
                    if ($like->delete()) {
                        $rating = Rating::findOne($request['id']);
                        $rating->count_like -= 1;
                        $rating->save();
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Xóa khỏi danh sách yêu thích thành công'
                        ]);
                    } else {
                        $message = $like->getErrors();
                    }
                }
                else {
                    $like = new RatingLike();
                    $like->rating_id = $request['id'];
                    $like->user_id = Yii::$app->user->id;
                    if ($like->save()) {
                        $rating = Rating::findOne($request['id']);
                        $rating->count_like += 1;
                        $rating->save();
                        return json_encode([
                            'success' => true,
                            'errors' => $errors,
                            'message' => 'Thêm vào danh sách yêu thích thành công'
                        ]);
                    } else {
                        $errors = $like->getErrors();
                    }
                }
            }
            else {
                $message = 'Bạn phải đăng nhập để thực hiện hành động này.';
            }
        }
        return json_encode([
            'success' => false,
            'errors' => $errors,
            'message' => $message
        ]);
    }
}
