<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\Product */

$this->title = 'Cập nhật sản phẩm: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="product-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
        'attributes_changeprice' => $attributes_changeprice,
        'certificates' => $certificates,
        'certificate_items' => $certificate_items,
        'shop_transports' => $shop_transports,
        'product_transports' => $product_transports,
    ]) ?>

</div>
