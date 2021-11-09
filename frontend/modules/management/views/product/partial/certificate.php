<?php

use yii\helpers\Html;
use common\components\ClaHost;
?>
<style type="text/css">
	.box-checkbox-certificate {
		width: 50%;
		padding-top: 20px;
		float: left;
		text-align: center;
		border: 1px solid #ebebeb;
		margin-top: 10px;
	}

	.box-img-certificate .btn-imgs {
		width: 100%;
	}
</style>
<div class="item-input-form">
	<label class="bold" for=""><?= Yii::t('app', 'certificate') ?></label>
	<div class="group-input">
		<?php $kt = 1;
		foreach ($certificates as $certificate) {
			$certificate_img = isset($certificate_items[$certificate['id']]) ? $certificate_items[$certificate['id']] : null;
		?>
			<div class="box-checkbox-certificate">
				<div class="label-checkbox-certificate">
					<label class="click"><?= $certificate['name'] ?></label>
					<input type="checkbox" name="certificate[]" value="<?= $certificate['id'] ?>" <?= ($certificate_img) ? 'checked' : '' ?>>
				</div>
				<div class="box-img-certificate">
					<?php
					if ($kt) {
						echo frontend\widgets\form\FormWidget::widget([
							'view' => 'form-img-2',
							'input' => [
								'value' => ($certificate_img) ? $certificate_img['id'] : '',
								'id' => 'certificate' . $certificate['id'],
								'images' => ($certificate_img) ? ClaHost::getImageHost() . $certificate_img['avatar_path'] . 's100_100/' . $certificate_img['avatar_name']  : null,
								'url' => yii\helpers\Url::to(['/management/product/uploadfilec']),
								'script' => '<script src="' . Yii::$app->homeUrl . 'js/upload/ajaxupload.min.js"></script>',
								'link_certificate' => $certificate_img['link_certificate'],
								'model' => $model
							]
						]);
					} else {
						echo frontend\widgets\form\FormWidget::widget([
							'view' => 'form-img-2',
							'input' => [
								'value' => ($certificate_img) ? $certificate_img['id'] : '',
								'id' => 'certificate' . $certificate['id'],
								'images' => ($certificate_img) ? ClaHost::getImageHost() . $certificate_img['avatar_path'] . 's100_100/' . $certificate_img['avatar_name']  : null,
								'url' => yii\helpers\Url::to(['/management/product/uploadfilec']),
								'link_certificate' => $certificate_img['link_certificate'],
								'model' => $model
							]
						]);
					}

					?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.label-checkbox-certificate label').click(function() {
			$(this).parent().find('input').click();
		})
	})
</script>