<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\ClaHost;

/* @var $this yii\web\View */
/* @var $searchModel common\models\user\search\UserMoneySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý danh hiệu gian hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-money-index">

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
                            'name',
                            [
                                'header' => Yii::t('app', 'avatar'),
                                'content' => function($model) {
                                    return '<img src="' . ClaHost::getImageHost() . $model['avatar_path'] . 's100_100/' . $model['avatar_name'] . '" />';
                                }
                            ],
                            [
                                'header' => Yii::t('app', 'image'),
                                'content' => function($model) {
                                    return '<img src="' . ClaHost::getImageHost() . $model['image_path'] . 's100_100/' . $model['image_name'] . '" />';
                                }
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
