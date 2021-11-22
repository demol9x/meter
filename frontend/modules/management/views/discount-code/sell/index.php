<?php

use yii\helpers\Url;

$arr_viewed = [
	'' => 'Trạng thái',
	'0' => 'Chưa xem',
	'1' => 'Đã xem',
];
$viewed = isset($_GET['viewed']) ? $_GET['viewed'] : NULL;
?>
<style>
	a {
		cursor: pointer;
	}

	.title span {
		display: block;
	}

	.post_news .input_group,
	.form_create .input_group {
		margin-bottom: 20px;
	}

	@media (max-width: 580px) {

		.post_news .input_group,
		.form_create .input_group {
			margin-bottom: 0px;
			margin-top: 10px;
		}
	}

	.post_news .input_group:first-child,
	.form_create .input_group:first-child {
		margin-top: 0px;
	}

	.post_news .input_group .ip>p,
	.form_create .input_group .ip>p {
		margin: 0px;
		margin-bottom: 20px;
		font-style: normal;
		font-weight: normal;
		line-height: 21px;
		font-size: 14px;
		color: #717273;
	}

	@media (max-width: 767px) {

		.post_news .input_group .ip>p,
		.form_create .input_group .ip>p {
			margin-bottom: 10px;
		}
	}

	.post_news .input_group>label,
	.form_create .input_group>label {
		font-weight: 500;
		color: #333333;
	}

	.post_news .input_group .item_g,
	.form_create .input_group .item_g {
		margin-bottom: 20px;
		float: left;
		width: 100%;
	}

	@media (max-width: 580px) {

		.post_news .input_group .item_g,
		.form_create .input_group .item_g {
			margin-bottom: 10px;
		}
	}

	.post_news .input_group .item_g label,
	.form_create .input_group .item_g label {
		border: none;
		font-style: normal;
		font-weight: 500;
		line-height: normal;
		font-size: 14px;
		color: #717273;
		margin-bottom: 9px;
		height: auto;
		padding: 0px;
		font-weight: 400;
		width: auto !important;
	}

	@media (max-width: 580px) {

		.post_news .input_group .item_g label,
		.form_create .input_group .item_g label {
			margin: 10px 0px;
		}
	}

	.post_news .input_group .item_g p,
	.form_create .input_group .item_g p {
		font-style: italic;
		font-weight: normal;
		line-height: 18px;
		font-size: 13px;
		color: #909090;
	}

	.post_news .input_group .item_g p.text_count,
	.form_create .input_group .item_g p.text_count {
		margin: 10px 0px;
		text-align: right;
		font-style: normal;
		font-weight: normal;
		line-height: normal;
		font-size: 14px;
		color: #717273;
		margin-bottom: 0px;
	}

	.post_news .input_group .item_g textarea,
	.form_create .input_group .item_g textarea {
		width: 100%;
		border: 1px solid #D2D4D7;
		padding: 14px 19px;
		font-style: normal;
		font-weight: normal;
		line-height: 23px;
		font-size: 15px;
		color: #717273;
		min-width: 100%;
	}

	.post_news .input_group .item_g select,
	.form_create .input_group .item_g select {
		height: auto;
		padding: 0px;
	}

	.post_news .input_group .item_g select option,
	.form_create .input_group .item_g select option {
		height: 45px;
		display: flex;
		align-items: center;
		padding-left: 10px;
	}

	.post_news .input_group .list_c input,
	.form_create .input_group .list_c input {
		margin-top: -3px;
	}

	.post_news .input_group .chose_img,
	.form_create .input_group .chose_img {
		width: calc(25% - 16px);
		height: 156px;
		float: left;
		background: #FCFCFC;
		border: 1px dashed #CFCFCF;
		box-sizing: border-box;
		border-radius: 3px;
		position: relative;
		margin: 0px 8px;
	}

	.post_news .input_group .chose_img:first-child,
	.form_create .input_group .chose_img:first-child {
		margin-left: 0px;
	}

	.post_news .input_group .chose_img:last-child,
	.form_create .input_group .chose_img:last-child {
		margin-right: 0px;
	}

	@media (max-width: 580px) {

		.post_news .input_group .chose_img,
		.form_create .input_group .chose_img {
			width: calc(50% - 16px);
			margin: 5px 16px 0px 0px;
		}

		.post_news .input_group .chose_img:last-child,
		.form_create .input_group .chose_img:last-child {
			margin-right: 0px;
		}
	}

	.post_news .input_group .chose_img input,
	.form_create .input_group .chose_img input {
		position: absolute;
		left: 0;
		top: 0;
		right: 0;
		bottom: 0;
		opacity: 0;
		height: 100%;
		cursor: pointer;
	}

	.post_news .input_group .chose_img i,
	.form_create .input_group .chose_img i {
		width: 100%;
		text-align: center;
		font-size: 24px;
	}

	.post_news .input_group .chose_img label,
	.form_create .input_group .chose_img label {
		width: 100%;
		border: 0px;
		text-align: center;
		margin: 0px;
	}

	.post_news .input_group .chose_img div,
	.form_create .input_group .chose_img div {
		padding: 45px 0px;
		text-align: center;
	}

	#cke_editor1,
	#cke_editor2 {
		float: left;
		width: 100%;
	}

	.list_post_news .filter {
		margin-bottom: 20px;
		float: left;
		width: 100%;
	}

	@media (max-width: 992px) {
		.list_post_news .filter {
			display: none;
		}
	}

	.list_post_news .filter .left {
		float: left;
	}

	.list_post_news .filter .left button {
		width: 105px;
		height: 35px;
		line-height: 30px;
		font-style: normal;
		font-weight: 500;
		font-size: 13px;
		color: #FFFFFF;
		background: #2668E0;
		border: none;
		float: left;
	}

	.list_post_news .filter .left button:nth-child(2) {
		background: #E53935;
		margin-left: 10px;
	}

	.list_post_news .filter .right {
		float: right;
	}

	.list_post_news .filter .right .search_list {
		width: 272px;
		float: left;
		position: relative;
	}

	@media (max-width: 992px) {
		.list_post_news .filter .right .search_list {
			width: 200px;
		}
	}

	.list_post_news .filter .right .search_list input {
		height: 35px;
		font-style: italic;
		font-weight: normal;
		line-height: normal;
		font-size: 12px;
		padding-left: 13px;
		color: #9A9A9A;
		width: 100%;
	}

	.list_post_news .filter .right .search_list .btn_sb {
		position: absolute;
		background: #E53935;
		top: 0px;
		height: 0px;
		border: none;
		height: 35px;
		right: 0px;
		width: 46px;
		text-align: center;
		color: #fff;
	}

	.list_post_news .filter .right select {
		height: 35px;
		padding: 0px 15px;
		margin-left: 15px;
		float: left;
	}

	.list_post_news .list_content {
		float: left;
		width: 100%;
		margin-bottom: 20px;
	}

	@media (max-width: 992px) {
		.list_post_news .list_content {
			overflow-y: scroll;
		}
	}

	.list_post_news .list_content .title_list,
	.list_post_news .list_content .item_list {
		float: left;
		width: 100%;
	}

	@media (max-width: 992px) {

		.list_post_news .list_content .title_list,
		.list_post_news .list_content .item_list {
			min-width: 768px;
		}
	}

	.list_post_news .list_content .title_list ul,
	.list_post_news .list_content .item_list ul {
		list-style: none;
		padding: 0px;
		border-left: 1px solid #F0F1F4;
		float: left;
		width: 100%;
		margin: 0px;
	}

	.list_post_news .list_content .title_list ul li,
	.list_post_news .list_content .item_list ul li {
		margin: 0px;
		float: left;
		width: 14%;
		float: left;
		padding: 18px 19px;
		font-style: normal;
		height: 105px;
		line-height: normal;
		font-size: 14px;
		color: #717273;
		border-right: 1px solid #F0F1F4;
		border-bottom: 1px solid #F0F1F4;
	}

	.list_post_news .list_content .title_list ul li.title,
	.list_post_news .list_content .item_list ul li.title {
		width: 30%;
	}

	.list_post_news .list_content .title_list ul li.title a,
	.list_post_news .list_content .item_list ul li.title a {
		color: #717273;
	}

	.list_post_news .list_content .title_list ul li p,
	.list_post_news .list_content .item_list ul li p {
		margin: 0px;
		line-height: 20px;
		font-style: normal;
		font-weight: normal;
		line-height: 21px;
		font-size: 14px;
		color: #717273;
	}

	.list_post_news .list_content .title_list ul li p a,
	.list_post_news .list_content .item_list ul li p a {
		color: #717273;
	}

	.list_post_news .list_content .title_list ul li p a i,
	.list_post_news .list_content .item_list ul li p a i {
		margin-right: 9px;
	}

	.list_post_news .list_content .item_list ul li p a {
		color: #0DA600;
	}

	.list_post_news .list_content .title_list ul li p:last-child,
	.list_post_news .list_content .item_list ul li p:last-child {
		color: #E53935;
	}

	.list_post_news .list_content .title_list ul li p:last-child a,
	.list_post_news .list_content .item_list ul li p:last-child a {
		color: #E53935;
	}

	.list_post_news .list_content .title_list ul li p input,
	.list_post_news .list_content .item_list ul li p input {
		float: right;
	}

	.list_post_news .list_content .title_list ul {
		background: #F4F8FF;
	}

	.list_post_news .list_content .title_list ul li {
		color: #333333;
		height: auto;
		font-weight: bold;
	}

	.list_post_news .filter .right .search_list {
		width: 360px;
		float: left;
		position: relative;
	}

	.list_post_news .filter .right .search_list select {
		float: right;
		margin: 0px;
	}

	.list_post_news .filter .right .search_list input {
		float: left;
		width: calc(100% - 140px);
		margin-right: 20px;
	}

	.list_post_news .filter .right .search_list .btn_sb {
		right: 140px;
	}

	.evaluate {
		color: #333333;
	}

	select {
		background: #fff;
	}

	.list_post_news .filter .right .change-limit {
		clear: unset;
	}

	.list_post_news {
		padding: 10px;
	}
