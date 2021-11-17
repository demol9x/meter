<?php
use common\components\ClaLid;
use yii\helpers\Url;
?>
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner-main',
    'group_id' => 1,
])
?>

<div class="site51_pro_col12_goithau">
    <div class="product_index">
        <div class="container_fix">
            <?php //product all
            echo frontend\widgets\package\PackageWidget::Widget([
                'view' => 'view_hot',
                'limit' => 10,
            ])
            ?>
            <?php //DOANH NGHIỆP
            echo frontend\widgets\shop\ShopWidget::widget([
                'view' => 'view_hot',
                'limit' => 10,
            ])
            ?>
            <?php //Tìm thợ
            echo frontend\widgets\user\UserWidget::widget([
                'view' => 'view',
                'limit' => 10,
            ])
            ?>
            <?php //view thiết bị
            echo frontend\widgets\device\DeviceWidget::widget([
                'view' => 'view',
                'limit' => 10,
            ])
            ?>
        </div>
    </div>
</div>
<?php // hot news
echo frontend\widgets\news\NewsWidget::Widget([
    'view' => 'hot_index',
    'limit' => 8,
    'ishot'=>1,
    'category_id'=>1,
])
?>

<div class="site51_html_col0_taiappmeter" style="background-image: url('<?= yii::$app->homeUrl?>images/taiappmeter.png');">
    <div class="container_fix">
        <h2 class="title-icon title_30">TẢI APP METER NGAY</h2>
        <p class="content_16">Để tận hưởng một trải nghiệm hoàn toàn mới.</p>
        <div class="link_app">
            <a href="" class="btn-app "><img src="<?= yii::$app->homeUrl?>images/button1.png" alt=""></a>
            <a href="" class="btn-app "><img src="<?= yii::$app->homeUrl?>images/button2.png" alt=""></a>
        </div>
    </div>
</div>
</div>
