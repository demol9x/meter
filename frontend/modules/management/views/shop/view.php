<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-view">

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
            'alias',
            'type',
            'user_id',
            'address',
            'province_id',
            'province_name',
            'district_id',
            'district_name',
            'ward_id',
            'ward_name',
            'image_path',
            'image_name',
            'avatar_path',
            'avatar_name',
            'phone',
            'hotline',
            'email:email',
            'yahoo',
            'skype',
            'website',
            'facebook',
            'instagram',
            'pinterest',
            'twitter',
            'field_business',
            'status',
            'created_time:datetime',
            'modified_time:datetime',
            'site_id',
            'allow_number_cat',
            'short_description',
            'description:ntext',
            'meta_keywords',
            'meta_description',
            'meta_title',
            'avatar_id',
            'time_open:datetime',
            'time_close:datetime',
            'day_open',
            'day_close',
            'type_sell',
            'like',
            'policy:ntext',
            'contact:ntext',
            'latlng',
            'payment_transfer:ntext',
            'category_track',
            'level',
            'number_auth',
            'date_auth',
            'address_auth',
            'number_paper_auth',
        ],
    ]) ?>

</div>
