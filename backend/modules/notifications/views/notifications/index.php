<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\notifications\Notifications;

/* @var $this yii\web\View */
/* @var $searchModel common\models\notifications\search\NotificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thông báo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Tạo thông báo', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'title',
                            'description:ntext',
                            'link',
                            'type' => [
                                'header' => 'Loại',
                                'content' => function ($model) {
                                    return Notifications::getTypeName($model->type);
                                }
                            ],
                            'created_at' => [
                                'header' => 'Ngày tạo',
                                'content' => function ($model) {
                                    return date('d/m/Y', $model->created_at);
                                }
                            ],
                            [
                                'header' => 'Trạng thái',
                                'content' => function ($model) {
                                    if ($model->recipient_id == Notifications::TYPE_WAITING_SEND) {
                                        return 'Chờ gửi';
                                    }
                                    return 'Đã gửi';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'recipient_id', [Notifications::TYPE_USER_ALL => 'Đã gửi', Notifications::TYPE_WAITING_SEND => 'Chờ gửi'], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
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