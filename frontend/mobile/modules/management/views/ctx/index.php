<?php
\Yii::$app->session->open();

use yii\helpers\Url;
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt="">Chứng thực số
        </h2>
    </div>
    <div class="list-address-pay">
        <?php foreach ($list_c as $cer) {
            $cered = isset($cers[$cer['id']]) ? $cers[$cer['id']] : [];
        ?>
            <div class="item-address-pay">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        <h2>
                            <b>Trang liên kết:</b>
                            <?= $cer['name'] ?> - <?= $cer['url'] ?>
                        </h2>
                        <p>
                            <b>Tài khoản kết nối:</b>
                            <?= $cered ? $cered['username'] : 'Chưa có thông tin' ?>
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                        <div class="tool-box">
                            <?php if ($cered) { ?>
                                <a href="<?= Url::to(['/management/ctx/update', 'cer_id' => $cer['id']]) ?>" class="open-input-fixeds"><i class="fa fa-pencil"></i><?= Yii::t('app', 'update') ?></a>
                                <a class="btn-set-default" data-confirm="Xác nhận xóa!" href="<?= Url::to(['/management/ctx/del', 'id' => $cered['id']]) ?>">Xóa</a>
                            <?php } else { ?>
                                <a href="<?= Url::to(['/management/ctx/update', 'cer_id' => $cer['id']]) ?>" class="open-input-fixeds"><i class="fa fa-pencil"></i>Kết nối</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>