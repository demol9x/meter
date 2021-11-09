<?php
date_default_timezone_set("Asia/Bangkok");
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
$list_time = explode(' ', $promotion->time_space);
$hour_next = $promotion->getHourAfter($promotion->getHourNow());
$category  = \common\models\product\ProductCategory::find()->where(['parent' => 0])->orderBy('order')->all();
$list_cat = [];
if($category) {
    foreach ($category as $cat) {
        $list_cat[$cat['id']] = $cat;
    }
}
$list = [];
if($data) {
    foreach ($data as $product) {
        $list[ \common\models\product\ProductCategory::getParentMost($product['category_id'])][] = $product;
    }
}
?>
<style>
    .olw-promotion {
        clear: both;
    }
    img{
        max-width: 100%;
    }
    .section{
        float: left;
        width: 100%;
    }
    .landing-page{
        float: left;
        width: 100%;
        overflow-x: hidden;
        font-family: 'Roboto', sans-serif;
    }
    .section02{
        position: relative;
        overflow: hidden;
    }
    .bg-img{
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }
    .bg-img img{
        height: 100%;
        min-width: 100%;
        object-fit: cover;
        object-position: center ;
    }
    .content-section2{
        position: relative;
        padding: 180px 0px 120px 0;
        max-width: 750px;
        float: left;
        width: 100%;
    }
    .content-section2 h2{
        color: #588528;
        font-size: 55px;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 30px;
    }
    .landing-page #countdown span::after{
        margin-top: 20px;
        margin-left: -30px;
    }
    .landing-page #countdown span{
        float: left;
        margin-right: 15px;
    }
    .landing-page #countdown span b{
        float: left;
        width: 80px;
        height: 70px;
        border: 1px solid #5f5f5f;
        line-height: 70px;
        text-align: center;
        font-size: 40px;
        color: #588528;
    }
    .landing-page #countdown span em{
        float: left;
        width: 100%;
        margin-top: 10px;
        text-transform: uppercase;
    }
    .content-section2 p{
        float: left;
        width: 100%;
        margin-top: 20px;
        font-size: 17px;
        line-height: 23px;
        font-weight: 400;
    }
    .section03{
        background: #17a349;
        padding: 40px 0;
    }
    .content-section03 {
        float: left;
        width: 60%;
        text-align: left;
        margin-top: 50px;
        font-size: 25px;
        color: #fff;
        line-height: 38px;
        padding-right: 40px;
    }
    .content-section03 h2{
        color: #fff;
        font-size: 55px;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 30px;
    }
    .img-section03{
        float: right;
        width: 40%;
    }
    .section04{
        padding: 60px 0;
        background: #f2f2f0;
    }
    .section05{
        padding: 60px 0;
        background: #ffca05;
    }
    .video-player{
        float: right;
        width: 50%;
    }
    .content-section05{
        float: left;
        width: 50%;
        text-align: center;
        margin-top: 10px;
        font-size: 18px;
        color: #fff;
        line-height: 26px;
        padding-right: 40px;
    }
    .content-section05 h2{
        color: #fff;
        font-size: 35px;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .list-product{
        float: left;
        width: 100%;
        background: #f1f1f1;
    }
    .list-product > h2 {
        float: left;
        width: 100%;
        text-align: center;
        font-size: 30px;
        text-transform: uppercase;
        color: #588528;
        font-weight: 700;
        background: #fff;
        margin: 0;
        padding-bottom: 25px;
        padding-top: 25px;
        margin-bottom: 40px;
    }
    .item-product-lp {
        float: left;
        width: 100%;
        box-shadow: 0px 1px 10px #ccc;
        margin-bottom: 30px;
        text-align: center;
        margin-top: 6px;
    }
    .item-product-lp h3{
        margin: 20px 0;

    }
    .item-product-lp h3 a{
        color: #000;
        font-weight: 400;
        text-transform: uppercase;
        font-size: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 48px;
        padding-top: 3px;
    }
    .img-product-lp{
        padding: 0px 20px ;
        margin-bottom: 15px;
    }
    .img-product-lp a{
        height: 247px;
        display: block;
        overflow: hidden;
    }
    .view-more{
        float: left;
        width: 100%;
        margin: 15px 0;
    }
    .view-more a{
        background: #e2e2e2;
        padding: 10px 20px 8px 20px;
        display: inline-block;
        border-radius: 6px;
        color: #17a34a;
    }
    .view-more a:hoveR{
        background: #17a34a;
        color: #fff;
    }
    .video-player iframe{
        width: 100%;
    }
    @media (max-width: 992px){
        .content-section03 {
            width: 100%;
            text-align: center;
            padding-right: 0;
        }
        .img-section03{
            width: 100%;
            text-align: center;
        }
        .content-section05 {
            width: 100%;
            padding-right: 0;
        }
        .video-player{
            width: 100%;
            margin-bottom: 30px;
        }
    }
    @media (max-width: 767px){
        .content-section03 h2, .content-section2 h2 {
            font-size: 35px;
        }
        .content-section03{
            font-size: 19px;
        }
        .landing-page #countdown span{
            margin-right: 10px;
            width: 80px;
        }
        .landing-page #countdown span b{
            float: left;
            width: 60px;
            height: 50px;
            line-height: 50px;
            font-size: 30px;
        }
        .content-section2 {
            position: relative;
            padding: 60px 0px 60px 0;
        }
    }
    @media (max-width: 500px){
        .list-product .col-xs-6{
            width: 100%;
        }
        .list-product > h2{
            font-size: 25px;
        }
        .content-section03 h2 , .content-section05 h2, .content-section2 h2{
            font-size: 25px;
        }
    }
    @media (max-width: 420px){
        .landing-page #countdown span{
            margin-right: 10px;
            width: 55px;
        }
        .landing-page #countdown span b{
            float: left;
            width: 45px;
            height: 45px;
            line-height: 45px;
            font-size: 20px;
        }
    }
