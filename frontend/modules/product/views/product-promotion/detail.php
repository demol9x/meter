<?php
date_default_timezone_set("Asia/Bangkok");
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
$list_time = explode(' ', $promotion->time_space);
$hour_next = count($list_time) > 1 ? $promotion->getHourAfter($promotion->getHourNow()) : $promotion->enddate;
?>
<style type="text/css">
    .tab-cate-product ul li h2 {
        font-size: 13px;
        color: #000;
        font-weight: 400;
    }
    .promotion-list {
        padding: 7px;
    }
    body .promotion-list:hover img {
        transform: scale(1);
    }
    .banner-inpage a{
        display: block;
        max-height: 300px;
        overflow: hidden;
    }
    .box-tabcate-index {
        margin-bottom: 0px;
    }
    .tab-cate-product > h2:before {
        content: unset;
    }
    .tab-cate-product > h2 {
        background: unset;
    }
    .tab-cate-product ul {
        margin-left: 210px;
    }
    .tab-cate-product > h2 {
        width: unset; 
    }
    #countdown * {
        background: unset !important;
        color: red  !important;
        font-size: 20px !important;
    }
    .img-top {
        margin-top: 7px;
    }
    .text-top {
        font-size: 17px;
        margin-top: 10px;
        font-weight: bold;
        margin-left: 6px;
        color: #aeb127;
        text-transform: uppercase;
    }
    .item-product-inhome .price {
        font-weight: bold;
        font-size: 17px;
    }
</style>

<div class="product-promotion-top">
    <div class="container center">
        <div style="display: inline-block;">
            <img src="<?= Yii::$app->homeUrl ?>images/flas.png" class="left img-top" alt="">
            <span class="left text-top"><i class="fa fa-clock-o" aria-hidden="true"></i> Kết thúc sau: </span>
            <div class="time" id="countdown"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
            var myDate = new Date();
            myDate.setSeconds(myDate.getSeconds() + <?= $hour_next - time() ?>);
            $("#countdown").countdown(myDate, function (event) {
                $(this).html(
                    event.strftime(
                        '<?= count($list_time) > 1 ? '<span><b>%H</b></span><span><b>%M</b></span><span><b>%S</b></span>' : '<span><b>%D</b></span><span><b>%H</b></span><span><b>%M</b></span><span><b>%S</b></span>' ?> '
                    )
                );
                if(event['offset']['minutes'] == 0 && event['offset']['hours']==0 && event['offset']['seconds']==0) {
                    location.reload();
                };
            });
        });
</script>
<div class="banner-inpage">
    <div class="container">
       <a title="banner-trong">
            <img src="<?= ClaHost::getImageHost(), $promotion['image_path'], $promotion['image_name'] ?>" alt="">
        </a>
    </div>
</div>
<?php if(count($list_time) > 1) { ?>
    <div class="product-inhome box-promotion-time-sapce">
        <div class="container">
            <div class="tab-cate-product">
                <ul class="slide-tab-cate owl-carousel owl-theme">
                    <?php 
                    $kt= 1; 
                    for ($i=0; $i < count($list_time); $i++) 
                        if( (!isset($list_time[$i+1])) || (isset($list_time[$i+1]) && $list_time[$i+1] > date('H',time()))) { ?>
                        <li style="<?= isset($_GET['hour']) ? (($_GET['hour'] == $list_time[$i]) ? "background: #ebebeb" : '') : ($kt ? "background: #ebebeb" : ''); ?>" class="list-time-promotion">
                            <a href="<?= Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias, 'time' => \common\models\promotion\ProductToPromotions::getTimeSpaceStart($list_time[$i], date('d-m-Y', time())), 'hour' => $list_time[$i]]) ?>">

                                <div class="img">
                                    <div class="vertical">
                                        <div class="middle">
                                            <?= $list_time[$i] ?>:00
                                        </div>
                                    </div>
                                </div>
                                <h2>
                                   <?= ($kt) ? "Đang diễn ra" : 'Sắp diễn ra' ?>
                                </h2>
                            </a>
                        </li>
                    <?php $kt=0;} 
                    for ($i=0; $i < count($list_time); $i++)
                        if(!((!isset($list_time[$i+1])) || (isset($list_time[$i]) && $list_time[$i+1] > date('H',time())))) { ?>
                        <li style="<?= isset($_GET['hour']) ? (($_GET['hour'] == $list_time[$i]) ? "background: #ebebeb" : '') : ($kt ? "background: #ebebeb" : ''); ?>" class="list-time-promotion">
                            <a href="<?= Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias, 'time' => \common\models\promotion\ProductToPromotions::getTimeSpaceStart($list_time[$i], date('d-m-Y', time()+60*60*24)), 'hour' => $list_time[$i]]) ?>">

                                <div class="img">
                                    <div class="vertical">
                                        <div class="middle">
                                            <?= $list_time[$i] ?>:00
                                        </div>
                                    </div>
                                </div>
                                <h2>
                                   Ngày mai
                                </h2>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>
<div class="section-product">
    <div class="container">
        <div class="product-in-promotion">
            <div class="row-5-flex multi-columns-row">
                <?php if (isset($data) && $data) { 
                    if(isset($_GET['hour']) && $_GET['hour'] != $promotion->getHourNow()) {
                        echo frontend\widgets\html\HtmlWidget::widget([
                            'input' => [
                                'products' => $data,
                                'div_col' => '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 promotion-list">'
                            ],
                            'view' => 'view_product_promotion_not_now'
                        ]);
                    } else {
                        echo frontend\widgets\html\HtmlWidget::widget([
                            'input' => [
                                'products' => $data,
                                'div_col' => '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 promotion-list">'
                            ],
                            'view' => 'view_product_promotion'
                        ]);
                    }
                    
                } else { ?>
                        <div class="col-lg-5-12-item" style="padding: 20px;">
                            <?= Yii::t('app', 'havent_product') ?>
                        </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>