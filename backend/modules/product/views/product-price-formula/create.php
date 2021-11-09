<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\ProductPriceFormula */

$this->title = 'Tạo quy tắc';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý quy tắc tính giá', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-price-formula-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
