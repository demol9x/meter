<?php
use yii\helpers\Url;
use common\components\ClaHost;
?>
<style type="text/css">
    .item-ul h5 i {
        color: #203468;
        margin-right: 7px;
    }
    .new-sales h5 {
        margin: 10px 0px;
    }
</style>
<h3  class="gc"><?= $title ?></h3>
<div class="new-sales">
    <div class="item">
        <?php 
            $kt=1;
            if(count($news)) {
                foreach ($news as $new) {
                    $newtitle = Trans($new['title'], $new['title_en']);
                    $link =  Url::to(['/news/news/detail', 'id' => $new['id'], 'alias' => $new['alias']]);
                    if($kt) { $kt=0;
                        ?>
                        <div class="item-news-sales">
                            <div class="img-news-sales">
                                <a href="<?= $link ?>">
                                <img class="hover-img" src="<?= ClaHost::getImageHost(), $new['avatar_path'], 's500_500/', $new['avatar_name'] ?>" alt="<?= $newtitle ?>" title="<?= $newtitle ?>">
                            </a>
                            </div>
                            <div class="title-news-sales">
                                <h5>
                                    <a href="<?= $link ?>"><?= $newtitle ?></a>
                                </h5>
                            </div>
                        </div>
                    <?php 
                        } else { ?> 
                        <div class="item-ul">
                            <h5><a href="<?= $link ?>"><i class="fa fa-caret-right"></i> <?= $newtitle ?></a></h5>
                        </div>
                    <?php }
                }
            } 
        ?>
    </div>
</div>
