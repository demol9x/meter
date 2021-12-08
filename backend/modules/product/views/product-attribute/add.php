<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\ProductAttributeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Giá trị lựa chọn cho bộ thuộc tính: '.$data->name;
$this->params['breadcrumbs'][] = ['label' => 'Bộ thuộc tính sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="product-attribute-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Thêm mới', ['create-item','id' => $data->id], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'value',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update}{delete}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-edit"></span>', 'update-item?id=' . $model->id, [
                                            'title' => Yii::t('app', 'Cập nhật'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete-item?id=' . $model->id, [
                                            'title' => Yii::t('app', 'Cập nhật'),
                                        ]);
                                    }
                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
