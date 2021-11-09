<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\db\Query;
use common\components\ClaHost;

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
}
