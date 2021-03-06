<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use common\widgets\Alert;
use common\components\ClaHost;
use common\components\ClaLid;
use yii\helpers\Html;
use common\models\ActiveFormC;

$shop = \common\models\shop\Shop::findOne(Yii::$app->user->id);
if (!($shop = \common\models\shop\Shop::findOne(Yii::$app->user->id))) {
	$shop =  new \common\models\shop\Shop();
}
?>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<style type="text/css">
	.menu-my-store .menu-bar-store .menu-bar-lv-2 {
		display: unset;
	}

	.menu-bar-lv-1 a img {
		height: 25px;
		width: 25px;
	}

	#avatar_img_avatar2 {
		position: relative;
	}

	.fix-img-avatar.hover-in {
		position: absolute;
		bottom: -2px;
		right: 2px;
	}

	.fix-img-avatar.hover-in i {
		font-size: 16px !important;
		color: #000;
	}

	/* .create-page-store {
		padding-top: 45px;
	} */

	.box-crops .in-flex {
		margin: auto;
		width: 80%;
		max-width: 600px;
		height: 60% !important;
		background: #fff;
		padding: 30px;
	}
</style>
<div id="main">
	<?= Alert::widget() ?>
	<div class="create-page-store">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="menu-my-store">
						<?php
						$image_1 = ($shop->avatar_name) ? ClaHost::getImageHost() . $shop->avatar_path . $shop->avatar_name : ClaHost::getImageHost() . '/imgs/shop_default.png';
						$image_2 = ($shop->image_name) ? ClaHost::getImageHost() . $shop->image_path . $shop->image_name : ClaHost::getImageHost() . '/imgs/shop_bgr_default.png';
						?>
						<div class="banner-store" <?= (Yii::$app->controller->id == "shop" && Yii::$app->controller->action->id == 'create') ? '' : 'id="avatar_img_avatar1"'  ?>>
							<img id="bgr-shop" src="<?= $image_2 ?>" alt="<?= $shop->name ?>">
							<a class="fix-img-bg"><i class="fa fa-camera" aria-hidden="true"></i><?= Yii::t('app', 'change_backgruond') ?></a>
							<a class="click crop-left" onclick="cropimages_bgr_shop();"><i class="fa fa-crop"></i></a>
						</div>
						<div class="img-store">
							<div class="img" <?= (Yii::$app->controller->id == "shop" && Yii::$app->controller->action->id == 'create') ? '' : 'id="avatar_img_avatar2"'  ?>>
								<a class="click crop-left" onclick="cropimages_ava_shop();"><i class="fa fa-crop"></i></a>
								<img id="avatar-shop" src="<?= $image_1 ?>" alt="<?= $shop->name ?>">
								<a class="fix-img-avatar hover-in"><i class="fa fa-camera" aria-hidden="true"></i></a>
							</div>
							<h2>
								<a href="<?= Url::to(['/shop/shop/detail', 'id' => $shop->id, 'alias' => $shop->alias]) ?>"><?= $shop->name ?></a>
							</h2>
							<a class="fix-img-avatar"><?= Yii::t('app', 'change_avatar') ?></a>
						</div>
						<?php if ($shop->id) { ?>
							<div class="menu-bar-store" tabindex="-1">
								<div class="menu-bar-lv-1">
									<a class="a-lv-1" href="<?= Url::to(['/management/order/index']) ?>">
										<img src="<?= Yii::$app->homeUrl ?>images/icon-menu3.png" alt="">
										<?= Yii::t('app', 'order_management') ?>
										<?php
										$count_order_new = \common\models\order\Order::getInShopByStatus(Yii::$app->user->id, 1, ['count' => 1]);
										if ($count_order_new) {
										?>
											<i class="count-notinfycation">
												(<?= $count_order_new ?>)
											</i>
										<?php } ?>
									</a>
								</div>
								<div class="menu-bar-lv-1">
									<a class="a-lv-1" href="<?= Url::to(['/management/discount-code/index']) ?>">
										<img src="<?= Yii::$app->homeUrl ?>images/ico-menu6.png" alt="">
										M?? gi???m gi??
									</a>
								</div>
								<div class="menu-bar-lv-1">
									<a class="a-lv-1" href="<?= Url::to(['/management/product/index']) ?>">
										<img src="<?= Yii::$app->homeUrl ?>images/ico-menu6.png" alt="">
										<?= Yii::t('app', 'product_management') ?>
									</a>
								</div>
								<div class="menu-bar-lv-1">
									<a href="<?= Url::to(['/shop/shop/detail', 'id' => $shop->id, 'alias' => $shop->alias]) ?>" class="a-lv-1"><img src="<?= Yii::$app->homeUrl ?>images/icon-menu1.png" alt=""><?= $shop->name ?></a>
									<div class="menu-bar-lv-2">
										<a class="a-lv-2" href="<?= Url::to(['/management/shop/update']) ?>"><?= Yii::t('app', 'file_shop') ?></a>
									</div>
									<div class="menu-bar-lv-2">
										<a class="a-lv-2" href="<?= Url::to(['/management/shop/image']) ?>"><?= Yii::t('app', 'image_shop') ?></a>
									</div>
									<div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/shop/auth']) ?>"><?= Yii::t('app', 'shop_auth') ?></a></div>
									<div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/shop-address/index']) ?>"><?= Yii::t('app', 'brand') ?></a></div>
									<div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/shop-transport/index']) ?>"><?= Yii::t('app', 'transport') ?></a></div>
									<div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/ctx/index']) ?>">Ch???ng th???c s???</a></div>
									<div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/shop/rate']) ?>"><?= Yii::t('app', 'rate') ?></a></div>
									<div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/user-bank/index']) ?>"><?= Yii::t('app', 'bank') ?></a></div>
									<div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/shop-affiliate/index']) ?>"><?= Yii::t('app', 'Affiliate') ?></a></div>
									<div class="menu-bar-lv-2"><a class="a-lv-2" href="<?= Url::to(['/management/shop/time']) ?>"><?= Yii::t('app', 'G??i gia h???n') ?></a></div>
									<span class="span-lv-1 fa fa-angle-down"></span>
								</div>
								<div class="menu-bar-lv-1"><a href="<?= Url::to(['/management/profile/index-management']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/icon-menu2.png" alt=""><?= Yii::t('app', 'user_file') ?></a></div>
							</div>
						<?php } ?>
						<div class="menu-bar-lv-1"><a href="<?= Url::to(['/login/login/logout']) ?>"><img src="<?= Yii::$app->homeUrl ?>images/dangxuat.png" alt=""><?= Yii::t('app', 'logout') ?></a></div>
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
				'images' => ($shop->image_name) ? ClaHost::getImageHost() . $shop['image_path'] . 's100_100/' . $shop['image_name']  : null,
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
				'images' => ($shop->avatar_name) ? ClaHost::getImageHost() . $shop['avatar_path'] . 's100_100/' . $shop['avatar_name']  : null,
				'url' => yii\helpers\Url::to(['/management/shop/uploadfileava']),
				'script' => '<script src="' . Yii::$app->homeUrl . 'js/upload/ajaxupload.min.js"></script>'
			]
		]);
	?>
	<script type="text/javascript">
		$(document).ready(function() {
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
		<div class="in-flex" id="box-crops-in-flex">
			<div class="close-box-crops">x</div>
			<div id="box-inner-croppie">
			</div>

		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.close-box-crops').click(function() {
				$('.box-crops').css('left', '-100%');
			});
		});

		function cropimages_bgr_shop() {
			var id = '#bgr-shop';
			var img = $(id).attr('src');
			loadAjax('<?= \yii\helpers\Url::to(['/management/crop/load-croppie']) ?>', {
				id: id,
				img: img,
				type: 'backgruond'
			}, $('#box-inner-croppie'));
			$('.box-crops').css('left', '0px');
		}

		function cropimages_ava_shop() {
			var id = '#avatar-shop';
			var img = $(id).attr('src');
			loadAjax('<?= \yii\helpers\Url::to(['/management/crop/load-croppie']) ?>', {
				id: id,
				img: img,
				type: 'avatar'
			}, $('#box-inner-croppie'));
			$('.box-crops').css('left', '0px');
		}
	</script>
</div>
<?php $this->endContent(); ?>