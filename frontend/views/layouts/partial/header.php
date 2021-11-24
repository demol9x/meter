<?php

use yii\helpers\Url;

$user = \frontend\models\User::findIdentity(Yii::$app->user->getId());

?>
<div class="site51_head_col12_meter">
    <div class="container_fix">
        <div class="logo"><a href="<?= Yii::$app->homeUrl; ?>"><img src="<?= $siteinfo->logo ?>"
                                                                    alt="<?= $siteinfo->title ?>"></a></div>
        <div class="main-menu">
            <div class="menu">
                <ul class="menu_list">
                    <li class="logo_list"><a href="<?= Yii::$app->homeUrl; ?>"><img src="<?= $siteinfo->logo ?>"
                                                                                    alt="<?= $siteinfo->title ?>"></a>
                    </li>
                    <?php //Menu main
                    echo frontend\widgets\menu\MenuWidget::widget([
                        'view' => 'view',
                        'group_id' => 3,
                    ])
                    ?>
                    <?php if ($user): ?>
                        <li class="list account"><a href="<?= Url::to(['/management/profile/index']) ?>">Tài
                                khoản</a></li>
                    <?php else: ?>
                        <li class="list account"><a href="<?= \yii\helpers\Url::to(['/login/login/login']) ?>">Tài
                                khoản</a></li>
                    <?php endif; ?>
                    <li class="list app"><a href="">App Metter</a></li>
                </ul>
            </div>
            <?php //Menu main
            echo frontend\widgets\productSearch\ProductSearchWidget::widget([
                'view' => 'view',
            ])
            ?>
            <div class="link_app"><a href="">App Metter</a></div>
            <div class="login_singin">
                <?php
                if (!Yii::$app->user->id) {
                    ?>
                    <a href="<?= \yii\helpers\Url::to(['/login/login/login']) ?>">Đăng nhập<i
                                class="fas fa-user"></i></a>
                <?php } else {
                    ?>
                    <a href="<?= Url::to(['/management/profile/index']) ?>">Tài khoản<i class="fas fa-user"></i></a>
                <?php } ?>
            </div>
            <div class="icon_menu"><span></span><span></span><span></span></div>
        </div>
    </div>
</div>
