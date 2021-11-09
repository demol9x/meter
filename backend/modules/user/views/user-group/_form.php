<?php

use yii\helpers\Html;
use \common\components\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php
            $form = ActiveFormC::begin1([
                'id' => 'user-form',
                'options' => [
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data',
                    'title_form' => $this->title
                ]
            ]);
            ?>

            <?= $form->fieldB($model, 'name')->textInput()->label() ?>

            <?php $option = (new common\models\product\ProductCategory())->optionsCategory(\common\models\product\ProductCategory::CATEGORY_GROUP); ?>

            <?= $form->fieldB($model, 'product_categorys')->dropDownList($option)->label() ?>

            <?php ActiveFormC::end1(['update' => $model->id]); ?>
        </div>
    </div>
</div>