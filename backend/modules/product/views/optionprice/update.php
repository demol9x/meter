<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OptionPrice */

$this->title = 'Cập nhật khoảng giá: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Khoảng giá', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="option-price-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
