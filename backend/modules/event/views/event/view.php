<?php

use common\models\news\News;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\review\CustomerReviews */

$this->title = 'Họ và tên: '.$model->user_name;
$this->params['breadcrumbs'][] = ['label' => 'Khách hàng đăng ký sự kiện', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Họ và tên: '.$this->title;
?>
<div class="customer-reviews-view">

    <h1>Họ và tên: <?= Html::encode($model->user_name) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_name',
            'phone',
            'email',
            'link:url' => [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(__SERVER_NAME.$model->link, __SERVER_NAME.$model->link, ['target' => '_blank']);
                },
                'attribute' => 'link',
            ],
            'note',
            'created_at' => [
                'attribute' => 'created_at',
                'value' => date('d/m/Y', $model->created_at)
            ],
            'updated_at' => [
                'attribute' => 'updated_at',
                'value' => date('d/m/Y', $model->updated_at)
            ],


        ],
    ]) ?>

</div>
