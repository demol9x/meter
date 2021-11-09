<?=
	$form->field($model, 'status_affiliate', [
		'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
	])->checkbox([
		'class' => 'js-switch',
		'label' => NULL
	])->label($model->getAttributeLabel('status_affiliate'), [
		'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
	])
?>

<?= $form->field($model, 'affiliate', [
	'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->textInput(['maxlength' => true])->label($model->getAttributeLabel('affiliate'), [
	'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
]) ?>

<div id="box-responce" class="hidden"></div>
<?php if (\common\components\ClaLid::getSiteinfo()->otp) { ?>
	<script type="text/javascript">
		$(document).ready(function() {
			var check = 0;
			$('#five-tab').click(function() {
				if (check == 0) {
					check = 1;
					$('#submit-form').click(function() {
						if (confirm('Xác thực OPT để lưu thay đổi')) {
							loadAjaxPost('<?= \yii\helpers\Url::to(['/gcacoin/otp/get-otp']) ?>', {}, $('#box-responce'));
						}
						return false;
					})
				}
			});
		});
	</script>
<?php } ?>