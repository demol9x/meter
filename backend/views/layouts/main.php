<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\Siteinfo;
//
use backend\modules\auth\components\Helper;

$siteinfo = Siteinfo::findOne(Siteinfo::ROOT_SITE_ID);
AppAsset::register($this);
$notification = \common\models\NotificationAdmin::findOne(1);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?= $siteinfo->favicon ?>" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script type="text/javascript">
        var baseUrl = '<?= Yii::$app->homeUrl ?>';
    </script>
    <style type="text/css">
        .view-web {
            background: #73879C;
        }

        body .view-web span {
            color: #fff;
        }

        .index {
            position: absolute;
            right: 1px;
            top: 0px;
            display: inline-block;
            background: red;
            padding: 0px 6px;
            font-weight: bold;
            color: #fff;
            border: 1px solid red;
            border-radius: 50%;
        }

        .go-back {
            color: #fff;
            display: inline-block;
            margin-left: 22px;
            padding: 8px 30px;
            background: #bfca59;
            border-radius: 4px;
        }
    </style>
    <?php $this->head() ?>
</head>

<body class="nav-md">
    <?php $this->beginBody() ?>
    <div class="alert">
        <?= $this->render('partial/alert') ?>

    </div>
    <div class="container body">
        <div class="main_container">
            <!--COL LEFT-->
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?php echo Yii::$app->urlManager->baseUrl ?>" class="site_title"><i class="fa fa-paw"></i> <span>Qu???n tr??? website!</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <i style="font-size: 85px;margin-left: 10px;" class="fa fa-user" aria-hidden="true"></i>
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?= isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : '' ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>&nbsp;</h3>
                            <ul class="nav side-menu">
                                <?php if (Helper::checkRoute('/user/user/index') || Helper::checkRoute('/user/shop/index')) { ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-users"></i> <?= Yii::t('app', 'account_management') ?> <span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/user/user/index')) { ?>
                                                <li>
                                                    <a href="<?= Url::to(['/user/user/index']) ?>"><?= Yii::t('app', 'account') ?></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/user/shop/index')) { ?>
                                                <li>
                                                    <a href="<?= Url::to(['/user/shop/index']) ?>"><?= Yii::t('app', 'shop') ?></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/user/tho/index')) { ?>
                                                <li>
                                                    <a href="<?= Url::to(['/user/tho/index']) ?>">Th???</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <!-- Qu???n l?? s???n ph???m, g??i th???u -->
                                <?php if (Helper::checkRoute('/product/product-attribute/index') || Helper::checkRoute('/package/package/index') || Helper::checkRoute('/product/product-category/index') || Helper::checkRoute('/product/product/index')) { ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-product-hunt"></i> <?= Yii::t('app', 'product_management') ?>
                                            <span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/product/product-category/index')) { ?>
                                                <li><?= Html::a('Danh m???c s???n ph???m', ['/product/product-category/index']) ?></li>
                                            <?php } ?>

                                            <?php if (Helper::checkRoute('/product/brand/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? th????ng hi???u', ['/product/brand/index']) ?></li>
                                            <?php } ?>
                                            
                                            <?php if (Helper::checkRoute('/product/optionprice/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? kho???ng gi??', ['/product/optionprice/index']) ?></li>
                                            <?php } ?>

                                            <?php if (Helper::checkRoute('/product/product-attribute/index')) { ?>
                                                <li><?= Html::a('B??? thu???c t??nh', ['/product/product-attribute/index']) ?></li>
                                            <?php } ?>

                                            <?php if (Helper::checkRoute('/product/product/index')) { ?>
                                                <li>
                                                    <a href="<?= Url::to(['/product/product/index']) ?>"><?= Yii::t('app', 'product') ?></a>
                                                </li>
                                            <?php } ?>

                                            <?php if (Helper::checkRoute('/package/package/index')) { ?>
                                                <li><?= Html::a('G??i th???u', ['/package/package/index']) ?></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <!-- rating -->
                                <?php if (Helper::checkRoute('/rating/rating/index') || Helper::checkRoute('/filter-char/index')) { ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-comment"></i> <?= Yii::t('app', 'Qu???n l?? ????nh gi??') ?>
                                            <span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/rating/rating/index')) { ?>
                                                <li>
                                                    <?= Html::a('????nh gi??', ['/rating/rating/index']) ?>
                                                </li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/filter-char/index')) { ?>
                                                <li data="<?= Url::to(['/filter-char/index']) ?>">
                                                    <a href="<?= Url::to(['/filter-char/index']) ?>">L???c t??? x???u</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/voucher/voucher/index')) { ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-product-hunt"></i> 
                                            Qu???n l?? m?? gi???m gi??
                                            <span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/voucher/voucher/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? m?? gi???m gi??', ['/voucher/voucher/index']) ?></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <!--  <?php if (Helper::checkRoute('/product/product-attribte-set/index')) { ?>
                                        <li>
                                            <a><i class="fa fa-product-hunt"></i> Qu???n l?? thu???c t??nh <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if (Helper::checkRoute('/product/product-attribute-set/index')) { ?>
                                                    <li><?= Html::a('Nh??m thu???c t??nh', ['/product/product-attribute-set/index']) ?></li>
                                                <?php } ?>
                                                <?php if (Helper::checkRoute('/product/product-attribute/index')) { ?>
                                                    <li><?= Html::a('Thu???c t??nh', ['/product/product-attribute/index']) ?></li>
                                                <?php } ?>

                                            </ul>
                                        </li>
                                    <?php } ?> -->
                                <?php if (Helper::checkRoute('/order/order/index')) { ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-shopping-cart"></i> <?= Yii::t('app', 'order_management') ?>
                                            <span class="fa fa-chevron-down"></span>
                                            <?= $notification['order'] ? '<span class="index">' . $notification['order'] . '</span>' : '' ?>
                                        </a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/order/order/index')) { ?>
                                                <li data="<?= Url::to(['/site/notification-update', 'attr' => 'order']) ?>">
                                                    <a href="<?= Url::to(['/order/order/index']) ?>"><?= Yii::t('app', 'orders') ?></a>
                                                    <?= $notification['order'] ? '<span class="index">' . $notification['order'] . '</span>' : '' ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php
                                $count = \common\models\form\Contact::find()->where(['viewed' => 0])->count();
                                ?>
                                <?php if (Helper::checkRoute('/notification/notification/index')) { ?>
                                    <li>
                                        <a class="<?= $count ? 'notification' : '' ?>"><i class="fa fa-bell" aria-hidden="true"></i> Th??ng b??o & li??n h???<?= $count ? "($count)" : '' ?> <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <!--  <?php if (Helper::checkRoute('/notification/notification/index')) { ?>
                                                    <li>
                                                        <?= Html::a('Trung t??m th??ng b??o', ['/notification/notification/index']) ?>
                                                    </li>
                                                <?php } ?> -->

                                            <?php if (Helper::checkRoute('/form/contact/index')) { ?>
                                                <li>
                                                    <?= Html::a('Y??u c???u li??n h???' . ($count ? "($count)" : ''), ['/form/contact/index']) ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (Helper::checkRoute('/promotion/promotion/index') || Helper::checkRoute('/mail/mail/index')) { ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-shopping-cart"></i> <?= Yii::t('app', 'Maketting') ?>
                                            <span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/promotion/promotion/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? khuy???n m??i', ['/promotion/promotion/index']) ?></li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/mail/mail/index')) { ?>
                                                <li>
                                                    <a href="<?= Url::to(['/mail/mail/index']) ?>">G???i mail</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/mail/mail/config')) { ?>
                                                <li>
                                                    <a href="<?= Url::to(['/mail/mail/config']) ?>">C???u h??nh mail</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/news/news-category/index') || Helper::checkRoute('/news/news/index')) { ?>
                                    <li>
                                        <a><i class="fa fa-newspaper-o"></i> Qu???n l?? tin t???c <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/news/news-category/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? danh m???c tin', ['/news/news-category/index']); ?></li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/news/news/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? tin t???c', ['/news/news/index']); ?></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/video/video/index') || Helper::checkRoute('/video/video/index')) { ?>
                                    <li>
                                        <a><i class="fa fa-video-camera"></i> Qu???n l?? video <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/media/video-category/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? danh m???c video', ['/media/video-category/index']); ?></li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/media/video/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? video', ['/media/video/index']); ?></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/banner/banner-group/index') || Helper::checkRoute('/banner/banner/index')) { ?>
                                    <li>
                                        <a><i class="fa fa-file-image-o"></i> Qu???n l?? banner <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/banner/banner-group/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? nh??m banner', ['/banner/banner-group/index']); ?></li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/banner/banner/index')) { ?>
                                                <li><?= Html::a('Qu???n l?? banner', ['/banner/banner/index']); ?></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (Helper::checkRoute('/news/content-page/index')) { ?>
                                    <li>
                                        <?= Html::a('<i class="fa fa-file-o"></i>Qu???n l?? trang n???i dung', ['/news/content-page/index']) ?>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/menu/menu-group/index')) { ?>
                                    <li>
                                        <?= Html::a('<i class="fa fa-list-ul"></i>Qu???n l?? menu', ['/menu/menu-group/index']) ?>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/general/job/index') || Helper::checkRoute('/siteinfo/index') || Helper::checkRoute('/site-introduce/index') || Helper::checkRoute('/social/index')) { ?>
                                    <li>
                                        <a><i class="fa fa-cog"></i> C???u h??nh chung <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/siteinfo/index')) { ?>
                                                <li><?= Html::a('Th??ng tin c?? b???n', ['/siteinfo/index']); ?></li>
                                            <?php } ?>

                                            <?php if (Helper::checkRoute('/site-introduce/index')) { ?>
                                                <li><?= Html::a('Gi???i thi???u', ['/site-introduce/index']); ?></li>
                                            <?php } ?>

                                            <?php if (Helper::checkRoute('/general/job/index')) { ?>
                                                <li>
                                                    <?= Html::a('Ngh??? nghi???p', ['/general/job/index']) ?>
                                                </li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/optionprice/optionprice/index')) { ?>
                                                <li>
                                                    <?= Html::a('Kho???ng gi??', ['/optionprice/optionprice/index']) ?>
                                                </li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/social/index')) { ?>
                                                <li>
                                                    <?= Html::a('H??? tr??? tr???c tuy???n', ['/social/index']) ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/affiliate/affiliate/index') || Helper::checkRoute('/gcacoin/gcacoin/phoneotp')) { ?>
                                    <li>
                                        <a><i class="fa fa-cog"></i> C???u h??nh b???o m???t <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <?php if (Helper::checkRoute('/affiliate/affiliate/index')) { ?>
                                                <li><?= Html::a('Affiliate', ['/affiliate/affiliate/index']); ?></li>
                                            <?php } ?>
                                            <?php if (Helper::checkRoute('/gcacoin/gcacoin/phoneotp')) { ?>
                                                <li><?= Html::a('S??T nh???n OTP', ['/gcacoin/gcacoin/phoneotp']); ?></li>
                                            <?php } ?>

                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/notifications/notifications/index')) { ?>
                                    <li>
                                        <?= Html::a('<i class="fa fa-bell"></i>T???o th??ng b??o', ['/notifications/notifications/index']) ?>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/user-admin/index')) { ?>
                                    <li>
                                        <?= Html::a('<i class="fa fa-user-secret"></i>T??i kho???n qu???n tr???', ['/user-admin/index']) ?>
                                    </li>
                                <?php } ?>

                                <?php if (Helper::checkRoute('/auth')) { ?>
                                    <li>
                                        <?= Html::a('<i class="fa fa-user-secret"></i>Ph??n quy???n', ['/auth']) ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!--TOP NAVIGATION-->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <!--<img src="images/img.jpg" alt="">-->
                                    <?= isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : '' ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li>
                                        <?= Html::a('<i class="fa fa-sign-out pull-right"></i>????ng xu???t', ['/site/logout']); ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="view-web">
                                <a class="blue" target="_blank" title="Xem website" href="<?= \yii\helpers\Url::to(Yii::$app->urlManagerFrontEnd->createUrl([''])) ?>"><span>Xem website</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!--COL RIGHT-->
            <!-- page content -->
            <div class="right_col" role="main">
                <div class="row">
                    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
                    <?= Alert::widget() ?>
                </div>
                <div class="row">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.index').parent().click(function() {
                $(this).find('.index').css('display', 'none');
                // if ($(this).attr('data')) {
                //     $.getJSON(
                //             $(this).attr('data'),
                //             ).done(function (data) {
                //         if (data != '1') {
                //             console.log('c?? l???i');
                //         }
                //     }).fail(function (jqxhr, textStatus, error) {
                //         console.log('c?? l???i');
                //     });
                // }
            })
        });
    </script>
</body>

</html>
<?php $this->endPage() ?>