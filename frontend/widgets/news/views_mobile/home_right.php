<?php

use common\components\ClaHost;
use yii\helpers\Url;

if (isset($data) && $data) { ?>
    <div class="layout-crn layout-crn1 ">
        <div class="title-crn">
            <h2>
                <a <?php if(isset($category) && $category) {?> href="<?= Url::to(['/news/news/category', 'id' => $category->id, 'alias' => $category->alias]) ?>" <?php } ?>><?= isset($category->name) ? $category->name : 'Tin tức nổi bật' ?></a>
            </h2>
        </div>
        <div class="content-crn">
            <div class="list-news-incate list-news-incate-crn">
                <?php foreach ($data as $item) { ?>
                    <div class="item-news-incate">
                        <div class="img">
                            <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" >
                                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'],'s100_100/', $item['avatar_name'] ?>" atl="<?= $item['title'] ?>" />
                                </a>
                        </div>
                        <h3>
                            <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                        </h3>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>