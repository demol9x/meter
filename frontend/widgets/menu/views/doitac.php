<style type="text/css">
    .item-doi-tac {
        height: 100px;
        overflow: hidden;
        display: inline-block;
        margin-right: 10px;
    }
    .item-doi-tac img {
        height: 100%;
        width: auto;
        max-width: unset;
    }
</style>
<?php if (isset($data) && $data) { ?>
    <div class="doi-tac">
        <?php foreach ($data as $menu) { 
            ?>
            <div class="item-doi-tac">
                <div class="img-item-doi-tac">
                    <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>">
                         <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>" title="<?= $menu['name']; ?>"  alt="<?= $menu['name']; ?>">
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
