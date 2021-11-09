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
		/*body .form-group {
		    width: 100%;
		    overflow: hidden;
		}
		body .ctn-form .item-input-form .group-input {
		    max-width: unset;
		}
		#wrap_image_album {
		    width: 493px;
		}*/
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
	                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
<?php $this->endContent(); ?>
