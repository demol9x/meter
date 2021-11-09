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
            <div class="avarta-cate relative">
                <?php 
                    $url = Url::to(['/news/news/detail', 'id' => $data['0']['id'], 'alias' => $data['0']['alias']]);
                    $name = $data['0']['title'];
                    $img = $data['0']['avatar_name'] ? ClaHost::getImageHost(). $data['0']['avatar_path']. 's400_400/'. $data['0']['avatar_name'] : '';
                    unset($data['0']);
                ?>
                <div class="img hidden-loading-content">
                    <a href="<?= $url ?>" title="<?= $name ?>">
                        <?php if($img) { ?>
                            <img class="lazy" alt="<?= $name ?>"  data-src="<?= $img ?>" />
                        <?php } ?>
                    </a>
                </div>
                <div class="loading-content-gca">
                    <div class="box-thumbnail"></div>
                </div>
                <h2><a href="<?= $url ?>" title="<?= $name ?>"><?= $name ?></a></h2>
            </div>
            <div class="list-news-incate">
                <?php
                foreach ($data as $item) {
                    $url = Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]);
                    ?>
                    <div class="item-news-incate relative ">
                        <div class="img " >
                            <a href="<?= $url ?>" title="<?= $item['title'] ?>">
                                <div class="hidden-loading-content">
                                <?php if($item['avatar_name']) { ?>
                                    <img class="lazy" alt="<?= $item['title'] ?>"  data-src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's200_200/', $item['avatar_name'] ?>" />
                                <?php } ?>
                                </div>
                                <div class="box-thumbnail box-thumbnail-abs"></div>
                            </a>
                        </div>
                        <h3>
                            <div class="hidden-loading-content">
                                <a href="<?= $url ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                            </div>
                            <div class="box-line-sm"></div>
                            <div class="box-line-xs"></div>
                        </h3>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

<?php } ?>