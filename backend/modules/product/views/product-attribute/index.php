<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\ProductAttributeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bộ thuộc tính sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-attribute-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Thêm mới', ['create'], ['class' => 'btn btn-success pull-right']) ?>
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
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{edit_docter}{update}{delete}',
                                'buttons' => [
                                    'edit_docter' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', 'add?id=' . $model->id, [
                                            'title' => Yii::t('app', 'Thêm giá trị'),
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
