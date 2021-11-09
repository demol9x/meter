<?php

use yii\helpers\Url;
use common\components\ClaHost;
$imgs = ($rate['avatar_name']) ? ClaHost::getImageHost().$rate['avatar_path'].$rate['avatar_name'] : ClaHost::getImageHost().'/imgs/user_default.png';
?>
<div class="item-review-customer">
    <div class="img-item-review-customer">
        <a>
            <img src="<?= $imgs ?>" class="attachment-full">
        </a>
    </div>
    <div class="title-item-review-customer">
        <h2>
            <?= $rate['username'] ?>
            <span class="mr-review">|</span>
            <?php for ($i=1; $i <6 ; $i++) { ?>
                <span class="fa fa-star<?= ($rate['rating'] >= $i) ? '' : '-o' ?>"></span>
            <?php } ?>
            <em><?= date('d/m/Y',$rate['created_at']) ?></em>
        </h2>
        <p><?= $rate['content'] ?></p>
        <div id="box-response-<?= $rate['id'] ?>" class="box-response">
            <?php if(isset($responses) && $responses) {
                foreach ($responses as $response) {?>
                    <p><b><?= $response['user_response_name'] ?></b> <?= Yii::t('app', 'response') ?>:
                        <p><?= $response['response'] ?></p>
                    </p>
                <?php }
            } ?>
        </div>
        <div class="btn-answer" onclick="openanswer(<?= $rate['id'] ?>)">
            <a href="javascript:void(0);"><?= Yii::t('app','answer') ?>  <i class="fa fa-reply" aria-hidden="true"></i></a>
        </div>
        <div class="box-answer box-answer-<?= $rate['id'] ?>">
            <textarea name="" id="message-<?= $rate['id'] ?>" cols="30" rows="10"></textarea>
            <button onclick="responcerate(<?= $rate['id'] ?>, '<?= Url::to(['/rating/response']) ?>');"><?= Yii::t('app','answer') ?> </button>
        </div>
    </div>
</div>