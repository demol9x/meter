<?php

use common\models\notifications\Notifications;
use yii\helpers\Url;
$this->title = "Thông báo";
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <i class="fa fa-bell" style="margin-right: 6px;"></i> <?= Yii::t('app', 'my_notification') ?>
        </h2>
    </div>
    <div class="tab-notification">
        <div class="tabs-standard">
            <input id="tab1" type="radio" name="tabs" <?= $type == 0 ? 'checked' : '' ?> />
            <label onclick="location.href = '<?= Url::to(['/management/notifications/index']) ?>'" for="tab1"><?= Yii::t('app', 'general_notification') ?></label>

            <input id="tab2" type="radio" name="tabs" <?= $type == Notifications::PROMOTION ? 'checked' : '' ?> />
            <label onclick="location.href = '<?= Url::to(['/management/notifications/index', 'type' => Notifications::PROMOTION]) ?>'" for="tab2"><?= Yii::t('app', 'sales') ?></label>

            <input id="tab3" type="radio" name="tabs" <?= $type == Notifications::ORDER ? 'checked' : '' ?> />
            <label onclick="location.href = '<?= Url::to(['/management/notifications/index', 'type' => Notifications::ORDER]) ?>'" for="tab3"><?= Yii::t('app', 'orders') ?></label>

            <input id="tab4" type="radio" name="tabs" <?= $type == Notifications::UPDATE_SYSTEM ? 'checked' : '' ?> />
            <label onclick="location.href = '<?= Url::to(['/management/notifications/index', 'type' => Notifications::UPDATE_SYSTEM]) ?>'" for="tab4"><?= Yii::t('app', 'update') ?></label>
            <?php if (isset($data) && $data) { ?>
                <section style="display: block" class="format-text">
                    <?php foreach ($data as $item) { ?>
                        <div class="item <?= $item['unread'] ? 'unread' : '' ?>">
                            <div class="account-notify-date"><?= date('d/m/Y', $item['created_at']) ?></div>
                            <div class="account-notify-content">
                                <div class="img">
                                    <img src="<?= Notifications::getImageNotification($item['type']) ?>">
                                </div>
                                <p>
                                    <b><?= $item['title'] ?> </b><br/>
                                    <?= $item['description'] ?> 
                                    <a target="_blank" href="<?= $item['link'] ?>"><?= Yii::t('app', 'detail') ?></a>
                                </p>
                                <?php if ($item['unread']) { ?>
                                    <button onclick="markerReadNotify(<?= $item['id'] ?>, this)" class="account-unread-notify-status-icon">
                                        <?= Yii::t('app', 'ckeck_viewed') ?>
                                    </button>
                                <?php } ?>
                                <button onclick="deleteNotify(<?= $item['id'] ?>, this)" class="account-delete-notify-status-icon">
                                    <?= Yii::t('app', 'delete') ?>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </section>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function markerReadNotify(notify_id, _this) {
        $.getJSON(
                "<?= \yii\helpers\Url::to(['/management/notifications/marker-read-notify']) ?>",
                {notify_id: notify_id}
        ).done(function (data) {
            $(_this).closest('.item').removeClass('unread');
            $(_this).remove();
        }).fail(function (jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            console.log("Request Failed: " + err);
        });
    }

    function deleteNotify(notify_id, _this) {
        if (confirm('<?= Yii::t('app', 'delete_sure') ?>')) {
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/management/notifications/delete-notify']) ?>",
                    {notify_id: notify_id}
            ).done(function (data) {
                $(_this).closest('.item').remove();
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        }
    }
</script>