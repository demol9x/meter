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
    	padding-top: 42px;
    }
</style> -->

<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
	<div id="main">
        <?= Alert::widget() ?>
	    <div class="create-page-store">
	        <div class="container">
	            <div class="row">
	                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
	                	<?= $content ?>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
<?php $this->endContent(); ?>
