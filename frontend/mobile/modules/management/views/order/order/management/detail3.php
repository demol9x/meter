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
<!-- <div class="btn-table-donhang">
    <div class="col-xs-12">
        <a class="no-background click" onclick="cancer(<?= $data['id'] ?>, 3)"><?= Yii::t('app', 'order_check_10') ?></a>
    </div>
</div> -->
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
   <!--  <p>Người giao hàng: Nguyễn Việt Hưng</p>
    <p>841284067479</p>
    <p>
        Bưu điện Phước Sơn huyện Tuy Phước tỉnh Bình Định, Xã Phước Sơn, Huyện Tuy Phước, Bình Định
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