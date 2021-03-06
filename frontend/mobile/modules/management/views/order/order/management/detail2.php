<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
use common\components\shipping\ClaShipping;
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<h2>
    <i class="fa fa-file-text" aria-hidden="true"></i>
    <b><?= Yii::t('app', 'orders') ?></b>
    OR<?= $data['order_id'] ?>
</h2>
<div class="table-shop">
    <table>
        <tbody>
            <tr>
                <td class="bg-eb" width="150">
                    <p><?= Yii::t('app', 'customer') ?></p>
                </td>
                <td>
                    <p><?= $data['name'] ?></p>
                </td>
            </tr>
            <tr>
                <td class="bg-eb" width="150">
                    <p><?= Yii::t('app', 'address') ?></p>
                </td>
                <td>
                    <p><?= $data['address'] ?></p>
                </td>
            </tr>
            <tr>
                <td class="bg-eb" width="150">
                    <p><?= Yii::t('app', 'time_sell') ?></p>
                </td>
                <td>
                    <p><?= date('d/m/Y', $data['created_at']) ?></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="btn-table-donhang">
    <?php if(!$data['transport_id']) { ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a class="click" onclick="update23(<?= $data['id'] ?>)"><?= Yii::t('app', 'order_check_9') ?></a>
        </div>
    <?php } ?>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <a class="no-background click" onclick="cancer(<?= $data['id'] ?>, 2)"><?= Yii::t('app', 'order_check_10') ?></a>
    </div>
</div>
<div style="clear: both; padding: 1px">
    <hr/>
</div>
<h2>
    <i class="fa fa-truck" aria-hidden="true"></i>
    <b><?= Yii::t('app', 'order_history') ?></b>
</h2>
<p>
    <?= \common\models\transport\Transport::getName($data['transport_type']) ?> | <?= Yii::t('app', 'order_id') ?> <?= $data['transport_id'] ?>
</p>
<?php 
    $historys = \common\models\order\OrderShopHistory::getHistory($data['id']);
?>
<div class="infor-nguoigiao">
   <!--  <p>Ng?????i giao h??ng: Nguy???n Vi???t H??ng</p>
    <p>841284067479</p>
    <p>
        B??u ??i???n Ph?????c S??n huy???n Tuy Ph?????c t???nh B??nh ?????nh, X?? Ph?????c S??n, Huy???n Tuy Ph?????c, B??nh ?????nh
    </p> -->
    <ul>
        <?php if($historys) {
            foreach ($historys as $history) { ?>
                <li class="active">
                    <p>
                        <span><?= date('h:i:s d-m-Y', $history['time']) ?></span> <?= $history['status'] ?>
                    </p>
                </li>
            <?php }
        } ?>
    </ul>
</div>