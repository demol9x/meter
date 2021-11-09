<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\search\ProductPriceFormulaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý quy tắc tính giá';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-price-formula-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Tạo quy tắc', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'code_app',
                            'name',
                            'formula_product',
                            'formula_gold',
                            'formula_fee',
                            'formula_stone',
                            // 'status',
                            // 'description:ntext',
                            // 'coefficient1',
                            // 'coefficient2',
                            // 'coefficient3',
                            // 'coefficient4',
                            // 'coefficient5',
                            // 'coefficient6',
                            // 'coefficient7',
                            // 'coefficient8',
                            // 'coefficient9',
                            // 'coefficientm',
                            // 'coefficientx',
                            // 'created_at',
                            // 'updated_at',
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
