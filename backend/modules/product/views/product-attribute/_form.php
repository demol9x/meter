<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductAttribute */
/* @var $form yii\widgets\ActiveForm */
?>



<?php $form = ActiveForm::begin(); ?>

<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#tab_content1" id="one-tab" role="tab" data-toggle="tab" aria-expanded="true">
                Thông tin cơ bản
            </a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="one-tab">
            <?= $this->render('partial/basicinfo', ['form' => $form, 'model' => $model]); ?>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

