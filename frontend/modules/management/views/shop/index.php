<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\shop\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shops';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shop', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'alias',
            'type',
            'user_id',
            // 'address',
            // 'province_id',
            // 'province_name',
            // 'district_id',
            // 'district_name',
            // 'ward_id',
            // 'ward_name',
            // 'image_path',
            // 'image_name',
            // 'avatar_path',
            // 'avatar_name',
            // 'phone',
            // 'hotline',
            // 'email:email',
            // 'yahoo',
            // 'skype',
            // 'website',
            // 'facebook',
            // 'instagram',
            // 'pinterest',
            // 'twitter',
            // 'field_business',
            // 'status',
            // 'created_time:datetime',
            // 'modified_time:datetime',
            // 'site_id',
            // 'allow_number_cat',
            // 'short_description',
            // 'description:ntext',
            // 'meta_keywords',
            // 'meta_description',
            // 'meta_title',
            // 'avatar_id',
            // 'time_open:datetime',
            // 'time_close:datetime',
            // 'day_open',
            // 'day_close',
            // 'type_sell',
            // 'like',
            // 'policy:ntext',
            // 'contact:ntext',
            // 'latlng',
            // 'payment_transfer:ntext',
            // 'category_track',
            // 'level',
            // 'number_auth',
            // 'date_auth',
            // 'address_auth',
            // 'number_paper_auth',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
