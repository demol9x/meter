<style type="text/css">
	#alertBox .otp-order p {
		text-align: center;
		font-size: 14px;
		padding: 1px 10px;
	}

	body .otp-order .title {
		font-weight: bold;
		font-size: 14px;
		text-transform: uppercase;
		margin-top: -10px;
	}

	.otp-order .value {
		font-weight: bold;
		color: #0e8238;
	}
</style>
<?php
switch ($success) {
	case 'send':  ?>
		<script type="text/javascript">
			html = '<div class="otp-order"><p class="title">Xác nhận thanh toán bằng OCOP V.</p>';
			html += '<p>Nhập mật khẩu cấp 2.</p></div>';
			$('#opt-data').html(html);
			promptCS(html, '*******');
			$('#PromptCSInput').attr('type', 'password');

			function yesPrompt(value, data) {
				loadAjax("<?= \yii\helpers\Url::to(['/product/shoppingcart/check-otp']) ?>", {
					otp: value
				}, $('#opt-response'));
			}
		</script>
		<?php break; ?>
	<?php
	case 'check':
		\Yii::$app->session->open();
	?>
		<script type="text/javascript">
			$('.button-order-buy').html('Đang đặt hàng. Quý khách vui lòng chờ trong giây lát <img style="padding:5px 10px;" src="images/ajax-loader.gif" />');
			$('#form-checkout').submit();
		</script>
		<?php break; ?>
<?php } ?>