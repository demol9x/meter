<?php

use common\components\ClaHost;
use yii\helpers\Url;
?>
<?php if (isset($data) && $data) { ?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="cate-news-index">
            <div class="title-cate-news-index">
                <a href="<?= Url::to(['/news/news/category', 'id' => $category['id'], 'alias' => $category['alias']]) ?>" title="<?= $category['name'] ?>"><?= $category['name'] ?></a>
            </div>
            <div class="avarta-cate">
                <?php 
                    $url = Url::to(['/news/news/detail', 'id' => $data['0']['id'], 'alias' => $data['0']['alias']]);
                    $name = $data['0']['title'];
                    $img = ClaHost::getImageHost(). $data['0']['avatar_path']. 's400_400/'. $data['0']['avatar_name'];
                    unset($data['0']);
                ?>
                <div class="img">
                    <a href="<?= $url ?>" title="<?= $name ?>">
                        <?php if($img) { ?>
                            <img src="<?= $img ?>" alt="<?= $name ?>" />
                        <?php } ?>
                    </a>
                </div>
                <h2><a href="<?= $url ?>" title="<?= $name ?>"><?= $name ?></a></h2>
            </div>
            <div class="list-news-incate">
                <?php
                foreach ($data as $item) {
                    $url = Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]);
                    ?>
                    <div class="item-news-incate">
                        <div class="img">
                            <a href="<?= $url ?>" title="<?= $item['title'] ?>">
                                <?php if($item['avatar_name']) { ?>
                                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's200_200/', $item['avatar_name'] ?>" alt="<?= $item['title'] ?>" />
                                <?php } ?>
                            </a>
                        </div>
                        <h3>
                            <a href="<?= $url ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                        </h3>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

<?php } ?>