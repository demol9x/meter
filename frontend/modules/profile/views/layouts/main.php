<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<link rel="stylesheet" type="text/css" href="<?= yii::$app->homeUrl ?>css/thongtincanhan.css">
<?php

use common\components\ClaHost;
use frontend\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$user = User::findIdentity(Yii::$app->user->getId());
?>
<?php if (Yii::$app->session->getFlash('cusses')) { ?>
    <div class="set-flash">
        <div class="flash-set-flex content_14">
            <?php echo Yii::$app->session->getFlash('cusses'); ?>
            <div class="flash-ok">
                Xác nhận
            </div>
        </div>
    </div>
<?php } ?>
<div class="profile_pro_item">
    <div class="container_fix">
        <div class="item_left">
            <div class="menu-my-store">
                <?= Html::activeHiddenInput($user, 'cover') ?>
                <div class="banner-store" id="avatar_img_avatar1">
                    <?php if(isset($user['image_path']) && $user['image_path']){?>
                    <img id="bgr-shop" src="<?= ClaHost::getImageHost(), $user['image_path'], $user['image_name'] ?>"
                         alt="<?= $user['username'] ?>">
                    <?php } ?>
                    <a class="fix-img-bg content_13" id="usercover_form" type="submit"><i class="fa fa-camera" aria-hidden="true"></i>Thay đổi ảnh bìa</a>
                </div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        jQuery('#usercover_form').ajaxUpload({
                            url: '<?= yii\helpers\Url::to(['/profile/profile/upload-cover']); ?>',
                            name: 'file',
                            onSubmit: function () {
                            },
                            onComplete: function (result) {
                                var obj = $.parseJSON(result);
                                if (obj.status == '200') {
                                    if (obj.data.realurl) {
                                        jQuery('#user-cover').val(obj.data.avatar);
                                        if (jQuery('#bgr-shop').attr('src')) {
                                            jQuery('#bgr-shop').attr('src', obj.data.realurl);
                                        } else {
                                            jQuery('#avatar_img_avatar1').append('<img id="bgr-shop" src="' + obj.data.realurl + '" alt="<?= $user['username'] ?>"/>');
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
                <div class="img-store">
                    <?= Html::activeHiddenInput($user, 'avatar') ?>
                    <div class="img" id="avatar_img_avatar2">
                        <img id="avatar-shop"
                             src="<?= ClaHost::getImageHost(), $user['avatar_path'], $user['avatar_name'] ?>"
                             alt="<?= $user['username'] ?>">
                    </div>
                    <h2 class="content_15"><?= $user['username'] ?></h2>
                    <a class="fix-img-avatar content_13" id="usercover_form_1">Thay đổi ảnh đại diện</a>
                </div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        jQuery('#usercover_form_1').ajaxUpload({
                            url: '<?= yii\helpers\Url::to(['/profile/profile/upload-avatar']); ?>',
                            name: 'file',
                            onSubmit: function () {
                            },
                            onComplete: function (result) {
                                var obj = $.parseJSON(result);
                                if (obj.status == '200') {
                                    if (obj.data.realurl) {
                                        jQuery('#user-avatar').val(obj.data.avatar);
                                        if (jQuery('#avatar-shop').attr('src')) {
                                            jQuery('#avatar-shop').attr('src', obj.data.realurl);
                                        } else {
                                            jQuery('#avatar_img_avatar2').append('<img id="avatar-shop" src="' + obj.data.realurl + '" alt="<?= $user['username'] ?>"/>');
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
                <div class="menu-bar-store" tabindex="-1">
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="">
                            <img src="<?= yii::$app->homeUrl ?>images/icon-menu3.png" alt="">
                            Kiểm tra đơn hàng<i class="count-notinfycation content_14">(45)</i>
                        </a>
                    </div>
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="">
                            <img src="<?= yii::$app->homeUrl ?>images/bell-notify.png" alt="">
                            Thông báo<i class="count-notinfycation content_14">(165)</i>
                        </a>
                    </div>

                    <?php if (isset($user) && $user->type == 2) { ?>
                        <div class="menu-bar-lv-1">
                            <a class="a-lv-1 content_14" href="">
                                <img src="<?= yii::$app->homeUrl ?>images/ico-menu7.png" alt="">
                                Sản phẩm
                            </a>
                            <div class="menu-bar-lv-2">
                                <a class="a-lv-2 content_14" href="">Danh sách sản phẩm</a>
                            </div>
                            <span class="span-lv-1 fa fa-angle-down"></span>
                        </div>
                    <?php } ?>
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="#"><img src="<?= yii::$app->homeUrl ?>images/icon-menu2.png"
                                                                   alt="">Hồ sơ cá nhân</a>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="<?= Url::to(['/profile/profile/index']) ?>">Thông tin cá
                                nhân</a>
                        </div>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="<?= Url::to(['/profile/profile/box-address']) ?>">Địa
                                chỉ</a>
                        </div>
                        <!--                    <div class="menu-bar-lv-2"><a class="a-lv-2 content_14" href="">Tài khoản, thẻ ngân hàng</a></div>-->
                        <div class="menu-bar-lv-2"><a class="a-lv-2 content_14"
                                                      href="<?= Url::to(['/profile/profile/update-password']) ?>">Đổi
                                mật khẩu</a></div>
                        <!--                     <div class="menu-bar-lv-2"> <a class="a-lv-2 content_14" href="">Đổi mật khẩu cấp 2</a></div>-->
                        <span class="span-lv-1 fa fa-angle-down"></span>
                    </div>
                    <div class="menu-bar-lv-1">
                        <?php
                        if (isset($user->type) && $user->type == 1) {
                            ?>
                            <a class="content_14" href=""><img src="<?= yii::$app->homeUrl ?>images/ico-menu7.png"
                                                               alt="">Đăng ký làm thợ</a>
                            <a class="content_14" href=""><img src="<?= yii::$app->homeUrl ?>images/ico-menu7.png"
                                                               alt="">Đăng ký làm doanh nghiệp</a>
                            <?php
                        } else if ($user->type == 2) {
                            ?>
                            <a class="content_14" href=""><img src="<?= yii::$app->homeUrl ?>images/ico-menu7.png"
                                                               alt="">Quản trị doanh nghiệp</a>
                        <?php } else if ($user->type == 3) {
                            ?>
                            <a class="content_14" href=""><img src="<?= yii::$app->homeUrl ?>images/ico-menu7.png"
                                                               alt="">Thiết lập thông tin thợ</a>
                        <?php } ?>
                    </div>
                    <div class="menu-bar-lv-1">
                        <a class="content_14" href="<?= Url::to(['/login/login/logout']) ?>">
                            <i class="fas fa-sign-out-alt"
                               style="font-size: 23px; color: dimgrey; margin-right: 18px;"></i>Đăng xuất
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <?= $content ?>
    </div>
</div>

<?php $this->endContent(); ?>
