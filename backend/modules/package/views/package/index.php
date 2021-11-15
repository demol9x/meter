<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\package\PackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dánh sách gói thầu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a(Yii::t('app', 'create'), ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <?= Html::a('Xuất exel', ['exel'], ['class' => 'btn btn-success pull-right']) ?>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            [
                                'attribute' => 'shop_id',
                                'value' => 'user.username'
                            ],
                            'address',
                            'order',
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return \common\models\package\Package::getStatus()[$model->status];
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'status', \common\models\package\Package::getStatus(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function ($model) {
                                    return date('d-m-Y', $model->created_at);
                                }
                            ],
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
