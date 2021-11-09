<style>
	.box-config-affiliate {
		display: none;
	}

	.box-config-affiliate.active {
		display: block;
	}
</style>
<div class="form-group field-product-status_affiliate has-success" style="clear: both;">
	<div class="full-input-checkbox">
		<span class="labelss">Tham gia affiliate: </span>
		<input type="checkbox" name="Product[status_affiliate]" value="<?= \common\components\ClaLid::STATUS_ACTIVED ?>" <?= $model->status_affiliate ? 'checked' : '' ?> id="checkbox-status_affiliate" class="ios8-switch ios8-switch-small status_affiliate">
		<label for="checkbox-status_affiliate"></label>
	</div>
	<div class="box-config-affiliate <?= $model->status_affiliate ? 'active' : '' ?>">
		<p>Nhập số tiền affiliate cho các đối tượng nhận được.</p>
		<?= $form->fields($model, 'affiliate_admin', ['class' => ''])->textInput() ?>
		<?= $form->fields($model, 'affiliate_gt_product', ['class' => ''])->textInput() ?>
		<?= $form->fields($model, 'affiliate_gt_shop', ['class' => ''])->textInput() ?>
		<?= $form->fields($model, 'affiliate_m_v', ['class' => ''])->textInput() ?>
		<?= $form->fields($model, 'affiliate_m_ov', ['class' => ''])->textInput() ?>
		<?= $form->fields($model, 'affiliate_safe', ['class' => ''])->textInput() ?>
	</div>
</div>
<script type="text/javascript">
	$('#checkbox-status_affiliate').change(function() {
		if ($(this).is(':checked')) {
			$('.box-config-affiliate').addClass('active');
		} else {
			$('.box-config-affiliate').removeClass('active');
		}
	});
</script>