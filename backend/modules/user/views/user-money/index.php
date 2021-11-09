<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\user\search\UserMoneySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý tiền Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-money-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Thêm tiền vào số điện thoại', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            // 'id',
                            'phone',
                            [
                                'attribute' => 'money',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return '<b>' . number_format($model->money, 0, ',', '.') . '</b>';
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function($model) {
                                    return date('H:i d-m-Y', $model->created_at);
                                }
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => function($model) {
                                    return date('H:i d-m-Y', $model->updated_at);
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update}'
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
