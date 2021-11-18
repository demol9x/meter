<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\user\Tho */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Thos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tho-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->user_id], [
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
            'user_id',
            'tot_nghiep',
            'nghe_nghiep',
            'chuyen_nganh',
            'kinh_nghiem',
            'kinh_nghiem_description:ntext',
            'description:ntext',
            'attachment',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
