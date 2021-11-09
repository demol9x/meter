<?php

use yii\helpers\Url;
use common\components\ClaHost;
if (isset($news) && $news) { 
    foreach ($news as $new) {
        $newtitle = Trans($new['title'], $new['title_en']);
        $link =  Url::to(['/news/news/detail', 'id' => $new['id'], 'alias' => $new['alias']]);
        ?>
        <div class="box-left">
            <div class="text">
                <h3><a href="<?= $link ?>"><?= $newtitle ?></a></h3>
                <div class="content">
                       <?= Trans($new['short_description'],$new['short_description_en']) ?>
                </div>
            </div>
            <div class="text-center">
                <a href="<?= $link ?>" class="btn btn-primary"><?= Yii::t('app', 'view_detail') ?></a>
            </div>
        </div>
    <?php } 
} ?>