<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use common\models\news\NewsCategory;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\NewsCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý liên hệ khách hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.contentin {
    max-width: 300px;
    max-height: 100px;
    overflow: auto;
}
</style>
<div class="news-category-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div>
                <?php date_default_timezone_set('Asia/Ho_Chi_Minh'); ?>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            'body' => [
                                'header' => 'Nội dung',
                                'content' => function ($model) {
                                    return '<div class="contentin">'.strip_tags($model->body).'</div>';
                                }
                            ],
                            'phone',
                            'email' => [
                                'attribute' => 'email',
                                'content' => function ($model) {
                                    return '<a href="mailto:' . $model->email . '">' . $model->email . '</a>';
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'content' => function ($model) {
                                    return date('H:i d-m-Y', $model->created_at);
                                }
                            ],
                            [
                                'attribute' => 'viewed',
                                'content' => function ($model) {
                                    return '<a class="btn btn-primary" href="view?id=' . $model->id . '">' . ($model->viewed ? 'xem' : 'Xử lý') . '</a>';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'viewed', ['0' => 'Chưa xử lý', '1' => 'Đã xử lý'], ['class' => 'form-control', 'prompt' => ''])
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