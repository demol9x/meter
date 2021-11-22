<?php

use yii\helpers\Html;


$this->title = 'Cập nhật hình thức: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý hình thức', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="product-category-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
