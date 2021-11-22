<?php

use common\models\news\News;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý sự kiện';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-reviews-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            'user_name',
                            'phone',
                            'email',
                            [
                                'attribute' => 'type',
                                'content' => function ($model) {
                                    return News::getType()[$model->type];
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'type', News::getType(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                            ],
                            // 'review_en',
                            // 'customer_name_en',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}'
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
