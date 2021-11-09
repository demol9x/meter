<?php if (isset($data) && $data) { ?>
    <div class="container">
        <div class="index_col_title white-bg">
            <div class="collection-name">
                <h3>
                    <img src="<?= Yii::$app->homeUrl ?>images/icon-logo.png" alt="logo">
                    <a href="javascript:void(0)"><?= Trans($menu_group['name'],$menu_group['name_en']) ?></a>
                </h3>
            </div>
        </div>
        <?php foreach ($data as $menu) { 
            $menu['name'] = Trans($menu['name'],$menu['name_en']);
            ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item-support-index">
                    <div class="img-item-support-index">
                        <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>" title="<?= $menu['name'] ?>">
                            <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>"
                                 alt="<?php echo $menu['name']; ?>"/>
                        </a>
                    </div>
                    <div class="title-item-support-index">
                        <h2>
                            <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>" title="<?= $menu['name'] ?>">
                                <?= $menu['name']; ?>
                            </a>
                        </h2>
                        <p>
                            <?= Trans($menu['description'], $menu['description_en']); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
