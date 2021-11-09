<?php 
	$url = $url ? 'https://'.$url : 'https://'.\common\components\ClaSite::getServerName()."$_SERVER[REQUEST_URI]";
?>
<p>
    <?= Yii::t('app', 'share_to_friend') ?>
</p>
<div class="right-social-box">
    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $url ?>" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
    <a target="_blank" href="https://plus.google.com/share?url=<?= $url ?>" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
    <a target="_blank" href="https://twitter.com/share?url=<?= $url ?>" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
    <a target="_blank" href="https://pinterest.com/pin/create/bookmarklet/?url=<?= $url ?>" class="pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
</div>