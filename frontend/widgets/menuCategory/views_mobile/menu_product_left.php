<?php
use yii\helpers\Url;
$href = $_GET;
if(isset($href['category_id'])) unset($href['category_id']);
?>
<style type="text/css">
	.select-category {
		cursor: pointer;
	}
</style>
<?php if (isset($data) && $data) { ?>
    <h2><?= Yii::t('app', 'menu_product') ?></h2>
    <ul>
        <?php foreach ($data as $menu) { ?>
            <li>
            	<a class="select-category" data="<?= $menu['id'] ?>"><?= $menu['name'] ?> </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.select-category').click(function() {
			var id = $(this).attr('data');
			document.location.href = '<?= Url::to(array_merge(['/shop/shop/detail'],$href, ['category_id'=>''])) ?>'+ id;
		});
	});
</script>
