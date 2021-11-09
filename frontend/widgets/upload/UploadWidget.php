<?php

namespace frontend\widgets\upload;

use Yii;
use yii\base\Widget;

class UploadWidget extends \frontend\components\CustomWidget {

    public $serviceLocator;
    public $type = 'images'; // Loại upload image hay file
    public $id = 'uploadfile'; // ID cho nút upload
    //public $name = 'uploadfile';
    public $path = array('img');
    public $key = 'web3nhatpro';
    public $imageoptions = array(
    );
    public $limit = 20; // Giới hạn số file có thể upload lên
    //
    public $loadscript = true;
    public $buttonwidth = 100;
    public $buttonheight = 30;
    public $buttontext = 'Select File';
    public $multi = true;
    public $displayvaluebox = true;
    public $fileSizeLimit = '6MB';
    public $oncecomplete = '';
    public $queuecomplete = '';
    public $onUploadStart = '';
    protected $_defaultsizes = array(array(500, 500));

    public function init() {
        if (!isset($this->imageoptions['resizes'])) {
            $this->imageoptions['resizes'] = array();
        }
        $this->imageoptions['resizes'] = array_merge($this->imageoptions['resizes'], $this->_defaultsizes);
        if ($this->type == 'files') {
            $this->fileSizeLimit = '20MB';
        }
        $this->registerClientScript();
        parent::init();
    }

    public function run() {
        return $this->render('image', [
                    'type' => $this->type,
                    'id' => $this->id,
                    'path' => $this->path,
                    'key' => $this->key,
                    'limit' => $this->limit,
                    'imageoptions' => $this->imageoptions,
                    'buttonwidth' => $this->buttonwidth,
                    'buttonheight' => $this->buttonheight,
                    'multi' => $this->multi,
                    'buttontext' => $this->buttontext,
                    'displayvaluebox' => $this->displayvaluebox,
                    'fileSizeLimit' => $this->fileSizeLimit,
                    'oncecomplete' => $this->oncecomplete,
                    'queuecomplete' => $this->queuecomplete
        ]);
    }

    public function registerClientScript() {
        if (!Yii::app()->request->isAjaxRequest) {
            if (!defined("UPLOAD_REGISTERSCRIPT")) {
                define("UPLOAD_REGISTERSCRIPT", true);
                $assets = Yii::$app->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
                $client = Yii::$app->clientScript;
                $client->registerScriptFile($assets . "/js/upload.js");
                Yii::$app->getClientScript()->registerCssFile(Yii::$app->homeUrl . 'js/upload/uploadify/uploadify.css?ver');
                Yii::$app->getClientScript()->registerJsFile(Yii::$app->homeUrl . 'js/upload/uploadify/jquery.uploadify.min.js');
            }
        }
    }

}

?>