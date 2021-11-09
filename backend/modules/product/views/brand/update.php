<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\Brand */

$this->title = 'Cập nhật thương hiệu: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thương hiệu', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="brand-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
