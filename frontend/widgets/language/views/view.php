<?php

use yii\helpers\Url;
$lg = common\components\ClaLid::getCurrentLanguage();
?>
<div class="languages">
    <?php foreach (Yii::$app->params['languages'] as $key => $language) { ?>
    <a href="javascript:void(0)" class="change-language flag flag-<?= $key ?> <?= $current == $key ? 'active' : '' ?>" id="<?= $key ?>">
        <img src="<?= Yii::$app->homeUrl ?>images/<?= $language ?>" />
    </a>
    <?php } ?>
</div>

<script type="text/javascript">
    $(document).on('click', '.change-language', function () {
        var lang = $(this).attr('id');
        $.post(
                '<?= Url::to(['/site/language']) ?>',
                {lang: lang},
                function (data) {
                    location.reload();
                }
        );
    });
</script>
