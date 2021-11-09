<?php if (isset($data) && $data) { ?>
    <div class="container">
        <div class="camket">
            <div class="container">
                <div class="owl-item-camket">
                    <?php foreach ($data as $menu) { 
                        $menu['name'] = Trans($menu['name'],$menu['name_en']);
                        ?>
                        <div class="item-camket">
                            <div class="img-item-camket">
                                <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>">
                                     <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>"  alt="<?= $menu['name']; ?>">
                                </a>
                                <h2><a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>"><?= $menu['name']; ?></a></h2>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>
