<?php

use common\components\ClaHost;
use yii\helpers\Url;

if (isset($data) && $data) {
    ?>
    <div class="xuhuong-timkiem">
        <div class="container">
            <div class="title-standard">
                <h2>
                    <a><?= Yii::t('app', 'top_search') ?></a>
                </h2>
            </div>
            <div class="list-xuhuong-mobile">
                <?php
                    foreach ($data as $item) {
                        ?>
                        <div class="item-cate-menu">
                            <div class="img">
                                <div class="vertical" style="height: 90px; overflow: hidden;">
                                    <div class="middle">
                                        <a href="<?= Url::to(['/search/search/index', 'keyword' => $item['keyword']]) ?>" title="<?= $item['keyword'] ?>">
                                            <img src="<?= ClaHost::getImageHost(), $item['avatar_path'],'s100_100/', $item['avatar_name'] ?>" alt="<?= $item['keyword'] ?>" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <h3>
                                <a href="<?= Url::to(['/search/search/index', 'keyword' => $item['keyword']]) ?>" title="<?= $item['keyword'] ?>"><?= $item['keyword'] ?></a>
                            </h3>
                        </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>