<?php 
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use common\widgets\Alert;
use common\components\ClaHost;
use common\components\ClaLid;
use yii\helpers\Html;
use common\models\ActiveFormC;
$shop = \common\models\shop\Shop::findOne(Yii::$app->user->id);
if(!($shop = \common\models\shop\Shop::findOne(Yii::$app->user->id))) {
	$shop =  new \common\models\shop\Shop();
}
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
                                $image_1 = ($shop->avatar_name) ? ClaHost::getImageHost().$shop->avatar_path.$shop->avatar_name : ClaHost::getImageHost().'/imgs/shop_default.png';
                                $image_2 = ($shop->image_name) ? ClaHost::getImageHost().$shop->image_path.$shop->image_name : ClaHost::getImageHost().'/imgs/shop_bgr_default.png';
                          	?>
                            <div class="banner-store" <?= (Yii::$app->controller->id=="shop" && Yii::$app->controller->action->id =='create') ? '' : 'id="avatar_img_avatar1"'  ?>>
                                <img id="bgr-shop" src="<?= $image_2 ?>" alt="<?= $shop->name ?>">
                                <a class="fix-img-bg"><i class="fa fa-camera" aria-hidden="true"></i><?= Yii::t('app', 'change_backgruond') ?></a>
                                <a class="click crop-left" onclick="cropimages_bgr_shop();"><i class="fa fa-crop"></i></a>
                            </div>
                            <div class="img-store">
                                <div class="img"  <?= (Yii::$app->controller->id=="shop" && Yii::$app->controller->action->id =='create') ? '' : 'id="avatar_img_avatar2"'  ?>>
                                	 <a class="click crop-left"  onclick="cropimages_ava_shop();"><i class="fa fa-crop"></i></a>
                                    <img id="avatar-shop" src="<?= $image_1 ?>" alt="<?= $shop->name ?>">
                                </div>
                                <h2>
                                    <a data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/shop/shop/detail', 'id' => $shop->id, 'alias' => $shop->alias]) ?>"><?= $shop->name ?></a>
                                </h2>
                                <a class="fix-img-avatar"><?= Yii::t('app', 'change_avatar') ?></a>
                            </div>
                            <?php if($shop->id) { ?>
		                        <div class="menu-bar-store" tabindex="-1">
		                            <div class="menu-bar-lv-1">
		                                <a class="a-lv-1"><img src="<?= Yii::$app->homeUrl ?>images/icon-menu1.png" alt=""><?= $shop->name ?></a>
		                                <div class="menu-bar-lv-2">
		                                    <a class="a-lv-2" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/shop/update']) ?>"><?= Yii::t('app', 'file_shop') ?></a>
		                                </div>
		                                <div class="menu-bar-lv-2">
		                                    <a class="a-lv-2" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/shop/image']) ?>"><?= Yii::t('app', 'image_shop') ?></a>
		                                </div>
		                                <div class="menu-bar-lv-2"><a class="a-lv-2" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/shop/auth']) ?>"><?= Yii::t('app', 'shop_auth') ?></a></div>
		                                <div class="menu-bar-lv-2"><a class="a-lv-2" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/shop-address/index']) ?>"><?= Yii::t('app', 'brand') ?></a></div>
		                                <div class="menu-bar-lv-2"><a class="a-lv-2" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/shop-transport/index']) ?>"><?= Yii::t('app','transport') ?></a></div>
		                                <div class="menu-bar-lv-2"><a class="a-lv-2" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/shop/rate']) ?>"><?= Yii::t('app','rate') ?></a></div>
		                                <div class="menu-bar-lv-2"><a class="a-lv-2" ><?= Yii::t('app','bank') ?></a></div>
		                                <span class="span-lv-1 fa fa-angle-down"></span>
		                            </div>
		                            <div class="menu-bar-lv-1">
		                                <a class="a-lv-1" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/product/index']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/ico-menu6.png" alt=""><?= Yii::t('app', 'product_management') ?> </a>
		                            </div>
		                            <div class="menu-bar-lv-1">
		                                <a class="a-lv-1" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/order/index']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/icon-menu3.png" alt=""><?= Yii::t('app', 'order_management') ?> </a>
		                            </div>
		                            <!-- <div class="menu-bar-lv-1">
		                                <a class="a-lv-1" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/message/index']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/ico-menu5.png" alt=""><?= Yii::t('app', 'message') ?> </a>
		                            </div> -->
		                            <div class="menu-bar-lv-1"><a data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" href="<?= Url::to(['/management/profile/index']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/icon-menu2.png" alt=""><?= Yii::t('app', 'user_file') ?></a></div>
		                            <div class="menu-bar-lv-1"><a href="<?= Url::to(['/login/login/logout']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/icon-menu1.png" alt=""><?= Yii::t('app', 'logout') ?></a></div>
		                        </div>
	                        <?php } ?>
	                    </div>
	                </div>
	                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
	                	<?= $content ?>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="hidden">
			<?=
			    frontend\widgets\form\FormWidget::widget([
			        'view' => 'form-img',
			        'input' => [
			            'model' => $shop,
			            'id' => 'avatar1',
			            'images'=> ($shop->image_name) ? ClaHost::getImageHost().$shop['image_path'].'s100_100/'.$shop['image_name']  : null,
			            'url' => yii\helpers\Url::to(['/management/shop/uploadfilebgr']),
			        ]
			    ]);
			?>
			<?=
			    frontend\widgets\form\FormWidget::widget([
			        'view' => 'form-img',
			        'input' => [
			            'model' => $shop,
			            'id' => 'avatar2',
			            'images'=> ($shop->avatar_name) ? ClaHost::getImageHost().$shop['avatar_path'].'s100_100/'.$shop['avatar_name']  : null,
			            'url' => yii\helpers\Url::to(['/management/shop/uploadfileava']),
			            'script' => '<script src="'.Yii::$app->homeUrl.'js/upload/ajaxupload.min.js"></script>'
			        ]
			    ]);
			?>
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
	</div>
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
		        loadimg_cropimages_bgr_shop(img, 95, 28);
		    }
		    function cropimages_ava_shop() {
				img = $('#avatar-shop').attr('src').replace('/s200_200', '');
		        $('.box-crops').css('left', '0px');
		        $('#crop-img-upload').css('display', 'none');
		        $('#image').attr('src', img);
		        $('.cropper-canvas').first().find('img').attr('src', img);
		        loadimg_cropimages_ava_shop(img, 1, 1);
		    }
		</script>
    </div>
	
<?php $this->endContent(); ?>
