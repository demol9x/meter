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
    'category_id'=>20,
])
?>
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner_qc_mobile',
    'group_id' => 19,
    'limit'=>1,
])
?>

