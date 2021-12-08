<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OptionPriceSE */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Khoảng giá';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-price-index">
<style>
    .help-block {
        display: none;
    }
</style>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Thêm khoảng giá', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'price_min',
            'price_max',
            'created_at' => [
                'header' => 'Ngày tạo',
                'content' => function($model) {
                    return date('d/m/Y H:i:s', $model->created_at);
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
