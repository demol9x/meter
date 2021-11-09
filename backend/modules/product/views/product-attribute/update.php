<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductAttribute */

$this->title = 'Cập nhật thuộc tính: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thuộc tính', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="product-attribute-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
