<?php

$shop = \common\models\shop\Shop::findOne(Yii::$app->user->id);
?>
<style type="text/css">
	.error {
		color: red;
	}

	.col-50 {
		width: 50%;
		float: left;
	}

	.img-form {
		min-height: 200px;
		width: 100%;
		display: grid;
		height: 200px;
		text-align: center;
	}

	.box-imgs {
		padding-right: 91px;
		margin-left: -15px;
	}

	label {
		font-weight: 400;
	}

	.bold {
		font-weight: bold;
	}

	.full-input-checkbox {
		padding-bottom: 20px;
	}
</style>
<div class="item-input-form">
	<label class="bold" for=""><?= Yii::t('app', 'basic_info') ?></label>
	<div class="group-input">

		<?= $form->fields($model, 'name', ['class' => ''])->textInput(['maxlength' => true]) ?>

		<?= $form->fields($model, 'description', ['class' => ''])->textArea(['maxlength' => true]) ?>

		<?php $list_cat = (new \common\models\product\ProductCategory())->optionsCategory(); ?>
		<?= $form->fields($model, 'category_id', ['class' => '', 'arrSelect' => $list_cat])->textSelect() ?>

		<?php if ($shop && $shop->status_affiliate == \common\components\ClaLid::STATUS_ACTIVED) { ?>
			<div class="form-group field-product-status_affiliate has-success">
				<div class="full-input-checkbox">
					<span class="labelss">Tham gia affiliate: </span>
					<input type="checkbox" name="Product[status_affiliate]" value="<?= \common\components\ClaLid::STATUS_ACTIVED ?>" <?= $model->status_affiliate ? 'checked' : '' ?> id="checkbox-status_affiliate" class="ios8-switch ios8-switch-small status_affiliate">
					<label for="checkbox-status_affiliate"></label>
				</div>
			</div>
		<?php } ?>

		<?php $model->price = $model->price ? number_format($model->price, 0, ',', '.') : ''; ?>

		<div class="full-input">
			<p class="skip"><?= Yii::t('app', 'create_product_3') ?></p>
			<?= $form->field($model, 'price', [
				'template' => '{input}{error}'
			])->textInput(['class' => 'change-price-s', 'placeholder' => Yii::t('app', 'enter_price')]);
			?>
			<?=
				frontend\widgets\form\FormWidget::widget([
					'view' => 'form-price',
					'input' => [
						'model' => $model,
					]
				]);
			?>

			<p class="skip"><?= Yii::t('app', 'create_product_4') ?></p>
		</div>
		<?= $form->fields($model, 'quantity', ['class' => ''])->textInput() ?>

		<div class="form-group field-product-quantity has-success">
			<div class="full-input-checkbox">
				<span class="labelss"><?= Yii::t('app', 'have_product') ?>: </span>
				<input type="checkbox" name="Product[status_quantity]" value="1" <?= $model->status_quantity ? 'checked' : '' ?> id="checkbox-status_quantity" class="ios8-switch ios8-switch-small status_quantity">
				<label for="checkbox-status_quantity"></label>
			</div>
		</div>

		<?= $form->fields($model, 'unit', ['class' => ''])->textInput() ?>

	</div>
</div>
<script type="text/javascript">
	function cropimages(_this, img, id) {
		var id_div = '#img-up-' + id;
		loadAjax('<?= \yii\helpers\Url::to(['/management/crop/load-croppie-product']) ?>', {
			id: id,
			img: img,
			id_div: id_div
		}, $('#box-inner-croppie'));
		$('.box-crops').css('left', '0px');
		$('body').css('overflow', 'hidden');
	}
</script>