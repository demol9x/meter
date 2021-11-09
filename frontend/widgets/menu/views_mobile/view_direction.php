<?php if (isset($data) && $data) { ?>
    <div class="cate-top-sell">
        <div class="container">
            <?php foreach ($data as $menu) { 
                $menu['name'] = Trans($menu['name'],$menu['name_en']);
                ?>
                <div class="item-top-sell">
                    <div class="img-top-sell">
                        <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link'] ?>" title="<?= $menu['name'] ?>">
                            <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>" alt="<?= $menu['name'] ?>" />
                        </a>
                    </div>
                    <div class="title-top-sell">
                        <h2>
                            <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link'] ?>" title="<?= $menu['name'] ?>"><?= $menu['name'] ?></a>
                        </h2>
                        <p><?= Trans($menu['description'], $menu['description_en']) ?></p>
                        <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link'] ?>" <?= $menu['name'] ?> class="view-more-btn hvr-float-shadow"><?= Yii::t('app','shop_now') ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>