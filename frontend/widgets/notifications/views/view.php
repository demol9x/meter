<?php

use common\models\notifications\Notifications;
use yii\helpers\Url;
?>
<style type="text/css">
    .box-noti-in {
        position: relative;
    }
    .box-noti-in .view_more {
        position: absolute;
        z-index: 999999;
        bottom: 29px;
        display: block;
        height: 41px;
        background: #fff;
        left: 0px;
        margin: 0px 2px !important;
        color: green !important;
        text-align: center;
        font-size: 15px !important;
        font-weight: bold;
        padding: 10px;
    }
</style>
<?php if (Yii::$app->user->id) { ?>
    <div class="notification-area">
        <a href="" onclick="ShowNotify();return false;">
            <i class="fa fa-bell-o" aria-hidden="true"></i>
            <?php if ($countUnread) { ?>
                <span><?= $countUnread ?></span>
            <?php } ?>
        </a>
        <div class="box-noti">
            <div class="box-noti-in">
                <ul class="list-noti">
                    <?php
                    foreach ($data as $item) {
                        ?>
                        <li>
                            <a onclick="markerReadNotify(<?= $item['id'] ?>, this)" href="javascript:void(0)" data-href="<?= $item['link'] ?>" class="<?= $item['unread'] ? 'unread' : '' ?>">
                                <div class="flex">
                                    <span class="img">
                                        <img alt="img-notification" src="<?= Notifications::getImageNotification($item['type']) ?>" />
                                    </span>
                                    <div class="flex-col-right">
                                        <span class="text" style="font-weight: bold;"><?= $item['title'] ?></span>
                                        <span class="text"><?= $item['description'] ?></span>
                                        <span class="detail"><?= Yii::t('app', 'detail') ?></span>
                                        <br>
                                        <span class="date"><?= date('d/m/Y', $item['created_at']) ?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <a href="<?= Url::to(['/management/notifications/index']) ?>" title="<?= Yii::t('app', 'view_all_notification') ?>" class="view_more"><?= Yii::t('app', 'view_all_notification') ?></a>
            </div>
        </div>
    </div>
    <script>
        function markerReadNotify(notify_id, _this) {
            var url = $(_this).attr('data-href');
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/management/notifications/marker-read-notify']) ?>",
                    {notify_id: notify_id}
            ).done(function (data) {
                location.href = url;
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        }


        $(document).click(function (e) {
            if (!$(e.target).hasClass(".notification-area")
                    && $(e.target).parents(".notification-area").length === 0)
            {
                $(".notification-area .box-noti").hide();
            }
        });
        $(document).ready(function () {
            $('.list-icon-cate li').eq(0).addClass('active');
        });
        function ShowNotify() {
            $('.notification-area .box-noti').toggle(500);
        }
        $('.notification-area .box-noti').click(function (event) {
            event.stopPropagation();
        });
        $(".inmobile-sidebar-right").click(function () {
            $(this).removeClass('active');
        });
        $(".inmobile-sidebar-right .box-noti, .box-notification-mobile").click(function (event) {
            $('.inmobile-sidebar-right').addClass('active');
            event.preventDefault();
            event.stopPropagation();
        });
    </script>
<?php } else { ?>
    <div class="notification-area">
        <a href="#login-box-popup" class="open-popup-link">
            <i class="fa fa-bell-o" aria-hidden="true"></i>
        </a>
    </div>
<?php } ?>