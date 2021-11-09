<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
use common\components\shipping\ClaShipping;
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<?= $this->render('view_detail', [
    'data' => $data,
]) ?>
<?= $this->render('view_history', [
    'data' => $data,
]) ?>