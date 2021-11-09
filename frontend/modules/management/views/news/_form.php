<?php

use common\models\ActiveFormC; ?>
<?php $form = ActiveFormC::begin(); ?>
<?= $form->fields($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->fields($model, 'short_description')->textArea(['maxlength' => true, 'placeholder' => 'Mô tả ngắn']) ?>

<?= $form->fields($model, 'description')->textArea() ?>

<?= $form->fields($model, 'category_id', ['arrSelect' => (new \common\models\news\NewsCategory())->optionsCategory()])->textSelect() ?>

<?= $form->fields($model, 'source')->textInput(['maxlength' => true, 'placeholder' => 'Nguồn bài tin']) ?>
<?=
	\frontend\widgets\form\FormWidget::widget([
		'view' => 'form-img',
		'input' => [
			'model' => $model,
			'id' => 'avatar',
			'images' => ($model->avatar_name) ? \common\components\ClaHost::getImageHost() . $model['avatar_path'] . 's400_400/' . $model['avatar_name']  : null,
			'url' => \yii\helpers\Url::to(['/management/news/uploadfile']),
			'script' => '<script src="' . Yii::$app->homeUrl . 'js/upload/ajaxupload.min.js"></script>'
		]
	]);
?>

<div class="btn-submit-form">
	<input type="submit" id="shop-form" value="<?= ($model->isNewRecord) ?  Yii::t('app', 'create') :  Yii::t('app', 'update') ?>">
</div>
<?php ActiveFormC::end(); ?>