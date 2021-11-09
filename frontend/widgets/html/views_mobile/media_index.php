<?php 
use yii\helpers\Url;
$new_cats = \common\models\news\NewsCategory::find()->where(['show_in_home' => 1, 'status' => 1])->limit(5)->orderBy('order ASC')->all();
$new_right = \common\models\news\NewsCategory::find()->where(['show_home_right' => 1, 'status' => 1])->orderBy('order ASC')->one();
?>
<link href="<?= Yii::$app->homeUrl ?>css/style-news.css" rel="stylesheet">
<div class="news-index news-index2">
    <div class="container">
        <div class="title-news2">
            <ul>
                <?php if($new_cats) { 
                    foreach ($new_cats as $item) { 
                    ?>
                    <li>
                        <a href="<?= Url::to(['/news/news/category', 'id' => $item->id, 'alias' => $item->alias]) ?>"><?= $item->name ?></a>
                    </li>
                    <?php }
                } ?>
                <li>
                        <a href="<?= Url::to(['/media/video/index']) ?>">Video</a>
                    </li>
            </ul>
        </div>
        <div class="content-news2">
            <?php 
                echo \frontend\widgets\news\NewsWidget::widget([
                        'limit' => 10,
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
            </div>
        </div>
    </div>
</div>