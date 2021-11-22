<?php

use common\models\shop\BlockCheck;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\shop\Shop;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blockcheck';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Thêm mới', ['create'], ['class' => 'btn btn-success pull-right']) ?>
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
                                'shop_name',
                                'created_time' => [
                                    'attribute' => 'created_time',
                                    'value' => function ($model) {
                                        return date('H:i d-m-Y', $model->created_time);
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'content' => function ($model) {
                                        switch ($model->status) {
                                            case 1:
                                                return '<span class="active">Đã kích hoạt</span>';
                                                break;
                                            case 0:
                                                return '<span class="blocked_active">Chưa kích hoạt</span>';
                                                break;
                                            default:
                                                return '<span class="non_active">Chờ kích hoạt</span>';
                                                break;
                                        }
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', [2 => 'Chờ kích hoạt', 1 => 'Đã kích hoạt', 0 => 'Chưa kích hoạt'], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}{delete}'
                                ],
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>