<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\product\ProductAttributeSet;
use common\components\ClaLid;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\search\ProductAttributeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý thuộc tính';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-attribute-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Tạo thuộc tính', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            'code',
                            [
                                'attribute' => 'attribute_set_id',
                                'value' => 'attributeSet.name',
                                'filter' => Html::activeDropDownList($searchModel, 'attribute_set_id', array_column(ProductAttributeSet::find()->asArray()->all(), 'name', 'id'), ['class' => 'form-control', 'prompt' => '------'])
                            ],
                            'frontend_input',
                            // 'type_option',
                            'sort_order',
                            // 'default_value',
                            [
                                'attribute' => 'is_configurable',
                                'value' => function($data) {
                                    return $data->is_configurable ? 'Có' : 'Không';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'is_configurable', ClaLid ::optionsYesNo(), ['class' => 'form-control', 'prompt' => '------'])
                            ],
                            [
                                'attribute' => 'is_filterable',
                                'value' => function($data) {
                                    return $data->is_filterable ? 'Có' : 'Không';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'is_filterable', ClaLid ::optionsYesNo(), ['class' => 'form-control', 'prompt' => '------'])
                            ],
                            [
                                'attribute' => 'is_system',
                                'value' => function($data) {
                                    return $data->is_system ? 'Có' : 'Không';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'is_system', ClaLid ::optionsYesNo(), ['class' => 'form-control', 'prompt' => '------'])
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}'
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
