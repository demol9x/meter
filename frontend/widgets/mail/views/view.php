<?php
$siteinfo = \common\components\ClaLid::getSiteinfo();
?>
<div class="wapper-emal" style="float: left;max-width: 690px; margin: 0 auto;font: small/1.5 Arial,Helvetica,sans-serif;">
    <!-- <div style="float: left; width: 100%;">
        <img src="<?= __SERVER_NAME ?>/images/header-mail.jpg" alt="" style="width: 100%;">
    </div> -->
    <p>
        <b><?= $title ?></b>
    </p>
    <?= $content ?>
    <br><b><i>Trân trọng cảm ơn.</i></b>

    <div style="float: left; width: 100%;">
        <img src="<?= __SERVER_NAME ?>/images/footer-mail.jpg" alt="" style="width: 100%;">
    </div>
</div>