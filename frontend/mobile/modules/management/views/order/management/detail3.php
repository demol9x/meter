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
<div class="btn-table-donhang">
	<?php if(!$data['transport_id']) { ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a class="click" onclick="received(<?= $data['id'] ?>)">Giao hàng thành công</a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a class="no-background click" onclick="cancer(<?= $data['id'] ?>, 3)"><?= Yii::t('app', 'order_check_10') ?></a>
        </div>
    <?php } ?>
</div>
<div style="clear: both; padding: 1px">
    <hr/>
</div>
<?= $this->render('view_history', [
    'data' => $data,
]) ?>