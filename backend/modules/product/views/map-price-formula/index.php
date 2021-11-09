<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\search\MapPriceFormulaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Map Price Formulas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-price-formula-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Map Price Formula', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code_app',
            'name',
            'price_formula',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
