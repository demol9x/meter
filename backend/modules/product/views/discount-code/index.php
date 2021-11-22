<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\search\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý mã giảm giá';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Tạo mã giảm giá', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            [
                                'attribute' => 'shop_id',
                                'content' => function ($model) {
                                    return $model->show('shop_id');
                                }
                            ],
                            [
                                'attribute' => 'type_discount',
                                'content' => function ($model) {
                                    return $model->show('type_discount');
                                }
                            ],
                            [
                                'attribute' => 'value',
                                'content' => function ($model) {
                                    return $model->show('value');
                                }
                            ],
                            [
                                'attribute' => 'time_start',
                                'content' => function ($model) {
                                    return $model->show('time_start');
                                }
                            ],
                            [
                                'attribute' => 'time_end',
                                'content' => function ($model) {
                                    $text = $model->show('time_end');
                                    if (time() <= $model->time_end) {
                                        $text = '<span class="red">Đã hết hạn - '.date("d/m/Y H:i", $model->time_end).'</span>';
                                    }
                                    if ($model->count >=$model->count_limit) {
                                        $text = '<span class="red">Đã hết số lượng</span>';
                                    }
                                    return $text;
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'header' => 'Đã sử dụng',
                                'content' => function ($model) {
                                    $text = $model->count . '/' . $model->count_limit ;
                                    return $text;
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{delete}'
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>