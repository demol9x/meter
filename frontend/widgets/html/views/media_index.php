<?php 
use yii\helpers\Url;
$new_cats = \common\models\news\NewsCategory::find()->where(['show_in_home' => 1, 'status' => 1])->limit(5)->orderBy('order ASC')->all();
$new_right = \common\models\news\NewsCategory::find()->where(['show_home_right' => 1, 'status' => 1])->orderBy('order ASC')->one();
?>
<link href="<?= Yii::$app->homeUrl ?>css/style-news.css" rel="stylesheet">

<div class="news-index news-index2">
    <div class="container">
        <div class="content-news2">
            <?php 
                echo \frontend\widgets\news\NewsWidget::widget([
                        'limit' => 13,
                        'ishot' => 1,
                        'view' => 'hot_index',
                    ]);
            ?>
            <div class="col-right-news2">
                <?php 
                    echo \frontend\widgets\videoAttr\VideoAttrWidget::widget([
                            'attr' => [
                                'category_id' => 1,
                                'homeslide' => 1
                            ],
                            'limit' => 5,
                            'view' => 'home_fix'
                        ]);
                ?>

                <?php
                    foreach ($new_cats as $new) if($new) {
                        echo \frontend\widgets\news\NewsWidget::widget([
                                'limit' => 5,
                                'category_id' => $new->id,
                                'view' => 'home_right',
                            ]);

                    } 
                ?>
            </div>
        </div>
    </div>
</div>