</style>
<div class="form-create-store">
	<div class="title-form">
		<h2>
			<img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= $this->title ?>
		</h2>
	</div>
	<div class="list_post_news">
		<div class="filter">
			<div class="left">
				<button class="delete-all">Xóa nhiều</button>
			</div>
			<div class="right">
				<form class="form-search">
					<div class="search_list">
						<input type="text" name="key" value="<?= isset($_GET['key']) ? $_GET['key'] : '' ?>" placeholder="Nhập từ khóa liên quan">
						<button class="btn_sb"><i class="fa fa-search" aria-hidden="true"></i></button>
					</div>
					<select name="viewed" class="change-limit">
						<?php foreach ($arr_viewed as $key => $value) { ?>
							<option <?= ($viewed == $key && is_numeric($viewed)) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>
					</select>
				</form>
			</div>
		</div>
		<div class="list_content">
			<div class="title_list wow fadeInUp">
				<ul>
					<li>STT</li>
					<li class="title">Thông tin</li>
					<li>Số lượng bán</li>
					<li>Giá bán</li>
					<li>Trạng thái</li>
					<li>Thao tác </li>
				</ul>
			</div>
			<?php if ($data) { ?>
				<?php
				$i = 1;
				foreach ($data as $item) {
					$news = \common\models\news\News::findOne($item['news_id']);
					if ($news) {
						$link = Url::to(['/news/news/detail', 'id' => $news['id'], 'alias' => $news['alias']]);
						$item['news_title'] = $news['title'];
					} else {
						$link = '#';
					}
					$link_views = Url::to(['sell-view', 'id' => $item['id']]);
					$link_delete = Url::to(['sell-delete', 'id' => $item['id']]);
				?>
					<div class="item_list wow fadeInUp">
						<ul>
							<li>#<?= $i++ ?> </li>
							<li class="title">
								<?php
								$user = \common\models\User::findOne($item['user_sell_id']);
								if ($user) { ?>
									<span>Người bán: <?= $user->username ?></span>
									<span>Số điện thoại: <?= $user->phone ?></span>
								<?php } else {
									echo "<span>Người bán: Tài khoản đã không tồn tại trên hệ thống</span>";
								} ?>
								<span>Tin: <a href="<?= $link ?>" target="_blank"><?= $item['news_title'] ?></a></span>
							</li>
							<li><?= $item['quantity'] ?></li>
							<li>
								<?= number_format($item['price'], 0, ',', '.') ?>
							</li>
							<li class="view-status"> <?= $item['viewed'] ? 'Đã xem' : 'chưa xem'; ?></li>
							<li>
								<p><a class="open-popup-link form-info" data-href="<?= $link_views ?>" href="#form-info"><i class="fa fa-eye" aria-hidden="true"></i>Xem</a></p>
								<p><a class="delete_news" data-href="<?= $link_delete ?>"><i class="fa fa-times" aria-hidden="true"></i>Xóa</a>
									<input class="item-check" name="item-check[]" type="checkbox" value="<?= $item['id'] ?>">
								</p>
							</li>
						</ul>
					</div>
			<?php }
			} ?>
		</div>
		<div class="pagination">
			<?=
				yii\widgets\LinkPager::widget([
					'pagination' => new yii\data\Pagination([
						'defaultPageSize' => $limit,
						'totalCount' => $totalitem
					])
				]);
			?>
		</div>
	</div>
	<script type="text/javascript">
		$(document).on('change', '.change-limit', function() {
			$('.form-search').submit();
		});
		$(document).on('click', '.delete_news', function() {
			if (confirm('Bạn có chắc chắn muốn xóa mục này?')) {
				loadAjaxPost($(this).attr('data-href'), {}, $(this).parent());
			}
		});
		$(document).on('click', '.delete-all', function() {
			if (confirm('Bạn có chắc chắn muốn xóa tất cả mục đã chọn?')) {
				items = $('input[name="item-check[]"]:checked').serialize();
				loadAjaxPost('<?= Url::to(['/management/news/sell-delete-all']) ?>', items, $(this).parent());
			}
		});
		$(document).on('click', '.form-info', function() {
			$(this).parent().parent().parent().find('.view-status').html('Đã xem');
			loadAjax($(this).attr('data-href'), {}, $('#box-info'));
		});
	</script>
</div>
<div id="form-info" class="white-popup mfp-hide">
	<div class="box-account">
		<span class="mfp-close"></span>
		<div class="bg-pop-white">
			<div class="title-popup">
				<h2>Thông tin người bán:</h2>
			</div>
			<div class="ctn-review-popup" id="box-info">
			</div>
		</div>
	</div>
</div>