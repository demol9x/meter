<?php if (isset($data) && $data) { ?>
    <div class="why-buyon-gca">
        <h2><?= $menu_group->name ?></h2>
        <div class="container">
            <div class="row">
                <?php foreach ($data as $menu) { ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                        <div class="item-why-gca">
                            <div class="img-item-why-gca">
                                <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>" alt="<?= $menu['name'] ?>" />
                            </div>
                            <h3><?= $menu['name'] ?></h3>
                            <p><?= $menu['description'] ?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>