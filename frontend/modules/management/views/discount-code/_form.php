<?php

use common\components\ActiveFormC;

$product_ns = \common\models\product\Product::find()->where(['shop_id' => Yii::$app->user->id])->all();
?>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>gentelella/bootstrap-daterangepicker/daterangepicker.css">
<script src="<?= Yii::$app->homeUrl ?>gentelella/moment/min/moment.min.js"></script>
<script src="<?= Yii::$app->homeUrl ?>gentelella/bootstrap-daterangepicker/daterangepicker.js"></script>
<style>
	.select-products {
		display: none;
	}

	.form-group .nice-select {
		width: 100%;
	}

	.form-group .nice-select ul {
		width: 100%;
	}

	.form-group .nice-select .current {
		float: left;
		margin-top: -7px
	}
</style>
<?php $form = ActiveFormC::begin(["options" => ['id' => 'form-load']]); ?>

<?= $form->fieldF($model, 'name')->textInput()->label() ?>

<?= $form->fieldF($model, 'quantity')->textInput()->label() ?>

<?= $form->fieldF($model, 'type_discount')->dropDownList(\common\models\product\DiscountCode::optionType())->label() ?>

<?= $form->fieldF($model, 'value')->textInput()->label() ?>

<?= $form->fieldF($model, 'count_limit')->textInput(['placeholder' => '1'])->label() ?>

<?= $form->fieldF($model, 'time_start')->textDate(['format' => 'DD-MM-YYYY HH:mm'])->label() ?>

<?= $form->fieldF($model, 'time_end')->textDate(['format' => 'DD-MM-YYYY HH:mm'])->label() ?>

<?= $form->fieldF($model, 'all')->dropDownList(['1' => 'Tất cả sản phẩm', '0' => 'Nhóm sản phẩm'])->label() ?>
<div class="select-products">
	<div class="form-group f">
		<div class="item-input-form">
			<label class="control-label col-md-2 col-sm-2 col-xs-12" for="discountshopcode-quantity">Sản phẩm</label>
			<div class="group-input">
				<table class="table" style="margin-top: 10px;">
					<tbody>
						<?php if ($product_ns) foreach ($product_ns as $product) { ?>
							<tr class="trupdt">
								<td><input type="checkbox" name="add[]" value="<?= $product->id ?>" class="checkp"></td>
								<td>
									<b><?= $product->name ?></b>
								</td>
							</tr>
						<?php }
						else { ?>
							<tr>
								<td colspan="5">Không có sản phẩm</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).on('change', '#discountshopcode-all', function() {
		if ($(this).val() == '0') {
			$('.select-products').addClass('show');
			$('#form-load').addClass('checkproduct');
		} else {
			$('.select-products').removeClass('show');
			$('#form-load').removeClass('checkproduct');
		}
	});
	$("#form-load").submit(function() {
		if ($(this).hasClass('checkproduct')) {
			if ($('.checkp:checked').length == 0) {
				alert("Vui lòng chọn ít nhất một sản phẩm.");
				return false;
			}
		}
		return true;
	});
</script>
<div class="btn-submit-form">
	<input type="submit" id="shop-form" value="<?= ($model->isNewRecord) ?  Yii::t('app', 'create') :  Yii::t('app', 'update') ?>">
</div>
<?php ActiveFormC::end(); ?>