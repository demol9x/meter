<?php
$user = \common\models\User::findOne($model['user_sell_id']);
$shop = \common\models\shop\Shop::findOne($model['user_sell_id']);
if ($user) { ?>
	<style>
		.table td {
			border: 0px !important;
		}
	</style>
	<table class="table">
		<tr>
			<td>Tên ngời bán</td>
			<td><?= $user['username'] ?></td>
		</tr>
		<tr>
			<td>Số điện thoại</td>
			<td><?= $user['phone'] ?></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?= $user['email'] ?></td>
		</tr>
		<tr>
			<td>Số CMT</td>
			<td><?= $shop['cmt'] ?></td>
		</tr>
		<tr>
			<td>Mã số thuế</td>
			<td><?= $shop['number_auth'] ?></td>
		</tr>
		<tr>
			<td>Số giấy CNĐKKD</td>
			<td><?= $shop['number_paper_auth'] ?></td>
		</tr>
		<tr>
			<td>Cửa hàng trên OCOP</td>
			<td><a target="_blank" href="<?= \yii\helpers\Url::to(['/shop/shop/detail', 'id' => $shop['id'], 'alias' => $shop['alias']]) ?>"><?= $shop['name'] ?></a></td>
		</tr>
	</table>
	<hr />
	<p>Thông tin thêm</p>
	<div style="max-height: 200px; overflow: auto;">
		<?= nl2br($model['note']) ?>
	</div>
<?php } else {
	echo "<span>Người bán: Tài khoản đã không tồn tại trên hệ thống</span>";
} ?>