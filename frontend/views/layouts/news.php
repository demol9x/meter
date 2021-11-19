<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\components\ClaLid;
use frontend\assets\AppAsset;


AppAsset::register($this);
$siteinfo = common\components\ClaLid::getSiteinfo();
?>
<?php $this->beginPage()?>
    <!DOCTYPE html>
    <html lang="<?=Yii::$app->language?>">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?=$this->title?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="<?=$siteinfo->favicon?>" />
        <script src="<?= yii::$app->homeUrl?>js/jquery-3.6.0.js"></script>
        <?php $this->head()?>

    </head>
    <body>
    <?php $this->beginBody()?>

    <?php echo $this->render('partial/header', ['siteinfo' => $siteinfo]) ?>


    <div class="container_fix">
        
        <div class="tintuc">
            <div class="tintuc__center">
                <div id="tintucchung" class="content-tab">
                    <h2 class="title_30">tin tức chung</h2>
                    <div class="main-tintuc">

                            <div class="item-tintuc wow fadeInUp" data-wow-delay="">
                                <div class="item-img">
                                    <a href=""><img src="" alt=""></a>
                                    <div class="date">
                                        <time class="content_14"><span>03</span><br>08/2021</time>
                                    </div>
                                </div>
                                <div class="item-text">
                                    <a href="">
                                        <h4 class="title_20"></h4>
                                    </a>
                                    <p class="content_16"></p>
                                    <div class="flex-text">
                                        <p class="content_14"><span>Đăng bởi: </span>Admin</p>
                                        <p class="content_14"><span>Category: </span>Tin tức chung </p>
                                        <p class="content_14"><span>Bình luận: </span>0</p>
                                    </div>
                                    <a href="" class="btn-docthem btn-animation2 content_16">Đọc thêm</a>
                                </div>
                            </div>

                    </div>

                </div>
                <div id="tinthitruong" class="content-tab">
                    <h2 class="title_30">tin thị trường</h2>
                    <div class="main-tintuc">

                            <div class="item-tintuc">
                                <div class="item-img">
                                    <a href=""><img src="" alt=""></a>
                                    <div class="date">
                                        <time class="content_14"><span>03</span><br>08/2021</time>
                                    </div>
                                </div>
                                <div class="item-text">
                                    <h4 class="title_20"></h4>
                                    <p class="content_16"></p>
                                    <div class="flex-text">
                                        <p class="content_14"><span>Đăng bởi: </span>Admin</p>
                                        <p class="content_14"><span>Category: </span>Tin tức chung </p>
                                        <p class="content_14"><span>Bình luận: </span>0</p>
                                    </div>
                                    <a href="" class="btn-docthem btn-animation2 content_16">Đọc thêm</a>
                                </div>
                            </div>

                    </div>

                </div>
                <div id="tingoithau" class="content-tab">
                    <h2 class="title_30">tin gói thầu</h2>
                    <div class="main-tintuc">

                            <div class="item-tintuc">
                                <div class="item-img">
                                    <a href=""><img src="" alt=""></a>
                                    <div class="date">
                                        <time class="content_14"><span>03</span><br>08/2021</time>
                                    </div>
                                </div>
                                <div class="item-text">
                                    <h4 class="title_20"></h4>
                                    <p class="content_16"></p>
                                    <div class="flex-text">
                                        <p class="content_14"><span>Đăng bởi: </span>Admin</p>
                                        <p class="content_14"><span>Category: </span>Tin tức chung </p>
                                        <p class="content_14"><span>Bình luận: </span>0</p>
                                    </div>
                                    <a href="" class="btn-docthem btn-animation2 content_16">Đọc thêm</a>
                                </div>
                            </div>

                    </div>
                </div>

                <div id="trainghiem" class="content-tab">
                    <h2 class="title_30">trải nghiệm và chia sẻ</h2>
                    <div class="main-tintuc">

                            <div class="item-tintuc">
                                <div class="item-img">
                                    <a href=""><img src="" alt=""></a>
                                    <div class="date">
                                        <time class="content_14"><span>03</span><br>08/2021</time>
                                    </div>
                                </div>
                                <div class="item-text">
                                    <h4 class="title_20"></h4>
                                    <p class="content_16"></p>
                                    <div class="flex-text">
                                        <p class="content_14"><span>Đăng bởi: </span>Admin</p>
                                        <p class="content_14"><span>Category: </span>Tin tức chung </p>
                                        <p class="content_14"><span>Bình luận: </span>0</p>
                                    </div>
                                    <a href="" class="btn-docthem btn-animation2 content_16">Đọc thêm</a>
                                </div>
                            </div>

                    </div>
                </div>

            </div>
            <div class="tintuc__left">
                <div class="tab-tintuc">
                    <a class="back"></a>
                    <nav class="van-tabs">
                        <label id="tintucchung" class="active content_16"><a href="" id="tintucchung"></a>tin tức chung</label>
                        <label id="tinthitruong" class="content_16"><a href="" id="tinthitruong"></a>tin thị trường</label>
                        <label id="tingoithau" class="content_16"><a href="" id="tingoithau"></a>tin gói thầu</label>
                        <label id="trainghiem" class="content_16"><a href="" id="trainghiem"></a>TRẢI NGHIỆM & CHIA SẺ</label>
                    </nav>
                    <a class="continue"></a>
                </div>
                <div class="tinkhac">
                    <h3 class="title_24">Bài viết nổi bật</h3>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="asset/img/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="asset/img/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="asset/img/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="asset/img/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="asset/img/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php echo $this->render('partial/footer', ['siteinfo' => $siteinfo]) ?>

    <?php $this->endBody()?>
    </body>

    </html>
<?php $this->endPage()?>