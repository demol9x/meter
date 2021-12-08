<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$user = \frontend\models\User::findIdentity(Yii::$app->user->getId());
$s = 'Tìm kiếm';
?>
<style>
    @keyframes showdown {
        0%{
            transform: scale(.2);
            /* bottom: 45px; */
            right: -70px;
        }
        100%{
            transform: scale(1);
                bottom: -86px;
            right: 0;
        }
    }
    .group_login {
        position: relative;
    }

    .group_login .popup_login {
        visibility: hidden;
        position: absolute;
        background-color: #fff;
        bottom: -86px;
        right: 0;
        width: 315px;
        height: 70px;
        box-shadow: rgba(100, 100, 111, 0.7) 0px 7px 29px 0px;
        border-radius: 20px;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transform: all .4s ease;
    }

    .popup_login a {
        justify-content: center !important;
    }

    .popup_login::before {
        content: '';
        position: absolute;
        top: -9px;
        right: 52px;
        border: 13px solid;
        border-color: #fff #fff transparent transparent;
        transform: rotate(-45deg);
    }

    .popup_login::after {
        content: '';
        width: 43%;
        height: 26px;
        background-color: #fff0;
        position: absolute;
        top: -22px;
        right: 0;
    }

    .group_login:hover .popup_login {
        /* transition: all .4s linear; */
        visibility: visible;
        z-index: 1;
        animation: showdown .3s  ease;
        transform-origin: 50% 0%;
    }
</style>
<div class="site51_head_col12_meter">
    <div class="container_fix">
        <div class="logo"><a href="<?= Yii::$app->homeUrl; ?>"><img src="<?= $siteinfo->logo ?>" alt="<?= $siteinfo->title ?>"></a></div>
        <div class="main-menu">
            <div class="menu">
                <ul class="menu_list">
                    <li class="logo_list"><a href="<?= Yii::$app->homeUrl; ?>"><img src="<?= $siteinfo->logo ?>" alt="<?= $siteinfo->title ?>"></a>
                    </li>
                    <?php //Menu main
                    echo frontend\widgets\menu\MenuWidget::widget([
                        'view' => 'view_cat_index',
                        'group_id' => 3,
                    ])
                    ?>
                    <?php if ($user) : ?>
                        <li class="list account"><a href="<?= Url::to(['/management/profile/index']) ?>">Tài
                                khoản</a></li>
                    <?php else : ?>
                        <li class="list account"><a href="<?= \yii\helpers\Url::to(['/login/login/login']) ?>">Tài
                                khoản</a></li>
                    <?php endif; ?>
                    <li class="list app"><a href="">App Metter</a></li>
                </ul>
            </div>
            <div class="search">
                <i class="far fa-search search_icon"></i>
                <div class="toggle_search">
                    <div class="form">
                        <select id="home_option">
                            <option data-url="<?= Url::to(['/package/package/index']) ?>">Gói thầu</option>
                            <option data-url="<?= Url::to(['/shop/shop/index']) ?>">Nhà thầu</option>
                            <option data-url="<?= Url::to(['/user/user/index']) ?>">Tìm thợ</option>
                        </select>
                        <input class="s_txt" type="text" name='s' placeholder="Tìm kiếm" minlength="2" autocomplete="off" required="required">
                        <button onclick="change_search()"><i class="far fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="link_app"><a href="">App Meter</a></div>
            <div class="login_singin">
                <?php
                if (!Yii::$app->user->id) {
                ?>
                    <div class="group_login">
                        <a href="<?= \yii\helpers\Url::to(['/login/login/login']) ?>"><span>Đăng nhập</span><i class="fas fa-user"></i></a>
                        <div class="popup_login">
                            <a href="<?= Url::to(['/login/login/login']) ?>"><span>Đăng nhập</span></a>
                            <a href="<?= Url::to(['/login/login/signup']) ?>"><span>Đăng ký</span></a>
                        </div>
                    </div>
                <?php } else {
                ?>
                    <a href="<?= Url::to(['/management/profile/index']) ?>"><span>Tài khoản</span><i class="fas fa-user"></i></a>

                <?php } ?>
            </div>
            <div class="icon_menu"><span></span><span></span><span></span></div>
        </div>
    </div>
</div>
<script>
    function change_search() {
        var url = jQuery('#home_option').find('option:selected');
        var txt_search = $('.s_txt').val();
        window.location.href = url.data('url') + '?s=' + txt_search;
    }
</script>