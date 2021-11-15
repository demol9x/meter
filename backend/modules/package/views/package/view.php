<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\package\Package */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'name',
            'shop_id',
            'alias',
            'status',
            'avatar_path',
            'avatar_name',
            'avatar_id',
            'isnew',
            'ishot',
            'address',
            'ward_id',
            'ward_name',
            'district_id',
            'district_name',
            'province_id',
            'province_name',
            'latlng',
            'viewed',
            'short_description:ntext',
            'description:ntext',
            'ho_so',
            'ckedit_desc',
            'order',
            'lat',
            'long',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
