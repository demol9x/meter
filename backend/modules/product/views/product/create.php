<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\Product */

$this->title = 'Tạo sản phẩm';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
        'attributes_changeprice' => $attributes_changeprice,
        'shop_transports' => $shop_transports,
        'product_transports' => $product_transports,
    ]) ?>

</div>
