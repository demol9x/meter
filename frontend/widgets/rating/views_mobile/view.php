<?php

use kartik\rating\StarRating;
use common\models\rating\Rating;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\components\ClaHost;
?>
<?php
$dataRatings = [];
if (isset($ratings) && $ratings) {
    foreach ($ratings as $rat) {
        if (isset($dataRatings[$rat['rating']])) {
            $dataRatings[$rat['rating']] ++;
        } else {
            $dataRatings[$rat['rating']] = 1;
        }
    }
}
?>

<div class="white-full" id="review">
    <h2 class="title-full"><?= Yii::t('app','rating_product') ?></h2>
    <div class="review-product-box">
        <?php if (isset($ratings) && $ratings) { ?>
            <div class="comment-box-user">
                <?php foreach ($ratings as $rt) { ?>
                    <div class="item-review-product">
                        <div class="title-review">
                            <h2><?= $rt['name'] ?></h2>
                            <?=
                            StarRating::widget([
                                'name' => 'rating',
                                'value' => $rt['rating'],
                                'pluginOptions' => [
                                    'theme' => 'krajee-svg',
                                    'disabled' => false,
                                    'showClear' => false,
                                    'size' => 'xs',
                                    'displayOnly' => true,
                                    'step' => 1,
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
                            ]);
                            ?>
                        </div>
                        <p>
                             <?= \common\models\FilterChar::filterChars($rt['content']) ?>
                        </p>
                    </div>
                <?php } ?>
               <!--  <div class="paginate">
                    <ul class="pagination" id="yw0">
                        <li class="previous hidden"><a href="#">«</a></li>
                        <li class="page active"><a href="#">1</a></li>
                        <li class="page"><a href="#">2</a></li>
                        <li class="page"><a href="#">3</a></li>
                    </ul>                
                </div> -->
            </div>
        <?php } ?>
        <div class="box-input-review">
            <p><b><?= Yii::t('app','rate_coment_1') ?></b></p>
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
                        'class' =>'check-rate'
                    ])->label(false);
                ?>
                <input type="hidden" name="Rating[object_id]" value="<?= $data['id'] ?>" />
                <input type="hidden" name="Rating[type]" value="<?= Rating::RATING_PRODUCT ?>" />
                <div class="star check-rate">
                    <spam f><?= Yii::t('app','ranking') ?>:</spam>
                    <?php
                        echo $form->field($model_rating, 'rating')->widget(StarRating::classname(), [
                            'pluginOptions' => [
                               // 'theme' => 'krajee-fa',
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
                <div class="btn-review">
                        <input type="submit" class="btn-style-1  check-rate" value="<?= Yii::t('app', 'send_rate') ?>" />
                        <!-- <a data-toggle="modal" data-target="#myModal-login" class="btn-style-1" href="javascript:void(0);"><?= Yii::t('app', 'send_rate') ?></a> -->
                </div>
                <?php
                ActiveForm::end();
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    <?php if(Yii::$app->user->id) { ?>
        $('body').on('beforeSubmit', 'form#rating-form', function () {
            var form = $(this);
            // return false if form still have some validation errors
            if (form.find('.has-error').length) {
                return false;
            }
            // submit form
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function (response) {
                    console.log(response);
                    console.log(12345);
                    if (response.code == 200) {
                        alert('<?= Yii::t('app', 'thank_for_rate') ?>');
                        location.reload();
                    }
                }
            });
            return false;
        });
        <?php } else { ?>
        $(document).ready(function() {
            $('.check-rate').click(function() {
                if(confirm('<?= Yii::t('app', 'you_need_login_for_rate') ?>')) {
                    $('.open-popup-link').click();
                }
            });
            return false;
        });
    <?php } ?>
</script>
