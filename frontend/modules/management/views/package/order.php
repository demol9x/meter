<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 12/1/2021
 * Time: 11:08 AM
 */
?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/quanlysanpham.css">
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt=""> Danh sách gói đang có
                doanh nghiệp dự thầu
            </h2>
        </div>
        <div class="manager-product-store">
            <div class="list-product-manager section-product">
                <div class="row-5 product-in-store tab-menu-read tab-menu-read-1 tab-active" style="display: block;"
                     id="tab-product-1">
                    <?php if ($orders): ?>
                        <?php foreach ($orders as $order):
                           $link=  \yii\helpers\Url::to(['/management/package/detail','id'=>$order['package_id']]);?>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="item-product-inhome">
                                    <div class="img">
                                        <a href="<?= $link ?>" title="Xem chi tiết"
                                           style="height: 0.3384px;">
                                            <img src="<?= \common\components\ClaHost::getImageHost().$order['package']['avatar_path'].$order['package']['avatar_name'] ?>"
                                                 alt="<?= $order['package']['name'] ?>">
                                        </a>
                                    </div>
                                    <h3>
                                        <a href="#" title="Xem chi tiết" class="content_15"><?= $order['package']['name'] ?></a>
                                    </h3>
                                    <div style="padding: 10px">
                                        <span style="color: #289300" class="content_15">Đang dự thầu: <?= $order['count'] ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
