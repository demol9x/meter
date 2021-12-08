<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/26/2021
 * Time: 7:46 PM
 */

use kartik\rating\StarRating;
use common\models\rating\Rating;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<?php
$model_rating = new Rating();
$model_rating->object_id = $object_id;
$model_rating->type = $type;
$form = ActiveForm::begin([
    'id' => 'rating-form',
    'action' => Url::to(['/rating/rating']),
    'options' => [
        'class' => 'form-popup-inshop'
    ]
]);
?>
<?=
$form->field($model_rating, 'content', [
    'template' => '{input}{error}{hint}'
])->textarea([
    'placeholder' => Yii::t('app', 'content'),
    'class' => 'check-rate form-control'
])->label(false);
?>
<input type="hidden" name="Rating[object_id]" value="<?= $object_id ?>"/>
<input type="hidden" name="Rating[type]" value="<?= $type ?>"/>
<div class="star check-rate">
    <spam><?= Yii::t('app', 'ranking') ?>:</spam>
    <?php
    echo $form->field($model_rating, 'rating')->widget(StarRating::classname(), [
        'pluginOptions' => [
            'disabled' => false,
            'displayOnly' => false,
            'showClear' => false,
            'step' => 1,
            'size' => 'xs',
            'theme' => 'krajee-svg',
            'filledStar' => '<span class="krajee-icon krajee-icon-star"></span>',
            'emptyStar' => '<span class="krajee-icon krajee-icon-star"></span>',
            'starCaptions' => [
                0 => Yii::t('app', 'rate_0'),
                1 => Yii::t('app', 'rate_1'),
                2 => Yii::t('app', 'rate_2'),
                3 => Yii::t('app', 'rate_3'),
                4 => Yii::t('app', 'rate_4'),
                5 => Yii::t('app', 'rate_5'),
            ],
            'showCaption' => false,
        ],
    ])->label(false);
    ?>
</div>
<?= $this->render('image', ['form' => $form, 'model' => $model_rating]); ?>
<div class="btn-review">
    <input type="submit" class="btn-style-1  check-rate" value="<?= Yii::t('app', 'send_rate') ?>"/>
</div>
<?php
ActiveForm::end();
?>
