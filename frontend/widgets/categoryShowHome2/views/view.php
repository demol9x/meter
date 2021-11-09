<?php

use common\components\ClaHost;
use yii\helpers\Url;

if (isset($data) && $data) {
    ?>
    <style type="text/css">
        .item-cate-menu h3 {
            font-size: 14px;
            line-height: 18px !important;
        }
    </style>
    <div class="xuhuong-timkiem cate-menu-inhome">
        <div class="container">
            <div class="title-standard">
                <h2>
                    <a><?= Yii::t('app', 'menu') ?></a>
                </h2>
            </div>
            <div class="relative">
                <div class="list-cate-menu owl-carousel owl-theme "> <!-- hidden-loading-content -->
                    <?php
                    foreach ($data as $item) {
                        $link = Url::to(['/product/product/category/', 'id' => $item['id'], 'alias' => $item['alias']]);
                        $src = ClaHost::getImageHost(). $item['avatar_path']. 's80_80/'. $item['avatar_name'];
                        ?>
                         <div class="item-cate-menu"  data-merge="1">
                            <a href="<?= $link ?>" title="<?= $item['name'] ?>">
                                <div class="img" <?= $item['avatar_name'] ? 'style="background-image: url('. $src .'"' : '' ?>  alt="<?= $item['name'] ?>"></div>
                                <h3>
                                    <?= $item['name'] ?>
                                </h3>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <!-- <div class="list-cate-menu-lazy loading-content-gca">
                    <div class="item-cate-menu">
                        <a>
                            <div class="img">
                                <div class="box-thumbnail"></div>
                            </div>
                            <h3>
                                <div class="box-line-sm"></div>
                            </h3>
                        </a>
                    </div>
                    <div class="item-cate-menu">
                        <a>
                            <div class="img">
                                <div class="box-thumbnail"></div>
                            </div>
                            <h3>
                                <div class="box-line-sm"></div>
                            </h3>
                        </a>
                    </div>
                    <div class="item-cate-menu">
                        <a>
                            <div class="img">
                                <div class="box-thumbnail"></div>
                            </div>
                            <h3>
                                <div class="box-line-sm"></div>
                            </h3>
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
<?php } ?>