<?php

use yii\helpers\Url;

$item = \common\models\product\DiscountCode::loadShowAll();
?>
<style>
	body .list_post_news .filter {
		display: block;
	}

	.search_list {
		margin: 10px 0px;
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

	.list_post_news .list_content .title_list ul li:first-child,
	.list_post_news .list_content .item_list ul li:first-child {
		width: 16%;
	}

	.list_post_news .list_content .title_list ul li.title,
	.list_post_news .list_content .item_list ul li.title {
		width: 28%;
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

	.list_post_news .list_content .title_list ul li p:nth-child(2) a,
	.list_post_news .list_content .item_list ul li p:nth-child(2) a {
		color: #0DA600;
	}

	.list_post_news .exprire {
		color: #E53935 !important;
	}

	.list_post_news .intime {
		color: green !important;
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
		width: 100%;
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
		margin: 0px;
	}

	.list_post_news .filter .right .search_list .btn_sb {
		right: unset;
	}

	.list_post_news .filter .right {
		float: unset;
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
		<?php if ($shop->status_discount_code != 1) { ?>
			<p style="color: red; padding: 5px 15px">Tài khoản của quý khách hiện đang bị tạm khóa quyền thêm mã. Vui lòng liên hệ BQT để biết thêm chi tiết.</p>
		<?php } ?>
	</div>
	<div class="list_post_news">
		<div class="filter">
			<div class="left">
				<a href="<?= Url::to(['create']) ?>"><button>Thêm mới</button></a>
				<button class="delete-all">Xóa mã</button>
			</div>
			<div class="right">
				<form class="form-search">
					<div class="search_list">
						<input type="text" name="keyword" value="<?= isset($_GET['title']) ? $_GET['title'] : '' ?>" placeholder="Nhập mã">
						<button class="btn_sb"><i class="fa fa-search" aria-hidden="true"></i></button>
					</div>
					<select name="limit" class="change-limit">
						<?php foreach ($arr_limit as $key => $value) { ?>
							<option <?= ($limit == $value) ? 'selected' : '' ?> value="<?= $value ?>">Hiển thị <?= $value ?> bản ghi 1 trang</option>
						<?php } ?>
					</select>
				</form>
			</div>
		</div>
		<div class="list_content">
			<div class="title_list wow fadeInUp">
				<ul>
					<li>Mã</li>
					<li class="title">Thời gian</li>
					<li>Giá trị giảm</li>
					<li>Áp dụng với</li>
					<li>Trạng thái</li>
					<li>Thao tác <input class="item-check-all" type="checkbox" value="<?= $item['id'] ?>"></li>
				</ul>
			</div>
			<?php if ($data) { ?>
				<?php foreach ($data as $tg) {
					$item->setAttributeShow($tg);
					$link_delete = Url::to(['/management/discount-code/delete', 'id' => $item->id])
				?>
					<div class="item_list wow fadeInUp">
						<ul>
							<li>
								<div data-copy="<?= $item['id'] ?>" class="copte ctooltip">
									<?= $item['id'] ?>
									<span class="tooltiptext">Copy</span>
								</div>
							</li>
							<li class="title">
								<p>Từ <?= $item->show('time_start') ?> </p>
								<p class="<?= $item->time_end <= time() ? 'exprire' : 'intime' ?>">Đến <?= $item->show('time_end') ?> </p>
							</li>
							<li>
								<?= $item->showValue() ?>
							</li>
							<li><?= $item->showProducts() ?></li>
							<li> Đã dùng:
								<?= $item->count . '/' . $item->count_limit ?>
							</li>
							<li>
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
		$(document).on('click', '.copte', function() {
			copyToClipboard($(this).attr('data-copy'));
			$(this).find('.tooltiptext').html('Copied');
		});
		$(document).on('change', '.item-check-all', function() {
			if ($(this).is(":checked")) {
				$('.item-check').prop('checked', true);
			} else {
				$('.item-check').prop('checked', false);
			}
		});
		$(document).on('change', '.change-limit', function() {
			$('.form-search').submit();
		});
		$(document).on('click', '.delete_news', function() {
			if (confirm('Bạn có chắc chắn muốn xóa mã này?')) {
				loadAjaxPost($(this).attr('data-href'), {}, $(this).parent());
			}
		});

		$(document).on('click', '.delete-all', function() {
			if (confirm('Bạn có chắc chắn muốn xóa tất cả mã đã chọn?')) {
				items = $('input[name="item-check[]"]:checked').serialize();
				loadAjaxPost('<?= Url::to(['/management/discount-code/delete-all']) ?>', items, $(this).parent());
			}
		});
	</script>
</div>