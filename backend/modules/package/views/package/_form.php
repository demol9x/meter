<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\package\Package */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo Yii::$app->homeUrl ?>js/ckeditor/ckeditor.js"></script>
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

    <div class="" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#tab_content1" id="one-tab" role="tab" data-toggle="tab" aria-expanded="true">
                    <?= Yii::t('app', 'basic_info') ?>
                </a>
            </li>
            <li role="presentation">
                <a href="#tab_content2" id="two-tab" role="tab" data-toggle="tab" aria-expanded="true">
                    Ảnh gói thầu
                </a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="one-tab">
                <?= $this->render('partial/basicinfo', ['form' => $form, 'model' => $model]); ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="two-tab">
                <?= $this->render('partial/image', ['form' => $form, 'model' => $model, 'images' => $images]); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
