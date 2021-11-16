<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\user\ThoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách thợ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tho-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'tot_nghiep',
            'nghe_nghiep',
            'chuyen_nganh',
            'kinh_nghiem',
            // 'kinh_nghiem_description:ntext',
            // 'description:ntext',
            // 'attachment',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
