<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductCalculationFormula */

$this->title = 'Update Product Calculation Formula: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Công thức tính', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-calculation-formula-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
