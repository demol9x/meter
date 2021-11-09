<style type="text/css">
	.line-header ul li a:hover {
		text-decoration: underline;
	}
</style>
<?php $i=0; if (isset($data) && $data) { ?>
<ul class="slider-line-header">
    <?php foreach ($data as $menu) { $i++;?>
    <li><a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link'] ?>"><?= Trans($menu['name'],$menu['name_en']) ?></a> <span>.</span></li>
    <?php } ?>
</ul>
<?php } ?>
