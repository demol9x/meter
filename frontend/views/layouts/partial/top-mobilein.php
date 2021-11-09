<?php
use yii\helpers\Url;
?>

<style type="text/css">
    .fix-all {
        display: block;
        z-index: 99999;
    }
    .fix-all .title-back-page {
        height: 40px;
    }
    .display-popup, .display-normal {
        display: none;
    }
</style>
<div class="front-back-page fix-all">
    <div class="title-back-page">
        <div class="back-btn">
            <a onclick="window.history.back()" class="display-normal show">
                <img src="<?= Yii::$app->homeUrl ?>images/arrow-back.png" alt="back">
                <?= $this->title ?>
            </a>
            <a class="display-popup">
                <img src="<?= Yii::$app->homeUrl ?>images/arrow-back.png" alt="back">
                <?= Yii::t('app', 'come_back') ?>
            </a>
        </div>
        <?php if (!\common\components\ClaSite::isActiceApp()) { ?>
            <div class="center-fix-all">
                <a id="btn-search-mobile"><i class="fa fa-search"></i></a>
                <?= frontend\widgets\notifications\NotificationsWidget::widget() ?>
                <?= frontend\widgets\shoppingcart\Shoppingcart::widget() ?>
            </div>
        <?php } ?>
        <div class="come-home">
            <div class="btn-menu-back-home">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="list-menu-back">
                <li>
                    <a href="<?= Yii::$app->homeUrl ?>"><i class="fa fa-home"></i> <?= Yii::t('app', 'home') ?></a>
                </li>
                <li>
                    <a class="open-poupup-menu"><i class="fa fa-bars"></i> <?= Yii::t('app', 'menu') ?></a>
                </li>
                <li>
                    <a target="_blank" href="https://member.gcaeco.vn" ><i class="fa fa-credit-card"></i> <?= Yii::t('app', 'member_card') ?></a>
                </li>
                <?php if(Yii::$app->user->id){ ?>
                    <li>
                        <a href="<?= Url::to(['/management/profile/index-management']) ?>">
                            <i class="fa fa-user-circle" aria-hidden="true"></i> <?= Yii::t('app', 'user_management') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/management/shop/index-management']) ?>">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i> <?= Yii::t('app', 'shop_management') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/site/logout']) ?>">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> <?= Yii::t('app', 'logout') ?>
                        </a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="<?= Url::to(['/login/login/login']) ?>">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            <?= Yii::t('app', 'login') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/login/login/signup']) ?>">
                            <i class="fa fa-key" aria-hidden="true"></i>
                            <?= Yii::t('app', 'signup') ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-search-mobile').click(function () {
            $('#box-search-mobile').addClass('open');
            $('body').css('overflow', 'hidden');
            href = '<?= Url::to(['/search/search/index-ajax']) ?>';
            if($(this).attr('data-load') != 0) {
                $(this).attr('data-load', 0); 
                loadAjax(href, $('#from-search-mobile').serialize(),$('#box-load-search'));
            }
            return false;
        });
        //
        $('.back-btn').click(function () {
            $('.display-normal').addClass('show');
            $('.display-popup').removeClass('show');
        });
        $('.open-poupup-menu').click(function () {
            $('.display-popup').addClass('show');
            $('.display-normal').removeClass('show');
        });
        $('.open-poupup-member-card').click(function () {
            $('.display-popup').addClass('show');
            $('.display-normal').removeClass('show');
        });

        jQuery(document).on('click', function (e) {
            if ($(e.target).closest("#searchForm").length === 0) {
                jQuery('#searchResults').fadeOut(200);
            }
        });
    })
</script>