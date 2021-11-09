<div class="site51_head_col12_meter">
    <div class="container_fix">
        <div class="logo"><a href="<?= Yii::$app->homeUrl;?>"><img src="<?= $siteinfo->logo ?>" alt="<?=$siteinfo->title?>"></a></div>
        <div class="menu">
            <ul class="menu_list">
                <li class="logo_list"><a href="<?= Yii::$app->homeUrl;?>"><img src="<?= $siteinfo->logo ?>" alt="<?=$siteinfo->title?>"></a></li>
                <?php //Menu main
                echo frontend\widgets\menu\MenuWidget::widget([
                    'view' => 'view',
                    'group_id' => 3,
                ])
                ?>
                <li class="list account"><a href="dangnhap.php">Tài khoản</a></li>
                <li class="list app"><a href="">App Metter</a></li>
            </ul>
        </div>
        <div class="search">
            <img class="search_icon" src="<?= Yii::$app->homeUrl ?>images/search.png" alt="" >
            <div class="toggle_search">
                <form action="">
                    <input type="text" placeholder="Tìm kiếm">
                    <button><img src="<?= Yii::$app->homeUrl ?>images/search.png" alt="" ></button>
                </form>
            </div>
        </div>

        <div class="link_app"><a href="">App Metter</a></div>
        <div class="login_singin">
            <a href="dangnhap.php">Tài khoản<i class="fas fa-user"></i></a>
        </div>
        <div class="icon_menu"><span></span><span></span><span></span></div>
    </div>
</div>