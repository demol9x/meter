<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

namespace api\modules\v1\controllers;

use common\models\banner\Banner;
use common\models\banner\BannerGroup;
use Yii;
use api\components\RestController;


/**
 *
 */
class BannerController extends RestController
{

    public function actionIndex(){
        $request = Yii::$app->getRequest()->get();
        $limit = (isset($request['limit']) && $request['limit']) ? $request['limit'] : 5;
        $group_id = (isset($request['group_id']) && $request['group_id']) ? $request['group_id'] : '';
        $group = BannerGroup::findOne(['id' => $group_id]);
        if ($group) {
            $data = Banner::getBannerFromGroupId($group_id, ['limit' => $limit]);
            $return = [
                'success' => true,
                'data' => $data
            ];
        }else{
            $return = [
                'success' => false,
                'errors' => 'Dữ liệu không hợp lệ'
            ];
        }
        return $this->responseData($return);
    }

    /**
     * @return array
     */
    protected function verbs()
    {
        return [
            'index' => ['get'],
        ];
    }
}