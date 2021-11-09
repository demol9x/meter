<?php

use yii\helpers\Url;

?>
<div class="list-skip-link">
    <ul>
        <li class="btn-show-cate-mobile">
            <div class="ico">
                <img src="<?= Yii::$app->homeUrl ?>images/03.png" alt="<?= Yii::t('app', 'all_menu') ?>">
            </div>
            <div class="title">
                <h2>
                    <a><?= Yii::t('app', 'all_menu') ?></a>
                </h2>
            </div>
        </li>
        <?php if (isset($data) && $data) { ?>
            <?php
            foreach ($data as $menu) {
                $name = $menu['name'];
                ?>
                <li class="btn-show-store-mobile">
                    <div class="ico">
                        <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>">
                            <img src="<?= common\components\ClaHost::getImageHost(), $menu['avatar_path'], $menu['avatar_name'] ?>"
                                 alt="<?= $name ?>" alt="<?= $name ?>">
                        </a>
                    </div>
                    <div class="title">
                        <h2>
                            <a <?= $menu['target'] ? 'target="_blank"' : '' ?> href="<?= $menu['link']; ?>" class="<?=($menu['description']=='copy') ? 'copy_' : ''?>"><?= $name ?></a>
                        </h2>
                    </div>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>
<input id="linkcopy" value="<?= \yii\helpers\Url::to(['/login/login/signup', 'user_id' => Yii::$app->user->id], true); ?>">
<script type="text/javascript">
    $('.copy_').click(function () {
        var copyText = document.getElementById("linkcopy");
        copyText.select();
        document.execCommand("copy");
        $(this).html('Copied Link Affiliate');
        return false;
    });
</script>
<style>
    #linkcopy {
        opacity: 0;
        position: absolute;
        right: 0;
    }
    .product-inhome {
        overflow: hidden;
    }
</style>