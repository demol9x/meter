<?php

use common\models\notifications\Notifications;
use yii\helpers\Url;
?>
<?php if (Yii::$app->user->id) { ?>
    <div class="flex-col flex-right hidden-lg hidden-md hidden-sm notification-mobile-area ">
        <a href="<?= Url::to(['/management/notifications/index']) ?>">
            <i class="fa fa-bell-o" aria-hidden="true"></i>
            <?php if ($countUnread) { ?>
                <span><?= $countUnread ?></span>
            <?php } ?>
        </a>
    </div>
<?php } else { ?>
    <div class="flex-col flex-right hidden-lg hidden-md hidden-sm notification-mobile-area ">
        <a href="<?= Url::to(['/login/login/login']) ?>">
            <i class="fa fa-bell-o" aria-hidden="true"></i>
        </a>
    </div>
<?php } ?>