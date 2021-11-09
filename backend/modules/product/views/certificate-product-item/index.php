<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\CertificateProductItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Certificate Product Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-product-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Certificate Product Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'certificate_product_id',
            'avatar_name',
            'avatar_path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
