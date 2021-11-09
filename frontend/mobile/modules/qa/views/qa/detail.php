<?php 
use common\components\ClaHost;
?>
<div class="ctn-trick-faq">
    <h2 class="title-blog-detail">
        <?= $title = $model['title'] ?>
    </h2>
    <span class="newstime"> <?= date('d/m/Y h:i', $model['publicdate']) ?></span>
    <div class="content-standard-ck">
        <?= $model['description'] ?>
    </div>
   <!--  <div class="hastag">
        <div class="tags"><i class="fa fa-tags" aria-hidden="true"></i><?= Yii::t('app','tag') ?></div>
        <div class="tags_product">
            <?php 
                $tags =  explode(',', $model['meta_keywords']);
                if($tags && $tags[0] != null) foreach ($tags as $key => $value) {?>
                <a target="_blank" class="tag_title" title="<?= $value ?>" href="<?= \yii\helpers\Url::to(['/site/search', 'tag' => $value, 'type' => 2]) ?>"> <?= $value ?></a>
            <?php } else {?>
                <a target="_blank" class="tag_title" title="<?= $title ?>" href="<?= \yii\helpers\Url::to(['/site/search', 'tag' => $title, 'type' => 2]) ?>"> <?= $title ?></a>
            <?php } ?>
        </div>
    </div> -->
    <div class="comment-fb-blog">
        <?=
            frontend\widgets\facebookcomment\FacebookcommentWidget::widget([
            ]);
        ?>
    </div>
</div>