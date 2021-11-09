<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductPriceFormula */

$this->title = 'Cập nhật quy tắc: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý quy tắc tính giá', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="product-price-formula-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
