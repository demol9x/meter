<?php

use yii\helpers\Url;
use frontend\models\User;
use common\models\shop\Shop;

$siteinfo = common\components\ClaLid::getSiteinfo();
$user = User::findIdentity(Yii::$app->user->getId());
$shop = Shop::findOne(Yii::$app->user->getId());
?>
<?php if (!\common\components\ClaSite::isActiceApp()) { ?>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v8.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <style>
        .fb-customerchat>span iframe {
            height: 0px;
        }
    </style>

    <!-- Your Chat Plugin code -->
    <div class="fb-customerchat" attribution=setup_tool page_id="105608157940014" theme_color="#ff7e29" logged_in_greeting="Xin chào! Chúng tôi có thể giúp gì cho bạn!" logged_out_greeting="Xin chào! Chúng tôi có thể giúp gì cho bạn!">
    </div>
<?php } ?>

<?php if (!\common\components\ClaSite::isMobile() || (Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id == 'site')) { ?>
    <div id="header">
        <div class="top-header">
            <div class="container">
                <div class="flex-row">
                    <div class="flex-col flex-left left-top-header">
                        <!-- <a href="">Tải app GCA</a> -->
                        <a href="<?= Url::to(['/site/sell-with-gca']) ?>"><?= Yii::t('app', 'sale_with_gca') ?></a>
                        <!-- <div class="drop-header"> -->
                        <a href="<?= __SERVER_NAME ?>/dang-ky.html"><i class="fa fa-id-card-o" aria-hidden="true"></i><?= Yii::t('app', 'membership_card') ?>
                        </a>
                        <?php // \frontend\widgets\menu\MenuWidget::widget(['view' => 'ul', 'group_id' => 8]) 
                        ?>
                        <!-- </div> -->
                        <a href="<?= Yii::t('app', 'gca_global_url') ?>" target="_blank"><?= Yii::t('app', 'gca_global'); ?></a>
                    </div>
                    <div class="flex-col flex-right right-top-header">
                        <!--  <a href=""><i class="fa fa-life-ring" aria-hidden="true"></i>Chăm sóc khách hàng</a> -->
                        <?= \frontend\widgets\notifications\NotificationsWidget::widget() ?>
                        <?php
                        $user = \frontend\models\User::findIdentity(Yii::$app->user->getId());
                        if (isset($user)) {
                            $wish_list = \common\models\product\ProductWish::countByUser();
                            if ($user && $user->avatar_name) {
                                $image_u = \common\components\ClaHost::getImageHost() . $user->avatar_path . $user->avatar_name;
                            } else {
                                $image_u = \common\components\ClaHost::getImageHost() . '/imgs/user_default.png';
                            }
                        ?>
                            <a class="wish-list" href="<?= Url::to(['/wish/index']) ?>">
                                <i class="fa fa-heart"></i><?= Yii::t('app', 'likes') ?>
                                <?php if ($wish_list) { ?>
                                    <span class="wish-list-index"><?= $wish_list ?></span>
                                <?php } ?>
                            </a>
                            <a href="<?= Url::to(['/management/order/view']) ?>"><i class="fa fa-file-text" aria-hidden="true"></i><?= Yii::t('app', 'check_order') ?>
                            </a>
                            <div class="box-dropdown">
                                <a><img src="<?= $image_u ?>" alt=""> <?= $user->username ?></a>
                                <div class="show-ctn">
                                    <a href="<?= Url::to(['/management/profile/index']) ?>">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <?= Yii::t('app', 'user_info') ?>
                                    </a>
                                    <a href="<?= Url::to(['/management/product/index']) ?>">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                        <?= Yii::t('app', 'shop_info') ?>
                                    </a>
                                    <a href="<?= Url::to(['/management/gcacoin/index']) ?>">
                                        <?php
                                        $coin = \common\models\gcacoin\Gcacoin::findOne(Yii::$app->user->id);
                                        $history_warning = \common\models\gcacoin\WithDraw::find()->where(['user_id' => Yii::$app->user->id, 'status' => 0])->all();
                                        $coin_waning = 0;
                                        if (isset($history_warning) && $history_warning) {
                                            foreach ($history_warning as $his) {
                                                $coin_waning += $his->value;
                                            }
                                        }
                                        ?>
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                        Voucher (<b style="color: #dbbf6d"><?= (isset($coin->gca_coin) && $coin->gca_coin) ? number_format((float)\common\components\ClaGenerate::decrypt($coin->gca_coin) - $coin_waning) : 0 ?></b>
                                        V)
                                    </a>
                                    <a href="<?= Url::to(['/site/logout']) ?>">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                                        <?= Yii::t('app', 'logout') ?>
                                    </a>
                                </div>
                            </div>
                        <?php } else { ?>
                            <a class="open-popup-link" href="#login-box-popup"><i class="fa fa-lock" aria-hidden="true"></i><?= Yii::t('app', 'login') ?>
                            </a>
                            <a href="<?= Url::to(['/login/login/signup']) ?>"><i class="fa fa-key" aria-hidden="true"></i><?= Yii::t('app', 'signup') ?>
                            </a>
                        <?php } ?>
                        <a class="ocopmart" target="_blank">
                            <img src="<?= $siteinfo->logo ?>" alt="OCOP Partner">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php if (1) { ?>
            <form action="<?= Url::to(['/search/search/router']) ?>" id="form-top">
                <div class="bottom-header">
                    <div class="container">
                        <div class="flex-row">
                            <div class="flex-col flex-left logo">
                                <a href="<?= Yii::$app->homeUrl ?>"><img src="<?= $siteinfo->logo ?>" alt="logo" title="<?= $siteinfo->title ?>" /></a>
                            </div>
                            <?=
                                \frontend\widgets\productSearch\ProductSearchWidget::widget([
                                    'view' => 'search_top',
                                ])
                            ?>
                            <?php
                            echo \frontend\widgets\productSearch\ProductSearchWidget::widget([
                                'view' => 'search_top_mobile',
                            ])
                            ?>

                            <div id="nav-icon1" class="cd-dropdown-trigger visible-xs visible-sm hidden-md hidden-lg">
                                <span></span> <span></span> <span></span></div>
                        </div>
                    </div>
                </div>
                <?=
                    \frontend\widgets\productSearch\ProductSearchWidget::widget([
                        'view' => 'advance_search',
                    ])
                ?>
            </form>
        <?php } ?>
    </div>
<?php } ?>