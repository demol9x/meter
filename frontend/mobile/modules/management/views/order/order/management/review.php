<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
use common\models\rating\RateResponse;
?>
<?php if($rates) foreach ($rates as $rate) { 
    $responses = RateResponse::getByRating($rate['id']);
    echo frontend\widgets\html\HtmlWidget::widget([
        'input' => [
            'rate' => $rate,
            'responses' => $responses,
        ],
        'view' => 'view_rate_1'
    ]);
} else { ?>
<p style="padding: 20px;"><?= Yii::t('app', 'havent_rate_for_product') ?> </p>
<?php } ?>
