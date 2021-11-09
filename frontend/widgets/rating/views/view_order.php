<?php

use kartik\rating\StarRating;
use common\models\rating\Rating;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\components\ClaHost;
?>
<div class="box-input-review">
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
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-product">
                <div id="rv-a-img" class="img">
                    <a href="" target="_blank">
                        <img id="rv-img" src="" alt="">
                    </a>
                </div>
                <div class="title">
                    <h2>
                        <a  target="_blank" id="rv-a-name"></a>
                    </h2>
                    <p class="price"  id="rv-price">500.000 đ</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="star-area">
                <span class="number" id="rate-cuonts">0/5</span>
                <div class="star check-rate">
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
            </div>
        </div>
        <div class="col-xs-12 x-h">
            <?=
                $form->field($model_rating, 'content', [
                    'template' => '{input}{error}{hint}'
                ])->textarea([
                    'placeholder' => Yii::t('app', 'content'),
                    'class' =>'check-rate'
                ])->label(false);
            ?>
            <input type="hidden" name="Rating[object_id]" value="0"  id='rv-pid' />
            <input type="hidden" name="Rating[type]" value="<?= $type ?>" />
            <input type="hidden" name="Rating[order_item_id]" value="0" id='rv-id'  />
            <div class="btn-review">
                 <input type="submit" class="btn-style-1  check-rate" value="<?= Yii::t('app', 'send_rate') ?>" />
            </div>
        </div>
        <?php
        ActiveForm::end();
    ?>
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
                    if (response.code == 200) {
                        // alert('<?= Yii::t('app', 'thank_for_rate') ?>');
                        $('.mfp-close').click();
                        var div = $('#item-rate-'+$('#rv-id').val()+'-'+$('#rv-pid').val());
                        div.html('<?= Yii::t('app', 'view_rate') ?>');
                        div.attr('href', '#donhang-review4');
                        div.removeClass('rate-product4');
                        div.addClass('load-review-4 btn-green');
                        // location.reload();
                    }
                }
            });
            return false;
        });
        <?php } else { ?>
        $(document).ready(function() {
            $('.check-rate').click(function() {
                if(confirm('<?= Yii::t('app', 'you_need_login_for_rate') ?>')) {
                    $('#myModal-login').modal();
                }
            });
            return false;
        });
    <?php } ?>
    $('#rating-rating').change(function() {
        $('#rate-cuonts').html($(this).val()+'/5');
    });
</script>
<style type="text/css">
    body .ctn-review-popup .star-area .star {
         width: auto; 
    }
    body .theme-krajee-svg.rating-xs .krajee-icon {
        width: 40px;
        height: 40px;
    }
    .help-block-error {
        font-size: 12px;
    }
    body .btn-style-1 {
        background: #17a349;
        border: none;
        text-align: center;
        width: 100%  !important;
        height: 41px;
        color: #fff;
        font-size: 16px;
        border-radius: 4px;
        font-weight: 500;
    }
    body textarea {
        height: 200px !important;
        padding: 10px;
    }
    .x-h {
        margin-top: -55px;
    }
</style>