<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductCurrency */

$this->title = 'Cập nhật đơn vị tiền tệ: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý tiền tệ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="product-currency-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
