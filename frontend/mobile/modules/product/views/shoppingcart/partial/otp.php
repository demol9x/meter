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
        case 'send': 
        	$user_coin = \common\models\gcacoin\Gcacoin::findOne(Yii::$app->user->id);
        	$coin = (isset($user_coin->gca_coin) && $user_coin->gca_coin) ? $user_coin->getCoin() : 0;
        	$total = \common\models\gcacoin\Gcacoin::getCoinToMoney($total);
        	?>
            <script type="text/javascript">
            	html = '<div class="otp-order"><p class="title">Otp thanh toán bằng OCOP V.</p>';
            	html2= '<p><span class="name">Số V hiện tại:</span> <span class="value"><?= number_format($coin, 0, '.', ',') ?></span></p>';
            	html2+= '<p><span class="name">Số V chi trả đơn hàng:</span> <span class="value">-<?= number_format($total, 0, '.', ',') ?></span></p>';
            	html2+= '<p><span class="name">Số V còn lại:</span> <span class="value"><?= number_format($coin - $total, 0, '.', ',') ?></span></p>';
            	html += html2;
            	html += '<p>Xác nhận OTP đã được gửi đến số điện thoại <b><?= $user['phone'] ?></b>. Vui lòng đợi trong giây lát hoặc.<a class="click" onclick="sendOtpAgain()">Gửi lại OTP</a> nếu bạn chưa nhận được mã OTP.</p></div>';
            	$('#opt-data').html(html2);
			    promptCS(html, 'Nhập OTP');
			    function yesPrompt(value, data) {
			        loadAjax("<?= \yii\helpers\Url::to(['/product/shoppingcart/check-otp']) ?>", { otp: value }, $('#opt-response'));
			    }

			</script>
        <?php break; ?>
        <?php case 'check': 
        	\Yii::$app->session->open();
        	?>
            <script type="text/javascript">
                $('.button-order-buy').html('Đang đặt hàng. Quý khách vui lòng chờ trong giây lát <img style="padding:5px 10px;" src="images/ajax-loader.gif" />');
        		$('#form-checkout').submit();
            </script>
        <?php break; ?>
<?php } ?>
