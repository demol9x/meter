<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/quanlysanpham.css">
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt=""> Danh sách đang dự thầu
            </h2>
        </div>
        <div class="manager-product-store">
            <div class="list-product-manager section-product">
                <div class="row-5 product-in-store tab-menu-read tab-menu-read-1 tab-active" style="display: block;"
                     id="tab-product-1">

                    <?php if ($packages): ?>
                        <?php foreach ($packages as $package):
                            $link = \yii\helpers\Url::to(['/package/package/detail', 'id' => $package['package']['id'], 'alias' => $package['package']['alias']]);
                            $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                            if (isset($package['package']['avatar_path']) && $package['package']['avatar_path']) {
                                $avatar_path = \common\components\ClaHost::getImageHost() . $package['package']['avatar_path'] . $package['package']['avatar_name'];
                            }
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="item-product-inhome">
                                    <div class="img">
                                        <a href="<?php echo $link ?>" target="_blank" title="sản phẩm" style="height: 0.3384px;">
                                            <img src="<?= $avatar_path ?>" alt="sản phẩm">
                                        </a>
                                    </div>
                                    <h3>
                                        <a href="<?php echo $link ?>" target="_blank" title="sản phẩm" class="content_15"><?= $package['package']['name'] ?></a>
                                    </h3>
                                    <div style="padding: 10px">
                                        <span style="color: #289300"
                                              class="content_14"><?= isset($package['price']) && $package['price'] ? $package['price'] : '' ?></span>
                                        <span style="float: right"
                                              class="content_14"><?= date('d-m-Y', $package['created_at']) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="paginate">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>