<?php 
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use common\widgets\Alert;
use common\components\ClaHost;
use common\components\ClaLid;
$user = \common\models\User::findOne(Yii::$app->user->id);
?>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <style type="text/css">
        .menu-bar-store .menu-bar-lv-2 {
            display: unset;
        }
    </style>
	<div id="main">
	    <div class="breadcrumb">
	        <div class="container">
	            <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
	        </div>
	    </div>
        <?= Alert::widget() ?>
	    <div class="create-page-store">
	        <div class="container">
	            <div class="row">
	                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="menu-my-store">
                        	<?php  
                                $image_1 = ($user->avatar_name) ? \common\components\ClaHost::getImageHost().$user->avatar_path.$user->avatar_name : \common\components\ClaHost::getImageHost().'/imgs/user_default.png';
                                $image_2 = ($user->image_name) ? \common\components\ClaHost::getImageHost().$user->image_path.$user->image_name : \common\components\ClaHost::getImageHost().'/imgs/user_bgr_default.png';
                          	?>
                            <div class="banner-store"  id="avatar_img_avatar1">
                                <img id="bgr-shop"  src="<?= $image_2 ?>" alt="<?= $user->username ?>">
                                <a class="fix-img-bg" ><i class="fa fa-camera" aria-hidden="true"></i><?= Yii::t('app', 'change_backgruond') ?></a>
                            </div>
                            <div class="img-store">
                                <div class="img" id="avatar_img_avatar2">
                                    <img id="avatar-shop"  src="<?= $image_1 ?>" alt="<?= $user->username ?>">
                                </div>
                                <h2>
                                    <?= $user->username ?>
                                </h2>
                                <a class="fix-img-avatar"><?= Yii::t('app', 'change_avatar') ?></a>
                            </div>
                            <div class="menu-bar-store" tabindex="-1">
                                <div class="menu-bar-lv-1">
                                    <a class="a-lv-1" href="<?= Url::to(['/management/profile/index']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/icon-menu2.png" alt=""><?= Yii::t('app', 'user_file') ?></a>
                                    <div class="menu-bar-lv-2">
                                        <a class="a-lv-2" href="<?= Url::to(['/management/profile/index']) ?>"><?= Yii::t('app', 'user_information') ?></a>
                                    </div>
                                    <div class="menu-bar-lv-2">
                                        <a class="a-lv-2" href="<?= Url::to(['/management/user-address/index']) ?>"><?= Yii::t('app', 'user_address') ?></a>
                                    </div>
                                    <div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/user-bank/index']) ?>"><?= Yii::t('app', 'bank') ?></a></div>
                                    <div class="menu-bar-lv-2"> <a class="a-lv-2" href="<?= Url::to(['/management/profile/change-password']) ?>"><?= Yii::t('app', 'change_password') ?></a></div>
                                    <span class="span-lv-1 fa fa-angle-down"></span>
                                </div>
                                <div class="menu-bar-lv-1">
                                    <a class="a-lv-1" href="<?= Url::to(['/management/notifications/index']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/bell-notify.png" alt="">Thông báo </a>
                                </div>
                                <div class="menu-bar-lv-1">
                                    <a class="a-lv-1" href="<?= Url::to(['/management/order/view']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/icon-menu3.png" alt=""><?= Yii::t('app', 'order_check') ?> </a>
                                </div>
                                <div class="menu-bar-lv-1">
                                    <a href="<?= Url::to(['/management/shop/create']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/ico-menu7.png" alt=""><?= Yii::t('app', 'shop_setting') ?></a>
                                </div>
                                <div class="menu-bar-lv-1">
                                    <a href="<?= Url::to(['/login/login/logout']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/dangxuat.png" alt=""><?= Yii::t('app', 'logout') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
	                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
	                	<?= $content ?>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
    <?php if(Yii::$app->controller->id != 'shop') { ?>
        <div class="hidden">
                <?=
                    frontend\widgets\form\FormWidget::widget([
                        'view' => 'form-img',
                        'input' => [
                            'model' => $user,
                            'id' => 'avatar1',
                            'images'=> ($user->image_name) ? ClaHost::getImageHost().$user['image_path'].'s100_100/'.$user['image_name']  : null,
                            'url' => yii\helpers\Url::to(['/management/profile/uploadfilebgr']),
                        ]
                    ]);
                ?>
                <?=
                    frontend\widgets\form\FormWidget::widget([
                        'view' => 'form-img',
                        'input' => [
                            'model' => $user,
                            'id' => 'avatar2',
                            'images'=> ($user->avatar_name) ? ClaHost::getImageHost().$user['avatar_path'].'s100_100/'.$user['avatar_name']  : null,
                            'url' => yii\helpers\Url::to(['/management/profile/uploadfileava']),
                            'script' => '<script src="'.Yii::$app->homeUrl.'js/upload/ajaxupload.min.js"></script>'
                        ]
                    ]);
                ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.fix-img-bg').click(function() {
                    $('#avatar_form_avatar1').find('input').first().click(); 
                });
                $('.fix-img-avatar').click(function() {
                    $('#avatar_form_avatar2').find('input').first().click(); 
                });
            });
        </script>
    <?php } ?>
    <div class="box-crops">
        <div class="flex">
            <div class="in-flex">
                <div class="close-box-crops">x</div>
                <?php 
                    echo \frontend\widgets\cropImage\CropImageWidget::widget([
                        'input' => [
                            'img' => ''
                        ]
                    ]); 
                ?>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.close-box-crops').click(function () {
                    $('.box-crops').css('left', '-100%');
                });
            });
            function cropimages_bgr_shop() {
                img = $('#bgr-shop').attr('src').replace('/s200_200', '');
                $('.box-crops').css('left', '0px');
                $('#crop-img-upload').css('display', 'none');
                $('#image').attr('src', img);
                $('.cropper-canvas').first().find('img').attr('src', img);
                loadimg_cropimages_bgr_shop(img, 950, 270);
            }
            function cropimages_ava_shop() {
                img = $('#avatar-shop').attr('src').replace('/s200_200', '');
                $('.box-crops').css('left', '0px');
                $('#crop-img-upload').css('display', 'none');
                $('#image').attr('src', img);
                $('.cropper-canvas').first().find('img').attr('src', img);
                loadimg_cropimages_ava_shop(img, 200, 200);
            }
        </script>
    </div>
<?php $this->endContent(); ?>
