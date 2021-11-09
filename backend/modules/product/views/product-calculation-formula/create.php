<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\ProductCalculationFormula */

$this->title = 'Create Product Calculation Formula';
$this->params['breadcrumbs'][] = ['label' => 'Công thức tính: ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-calculation-formula-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
