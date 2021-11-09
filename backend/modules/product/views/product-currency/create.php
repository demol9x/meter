<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\ProductCurrency */

$this->title = 'Tạo đơn vị tiền tệ';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý tiền tệ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-currency-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
