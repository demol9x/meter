<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\NewsCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý liên hệ khách hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-view">

    <h2>Người liên hệ: <?= Html::encode($this->title) ?></h2>
    <p>
        <?= Html::a('Xóa', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Xác nhận xóa?',
                'method' => 'post',
            ],
        ]) ?>

        <?php
        if (!$model->viewed) echo Html::a('Đánh dấu đã xử lý', ['finish', 'id' => $model->id], [
            'class' => 'btn btn-primary',
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'phone',
            'email',
            'address',
            'body',

        ],
    ]) ?>

</div>