</style>
<div class="main">
    <div class="landing-page">
        <div class="section banner-section01">
            <?=
                \frontend\widgets\banner\BannerQcWidget::widget([
                    'view' => 'aimg',
                    'group_id' => 11,
                    'stt' => 1,
                    'limit' => 1
                ])
            ?>
        </div>
        <div class="section section02">
            <div class="bg-img">
                <img src="<?= Yii::$app->homeUrl ?>images/bg-section02.jpg" alt="">
            </div>
            <div class=" container">
                <div class="content-section2">
                    <h2>
                        Thời gian còn lại
                    </h2>
                    <div class="box-count-time">
                        <div class="time" id="countdown"></div>
                    </div>
                    <p>
                        <?= $promotion->sortdesc ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="section section03">
            <div class="container">
                <div class="img-section03">
                    <img src="<?= Yii::$app->homeUrl ?>images/catoon01.png" alt="">
                </div>
                <div class="content-section03">
                    <a href="/ve-chung-toi.html">
                        <h2>
                            về chúng tôi
                        </h2>
                    </a>
                    <p>
                        Công ty GPC là một doanh nghiệp công nghệ & Fintech hoạt động chủ yếu trong lĩnh vực thương mại điện tử với sản phẩm sàn thương mại điện tử ocopmart.org và App ứng dụng trên các nền tảng. Tại đây, chúng tôi đóng vai trò là sản phẩm công nghệ làm trung gian kết nối tất cả các giao dịch mua, bán các mặt hàng nông sản, thực phẩm sạch, vật tư phụ kiện và các dịch vụ phục vụ chuỗi cung ứng nông nghiệp của rất nhiều đối tác trong và ngoài nước.
                    </p>
                </div>
            </div>
        </div>
        <div class="section section04">
            <img src="<?= Yii::$app->homeUrl ?>images/bg-section03.jpg" alt="">
        </div>
        <div class="section section05">
            <div class="container">
                <div class="video-player">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/U1JIQAOUJaM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="content-section05">
                    <h2>
                        video về sản phẩm
                    </h2>
                    <p>
                        OCOP ( Global Clean Agriculture) là dự án được phát triển dựa nên nền tảng Blockchain tích hợp công nghệ IoT, Bigdata, E-Commerce phát triển các sản phẩm và ứng dụng phi tập trung ( Dapp) dựa trên nền tảng OCOP - Blockchain như ví, tiền mã hóa (Voucher), hợp đồng thông minh, ứng dụng truy xuất hành trình sản phẩm, ứng dụng và sàn thương mại điện tử giúp kết nối người mua, người bán các mặt hàng nông thủy hải sản sạch trong chuỗi cung ứng nông nghiệp sạch toàn cầu.
                    </p>
                </div>
            </div>
        </div>
        <div class="section section06">
            <img src="<?= Yii::$app->homeUrl ?>images/bg-section04.jpg" alt="">
        </div>
        <?php if($category) foreach ($category as $tg) if(isset($list[$tg['id']]) && $list[$tg['id']]) { ?>
            <div class="list-product">
                <h2>
                    <?=  $list_cat[$tg['id']]['name']  ?>
                </h2>
                <div class="container">
                    <div class="row multi-columns-row">
                        <div class="olw-promotion owl-carousel owl-theme">
                            <?php foreach ($list[$tg['id']] as $product) { 
                                $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                                ?>
                                <div class="item-promotion">
                                    <div class="item-product-lp">
                                        <h3>
                                            <a href="<?= $url ?>"><?= $product['name'] ?></a>
                                        </h3>
                                        <div class="img-product-lp">
                                            <a href="<?= $url ?>" >
                                                <img class="lazy" data-src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's300_300/', $product['avatar_name'] ?>" alt="<?= $product['name'] ?>" />
                                            </a>
                                        </div>
                                        <div class="view-more">
                                            <a href="<?= $url ?>" >Xem chi tiết <i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php  } ?>
    </div>
    <?=
    \frontend\widgets\html\HtmlWidget::widget([
        'view' => 'map-home',
        'input' => [
            'zoom' => 12
        ]
    ])
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var myDate = new Date();
        myDate.setSeconds(myDate.getSeconds() + <?= $promotion->enddate - time() ?>);
        $("#countdown").countdown(myDate, function (event) {
            $(this).html(
                event.strftime(
                    '<span><b>%D</b><em>Ngày</em></span><span><b>%H</b><em>Giờ</em></span><span><b>%M</b><em>Phút</em></span><span><b>%S</b><em>Giây</em></span>'
                )
            );
            if(event['offset']['minutes'] == 0 && event['offset']['hours']==0 && event['offset']['seconds']==0) {
                alert('Chương trình đã kết thúc');
            };
        });

        $('.olw-promotion').owlCarousel({
        items: 4,
        loop: false,
        margin: 10,
        merge: true,
        dots:false,
        nav:true,
        responsive: {
            0:{
                items:1,
                margin: 10,
            },
            350:{
                items:1,
                margin: 10,
            },
            600:{
                items:2,
                margin: 10,
            },
            767:{
                items:3,
                margin: 10,
            },
            992:{
                items:3,
                margin: 10,
            },
            1200:{
                items:4,
                margin: 10,
            }
        }
    });
    });
</script>
