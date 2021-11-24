<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<link rel="stylesheet" type="text/css" href="<?= yii::$app->homeUrl ?>css/thongtincanhan.css">
<script type="text/javascript">
    var baseUrl = '<?= Yii::$app->homeUrl ?>';
</script>
<?php

use common\components\ClaHost;
use frontend\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$user = \common\models\User::findOne(Yii::$app->user->id);
$shop = \common\models\shop\Shop::findOne(Yii::$app->user->id);
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
                <div class="banner-store" id="avatar_img_avatar1">
                    <?php if (isset($user['image_path']) && $user['image_path']) { ?>
                        <img id="bgr-shop"
                             src="<?= ClaHost::getImageHost(), $user['image_path'], $user['image_name'] ?>"
                             alt="<?= $user['username'] ?>">
                    <?php } ?>
                    <a class="fix-img-bg content_13" id="usercover_form" type="submit"><i class="fa fa-camera"
                                                                                          aria-hidden="true"></i>Thay
                        đổi ảnh bìa</a>
                </div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        jQuery('#usercover_form').ajaxUpload({
                            url: '<?= yii\helpers\Url::to(['/management/profile/upload-cover']); ?>',
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
                            url: '<?= yii\helpers\Url::to(['/management/profile/upload-avatar']); ?>',
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
                        <a class="a-lv-1 content_14" href="#">
                            <img src="<?= yii::$app->homeUrl ?>images/icon-menu3.png" alt="">
                            Kiểm tra đơn hàng<i class="count-notinfycation content_14">(45)</i>
                        </a>
                    </div>
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="#">
                            <img src="<?= yii::$app->homeUrl ?>images/bell-notify.png" alt="">
                            Thông báo<i class="count-notinfycation content_14">(165)</i>
                        </a>
                    </div>
                    <?php if (isset($shop) && $shop) { ?>
                        <div class="menu-bar-lv-1">
                            <a class="a-lv-1 content_14" href="<?= Url::to(['/management/package/index']) ?>">
                                <img src="<?= yii::$app->homeUrl ?>images/ico-menu7.png" alt="">
                                Gói thầu
                            </a>
                        </div>
                    <?php } ?>
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="#"><img src="<?= yii::$app->homeUrl ?>images/icon-menu2.png"
                                                                   alt="">Hồ sơ cá nhân</a>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="<?= Url::to(['/management/profile/index']) ?>">Thông tin cá
                                nhân</a>
                        </div>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="<?= Url::to(['/management/profile/address']) ?>">Địa
                                chỉ</a>
                        </div>
                        <!--                    <div class="menu-bar-lv-2"><a class="a-lv-2 content_14" href="">Tài khoản, thẻ ngân hàng</a></div>-->
                        <div class="menu-bar-lv-2"><a class="a-lv-2 content_14"
                                                      href="<?= Url::to(['/management/profile/update-password']) ?>">Đổi
                                mật khẩu</a></div>
                        <!--                     <div class="menu-bar-lv-2"> <a class="a-lv-2 content_14" href="">Đổi mật khẩu cấp 2</a></div>-->
                        <span class="span-lv-1 fa fa-angle-down"></span>
                    </div>
                    <div class="menu-bar-lv-1">
                        <?php
                        if (isset($user->type) && $user->type == User::TYPE_CA_NHAN) {
                            ?>
                            <a class="content_14" href="">
                                <img src="<?= yii::$app->homeUrl ?>images/ico-menu7.png" alt="">Đăng ký làm thợ</a>
                            <?php
                        } else if ($shop) {
                            ?>
                            <a class="content_14" href="<?= Url::to(['/management/shop/index']) ?>"><img
                                        src="<?= yii::$app->homeUrl ?>images/ico-menu7.png"
                                        alt="">Quản trị doanh nghiệp</a>
                        <?php } else if ($user->type == User::TYPE_THO) {
                            ?>
                            <a class="content_14" href="<?= Url::to(['/management/profile/add-tho']) ?>">
                                <img src="<?= yii::$app->homeUrl ?>images/ico-menu7.png" alt="">Thiết lập thông tin thợ</a>
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
