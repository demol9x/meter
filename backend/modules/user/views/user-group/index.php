<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\shop\Shop;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhóm người dùng';
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
                                'name',
                                'created_at' => [
                                    'attribute' => 'created_at',
                                    'value' => function ($model) {
                                        return date('H:i d-m-Y', $model->created_at);
                                    },
                                    'filter' => Html::input('text', 'UserSearch[created_at]', isset($_GET['UserSearch']['created_at']) ? $_GET['UserSearch']['created_at'] : '', ['id' => 'date-user', 'class' => "form-control"])
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