<?php

use yii\helpers\Html;


$this->title = 'Cập nhật dự án: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý dự án', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="product-category-update">

    <?= Html::encode($this->title) ?>

    <?= $this->render('_form_update', [
        'model' => $model,
        'provinces' => $provinces,
        'districts' => $districts,
        'wards' => $wards,
    ]) ?>

</div>
