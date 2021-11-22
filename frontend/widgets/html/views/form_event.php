<?php

use yii\helpers\Url;
use common\models\ActiveFormC;
use yii\helpers\Html;

?>
<div id="form-event">
    <?php $model = new \common\models\form\FormEvent(); ?>
    <div class="box-account">
        <div class="title-popup">
            <h2>Đăng ký sự kiện</h2>
        </div>
        <div class="ctn-review-popup">
            <?php $form = ActiveFormC::begin([
                'action' => Url::to(['/form/save-event']),
                'options' => [
                    'id' => 'save-event',
                    'class' => 'save-event',
                    'enctype' => 'multipart/form-data'
                ]
            ]); ?>
            <?= $form->field($model, 'link')->textInput(['type' => 'hidden', 'value' => ((isset($link)) ? $link : '')])->label(false) ?>
            <?= $form->field($model, 'news_id')->textInput(['type' => 'hidden', 'value' => ((isset($news_id)) ? $news_id : '')])->label(false) ?>
            <?= $form->field($model, 'type')->textInput(['type' => 'hidden', 'value' => ((isset($type)) ? $type : '')])->label(false) ?>
            <?= $form->fields($model, 'user_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('user_name')]) ?>
            <?= $form->fields($model, 'phone')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone')]) ?>
            <?= $form->fields($model, 'email')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('email')]) ?>

<!--            --><?php //if (isset($type) && $type==3) { ?>
<!--                <div class="form-group field-formevent-src">
                    <div class="item-input-form">
                        <?/*= Html::activeLabel($model, 'src', ['class' => 'required item-input-form']) */?>
                        <div class="group-input">
                            <div class="full-input">
                                <?/*= Html::activeHiddenInput($model, 'src') */?>
                                <?/*= Html::fileInput('src'); */?>
                                <?/*= Html::error($model, 'src', ['class' => 'help-block']); */?>
                            </div>
                        </div>
                    </div>
                </div>-->

            <?= $form->fields($model, 'note')->textArea(['maxlength' => true, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('note')]) ?>
            <button id="btn">Đăng ký</button>
            <?php ActiveFormC::end(); ?>
        </div>
    </div>
</div>
<script>
/*    $('#btn-rgs-buy').click(function () {
        var src = $('input[type=file]').val();
        if (!src) {
            alert('Bạn phải tải lên hồ sơ của mình');
            return false;
        }
    })*/
    $(document).on('submit', '#save-event', function() {
        $('body').append('<div id="fixed-loading-img" class="box-fixed"><div class="flex"><div class="child-flex"><img class="ajax-loader-img" src="' + baseUrl + 'images/ajax-loader.gif" /></div></div></div>');
        _this = $(this);
        $.ajax({
            url: _this.attr('action'),
            data: _this.serialize(),
            type: 'POST',
            success: function(result) {
                $('#fixed-loading-img').remove();
                if (result == 'success') {
                    location.href = '';
                    return false;
                } else {
                    $('#error-sell').html(result);
                }
            }
        });
        return false;
    });
</script>
<style>
    #form-event .bg-pop-white:after {
        content: none;
    }

    #form-event {
        float: left;
        width: 100%;
        box-shadow: 1px 3px 8px 0px #3333335e;
        margin-bottom: 30px;
    }

    #form-event .ctn-review-popup {
        padding-top: 15px;
    }
</style>