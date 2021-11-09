<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\shop\Shop;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách yêu cầu';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
.non_active {
    color: blue;
    font-weight: bold;
}
.blocked_active {
    color: red;
    font-weight: bold;
}
.active {
    color: green;
    font-weight: bold;
}
.btn.agree {
    background: green;
    color: #fff;
}

.btn.lock {
    background: red;
    color: #fff;
}
</style>
<div class="user-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'user_id',
                                    'value' => function ($model) {
                                        return $model->show('user_id');
                                    },
                                ],
                                [
                                    'attribute' => 'user_group_id',
                                    'value' => function ($model) {
                                        return $model->show('user_group_id');
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'user_group_id', (new \common\models\user\UserGroup())->options(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                                ],
                                [
                                    'attribute' => 'image',
                                    'content' => function ($model) {
                                        return '<img class="show-img" width="100" src="' . \common\components\ClaHost::getLinkImage('', $model->image) . '" ?>';
                                    },
                                ],
                                [
                                    'attribute' => 'created_at',
                                    'value' => function ($model) {
                                        return date('H:i d-m-Y', $model->created_at);
                                    },
                                    'filter' => Html::input('text', 'UserSearch[created_at]', isset($_GET['UserSearch']['created_at']) ? $_GET['UserSearch']['created_at'] : '', ['id' => 'date-user', 'class' => "form-control"])
                                ],
                                [
                                    'attribute' => 'status',
                                    'content' => function ($model) {
                                        switch ($model->status) {
                                            case 1:
                                                return '<span class="active">Đã xác nhận</span>';
                                                break;
                                            case 0:
                                                return '<span class="blocked_active">Khóa</span>';
                                                break;
                                            default:
                                                return '<span class="non_active">Chờ xác nhận</span>';
                                                break;
                                        }
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', [2 => 'Chờ xác nhận', 1 => 'Đã xác nhận', 0 => 'Khóa'], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                                ],
                                [
                                    'header' => 'Action',
                                    'content' => function ($model) {
                                        switch ($model->status) {
                                            case 1:
                                                return '<a title="Click xác nhận tài khoản" class="btn lock" href="' . Url::to(['/user/user-in-group/lock', 'id' => $model->id]) . '">Khóa yêu cầu</a>';
                                                break;
                                            case 0:
                                                return '';
                                                break;
                                            default:
                                                return '<a title="Click xác nhận tài khoản" class="btn agree" href="' . Url::to(['/user/user-in-group/agree', 'id' => $model->id]) . '">Xác nhận</a><a title="Click xác nhận tài khoản" class="btn lock" href="' . Url::to(['/user/user-in-group/lock', 'id' => $model->id]) . '">Khóa yêu cầu</a>';
                                                break;
                                        }
                                    },
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
<script>
    $(document).on('click', '.show-img', function() {
        src = $(this).attr('data-src') ? $(this).attr('data-src') : $(this).attr('src');
        $('#popup-show-img').addClass('active');
    });
</script>