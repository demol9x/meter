<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\ClaHost;

/* @var $this yii\web\View */
/* @var $model common\models\product\CertificateProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-bars"></i> <?= Html::encode($this->title) ?> </h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	    <div class="box-imgs">
			<?=
			    backend\widgets\form\FormWidget::widget([
			        'view' => 'form-img',
			        'input' => [
			            'model' => $model,
			            'id' => 'avatar',
			            'images'=> ($model->avatar_name) ? ClaHost::getImageHost().$model['avatar_path'].'s100_100/'.$model['avatar_name']  : null,
			            'url' => yii\helpers\Url::to(['/product/certificate-product/uploadfile']),
			            'script' => '<script src="'.Yii::$app->homeUrl.'js/upload/ajaxupload.min.js"></script>'
			        ]
			    ]);
			?>
		</div>
	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'create') : Yii::t('app', 'update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>
	</div>
</div>
