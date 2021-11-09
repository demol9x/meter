<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserRecruiterInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Recruiter Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-recruiter-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Recruiter Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'contact_name',
            'phone',
            'scale',
            'address',
            // 'province_id',
            // 'district_id',
            // 'ward_id',
            // 'avatar_path',
            // 'avatar_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
