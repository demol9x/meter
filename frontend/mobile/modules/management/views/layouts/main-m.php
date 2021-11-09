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
<!-- <style type="text/css">
    .create-page-store >.container > .row {
    	padding-top: 45px;
    }
</style> -->
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
	<div id="main">
	    <div class="breadcrumb">
	        <div class="container">
	            <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
	        </div>
	    </div>
        <?= Alert::widget() ?>
        <div class="back-page-version" data-role="controlgroup" data-mini="true" data-type="horizontal">
	        <a href="<?= Url::to(['/management/shop/index']) ?>" class="next" data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span">
	            <img src="<?= Yii::$app->homeUrl ?>images/arrow-left-mobile.png" alt="">
	            Quay lại
	        </a>
	        <a href="<?= Url::to(['/management/shop/index']) ?>" class="back-top-home"  data-transition="flip" data-role="button" data-inline="true" data-mini="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span">
	            <img src="<?= Yii::$app->homeUrl ?>images/back-to-home.png" alt="">
	        </a>
	    </div>
	    <div class="create-page-store">
	        <div class="container">
	            <div class="row">
	                <div class="col-xs-12">
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
