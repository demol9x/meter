<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\search\ProductCalculationFormulaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Công thức tính giá theo khối lượng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-calculation-formula-index">

    <?php
    $siteinfo = \common\components\ClaLid::getSiteinfo();
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tạo thêm công thức tính giá', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'description',
            'percent',
            'const_price',
            [
                'attribute' => 'brand',
                'header' => 'Giá vàng 9999',
                'value' => function($model) use ($siteinfo) {
                    return $siteinfo->gold_price;
                }
            ],
            // 'status',
             'price',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
