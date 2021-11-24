<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\package\Package */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo Yii::$app->homeUrl ?>js/ckeditor/ckeditor.js"></script>
<style>
    .hidden {
        display: none !important;
    }
    .col-md-55{
        position: relative;
        min-height: 1px;
        float: left;
        padding-right: 10px;
        padding-left: 10px;
    }
    .thumbnail .caption {
        padding: 9px;
        color: #333;
    }
    .thumbnail .image {
        height: 120px;
        overflow: hidden;
    }
    .radio, .checkbox {
        position: relative;
        display: block;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .view-first .mask {
        opacity: 0;
        background-color: rgba(0,0,0,0.5);
        transition: all 0.4s ease-in-out;
    }
    .view .mask, .view .content {
        position: absolute;
        width: 100%;
        overflow: hidden;
        top: 0;
        left: 0;
    }
    .view-first .tools {
        transform: translateY(-100px);
        opacity: 0;
        transition: all 0.2s ease-in-out;
    }
    .view .tools {
        text-transform: uppercase;
        color: #fff;
        text-align: center;
        position: relative;
        font-size: 17px;
        padding: 3px;
        background: rgba(0,0,0,0.35);
        margin: 43px 0 0 0;
    }
    .thumbnail {
        margin-bottom: 0px;
    }
    .thumbnail {
        height: 190px;
        overflow: hidden;
    }
    .thumbnail {
        display: block;
        padding: 4px;
        margin-bottom: 20px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
        transition: border .2s ease-in-out;
    }
    .package-form{
        padding: 15px;
    }
    .form-group {
        margin-bottom: 10px;
    }
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .form-group.required label:after {
        content: '(*)';
        color: red;
        margin-left: 5px;
    }
    .form-control {
        border-radius: 0;
        width: 100%;
    }
    .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
</style>
<script>
    <?php if($model->ckedit_desc) { ?>
    jQuery(document).ready(function () {
        CKEDITOR.replace("package-short_description", {
            height: 400,
            language: '<?php echo Yii::$app->language ?>'
        });
        CKEDITOR.replace("package-description", {
            height: 400,
            language: '<?php echo Yii::$app->language ?>'
        });
    });
    <?php } ?>
    jQuery(document).ready(function () {
        $('#package-ckedit_desc').on("click", function () {
            if (this.checked) {
                CKEDITOR.replace("package-short_description", {
                    height: 400,
                    language: '<?php echo Yii::$app->language ?>'
                });
                CKEDITOR.replace("package-description", {
                    height: 400,
                    language: '<?php echo Yii::$app->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['package-short_description'];
                if (a) {
                    a.destroy(true);
                }

                var b = CKEDITOR.instances['package-description'];
                if (b) {
                    b.destroy(true);
                }

            }
        });
    });
</script>

<div class="package-form">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>
    <?= $this->render('partial/basicinfo', ['form' => $form, 'model' => $model]); ?>

    <?= $this->render('partial/image', ['form' => $form, 'model' => $model, 'images' => $images]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
