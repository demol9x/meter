<style type="text/css">
	.checkbox i {
		width: 20px;
	    height: 20px;
	    z-index: 9999;
	    position: absolute;
	    left: 2px;
	    top: 1px;
	}
</style>
<?php if (isset($data) && $data) { ?>
    <div class="top-5-reason">
        <div class="title-top-reason">
            <h2><?= Trans($menu_group->name, $menu_group->name_en) ?></h2>
        </div>
        <ul>
        	<?php foreach ($data as $menu) { ?>
            <li>
                <div class="awe-check">
                    <div class="checkbox">
                    	<a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>"
                    	> <i class="fa fa-check" aria-hidden="true"></i> <label><?= Trans($menu['name'],$menu['name_en']); ?></label></a>
                    </div>
                </div>
            </li>
           <?php } ?>
        </ul>
    </div>
<?php } ?>
