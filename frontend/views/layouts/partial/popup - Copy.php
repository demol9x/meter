<?php
    $cookie_name = 'show_popup_gca';
    if(!isset($_COOKIE[$cookie_name])) {
        setcookie($cookie_name, time(), time() + (86400 * 1), "/");
        echo \frontend\widgets\banner\BannerWidget::widget([
            'view' => 'popup',
            'group_id' => 6,
            'limit' => 3
        ]);
    }
?>