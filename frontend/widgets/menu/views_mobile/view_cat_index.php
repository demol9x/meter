<?php if (isset($data) && $data) { ?>
    <div class="container">
        <div class="row">
            <?php
                foreach ($data as $menu) {
                $name =  Trans($menu['name'], $menu['name_en']);
                ?>
                <div class="item-categories">
                    <div class="img-item-categories">
                        <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>">
                            <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>"  alt="<?= $name ?>" alt="">
                        </a>
                    </div>
                    <div class="title-item-categories">
                        <div class="vertical-box">
                            <h2><a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>"><?= $name ?></a></h2>
                            <p>
                                <?= Trans($menu['description'], $menu['description_en']); ?>
                            </p>
                            <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>" class="view-more-categories"><?= Yii::t('app','view_more') ?></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
