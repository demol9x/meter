<?php 
    $siteinfo = common\components\ClaLid::getSiteinfo();
?>
<div id="main">
    <div class="shopping-cart-page">
        <section id="address-ship" class="address-ship">
            <div class="container">
                <div class="box-shadow-payment">
                    <div class="ctn-page-dhtc">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                                <div class="img">
                                    <img src="<?= Yii::$app->homeUrl ?>images/cart.png" alt="">
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                <div class="info">
                                    <div class="title-page-dhtc">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <h2><?= Yii::t('app', 'order_sussecces') ?></h2>
                                                <em><?= Yii::t('app', 'order_sussecces_text_1') ?> <b>OR<?= $_GET['id'] ?></b></em>
                                                <br/>
                                                <em><?= Yii::t('app', 'Key') ?>: <b><?= $_GET['key'] ?></b></em>
                                                <br/>
                                                <i style="color: red"><?= Yii::t('app', 'order_sussecces_text_1_1') ?></i>
                                            </div>
                                            <?php if(isset($src) && $src) { ?>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                    <img style="float: right" atl="mã qr" src="<?= $src  ?>">
                                                    <p style="clear: both; color: red;text-align: right;">Vui lòng sử dụng mã QR ở trên để thanh toán cho đơn hàng.</p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        
                                    </div>
                                   <!--  <p>
                                        Chúng tôi sẽ giao hàng cho bạn trong vòng 1 - 3 ngày làm việc
                                    </p> -->
                                    <p>
                                        <?= Yii::t('app', 'order_sussecces_text_2') ?> <a href="tel:<?= $siteinfo->phone ?>"> <?= $siteinfo->phone ?> </a>
                                    </p>
                                    <p>
                                        <?= Yii::t('app', 'order_sussecces_text_3') ?><a href="<?= \yii\helpers\Url::to(['/management/order/view']) ?>"><?= Yii::t('app', 'click_here') ?></a>
                                    </p>
                                    <span><?= Yii::t('app', 'order_sussecces_text_4') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>