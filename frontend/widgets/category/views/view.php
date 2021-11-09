<?php

use common\components\ClaHost;

if (isset($data) && $data) {
    ?>

    <div class="cate-menu-inhome">
        <div class="container">
            <div class="title-standard">
                <h2>
                    <a href="javascript:void(0)">Danh mục</a>
                </h2>
                <!--<a href="" class="view-more">Xem tất cả <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>-->
            </div>
            <div class="list-cate-menu">
                <?php
                foreach ($data as $item) {
                    ?>
                    <div class="item-cate-menu">
                        <div class="img">
                            <div class="vertical">
                                <div class="middle">
                                    <a href="<?= $item['link'] ?>" title="<?= $item['name'] ?>">
                                        <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's80_80/', $item['avatar_name'] ?>" alt="<?= $item['name'] ?>" />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <h3>
                            <a href="<?= $item['link'] ?>" title="<?= $item['name'] ?>"><?= $item['name'] ?></a>
                        </h3>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>