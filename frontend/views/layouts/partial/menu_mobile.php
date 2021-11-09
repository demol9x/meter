<?php 
use yii\helpers\Url;
?>
<style type="text/css">
    .front-back-page .menu-categories>h2 {
        display: none;
    }
    .front-back-page .menu-categories .menu-bar-lv-1 a {
        background: unset;
    }
    body .front-back-page .menu-bar-store {
         background: unset; 
    }
    .display-member-card-poup, .display-menu-poup {
        display: none;
    }
    .show {
        display: block !important;
    }
</style>
<div class="<?= (Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id == 'site') ? '' : 'not-index' ?> front-back-page popup">
    <?php if(Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id == 'site') { ?>
        <div class="title-back-page">
            <div class="back-btn">
                <img src="<?= Yii::$app->homeUrl ?>images/arrow-back.png" alt=""> 
                <?= Yii::t('app', 'come_back') ?>
            </div>
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
                        <a target="_blank" href="http://member.gcaeco.vn/"><i class="fa fa-credit-card"></i> <?= Yii::t('app', 'member_card') ?></a>
                    </li>
                    <?php if(Yii::$app->user->id){ ?>
                        <li>
                            <a href="<?= Url::to(['/management/profile/index-management']) ?>">
                                <i class="fa fa-user-circle" aria-hidden="true"></i> <?= Yii::t('app', 'user_info') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/management/product/index-management']) ?>">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i> <?= Yii::t('app', 'shop_info') ?>
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
    <?php } ?>
    <div class="content-back-page">
        <div class="menu-categories display-menu-poup show">
            <?= \frontend\widgets\menuCategory\MenuCategoryWidget::widget([
                        'view' => 'menu_product_left_all',
                    ]) 
            ?>
        </div>
        <div class="menu-categories display-member-card-poup">
            <?= \frontend\widgets\menu\MenuWidget::widget(['view' => 'ul', 'group_id' => 8]) ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".btn-show-cate-mobile").click(function(){
            $('.popup').toggleClass('open');
            $('.display-menu-poup').addClass('show');
            $('.display-member-card-poup').removeClass('show');
        });
        $(".btn-show-member-mobile").click(function(){
            $('.popup').toggleClass('open');
            $('.display-menu-poup').removeClass('show');
            $('.display-member-card-poup').addClass('show');
        });
        $('.back-btn').click(function(){
           $('.popup').removeClass('open');
           $('.list-menu-back').removeClass('open');
        });
        $(".btn-menu-back-home").click(function(){
           $('.list-menu-back').toggleClass('open');
        });
        $('.open-poupup-menu').click(function() {
            $('.popup').addClass('open');
            $('.list-menu-back').toggleClass('open');
            $('.display-menu-poup').addClass('show');
            $('.display-member-card-poup').removeClass('show');
        });
        $('.open-poupup-member-card').click(function() {
            $('.popup').addClass('open');
            $('.list-menu-back').toggleClass('open');
            $('.display-menu-poup').removeClass('show');
            $('.display-member-card-poup').addClass('show');
        })
    });
</script>