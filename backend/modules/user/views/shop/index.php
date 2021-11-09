<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\shop\Shop;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý gian hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .center {
        display: block;
        text-align: center;
    }
</style>
<div class="user-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Xuất exel', ['/exel/exel', 'type' => 'SHOP'], ['class' => 'btn btn-success pull-right', 'target' => '_blank']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // 'id',
                                [
                                    'attribute' => 'name',
                                    'content' => function ($model) {
                                        return '<a class="blue" target="_blank" title="' . Yii::t('app', 'view_on_web') . '" href="' . Url::to(Yii::$app->urlManagerFrontEnd->createUrl(['/site/router-url', 'id' => $model->id, 'alias' => $model->alias, 'url' => '/shop/shop/detail'])) . '">' . $model->name . '</a>';
                                    }
                                ],
                                [
                                    'header' => Yii::t('app', 'user_manager'),
                                    'content' => function ($model) {
                                        if ($user = User::findOne($model->id)) {
                                            return '<a class="blue" target="_blank" title="' . Yii::t('app', 'view_user') . '" href="' . Url::to(['/user/user/index', 'UserSearch[id]' => $model->id]) . '">' . $user->username . '</a>';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'content' => function ($model) {
                                        switch ($model->status) {
                                            case 1:
                                                return '<a title="Khóa gian hàng" class="center blockey" data="' . $model->name . '" href="' . Url::to(['/user/shop/block', 'id' => $model->id]) . '"><i class="fa fa-lock"></i></a>';
                                                break;
                                            case 0:
                                                return '<span class="center">' . Yii::t('app', 'non_active') . '<span>';
                                                break;

                                            default:
                                                return '<span class="center">' . Yii::t('app', 'waiting') . '<span>';;
                                                break;
                                        }
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'status', [2 => Yii::t('app', 'waiting'), 1 => Yii::t('app', 'status_1'), 0 => Yii::t('app', 'non_active')], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                                ],
                                [
                                    'attribute' => 'shop_acount_type',
                                    'content' => function ($model) {
                                        return $model->getNameTypeAcount();
                                    },
                                    'filter' => Html::activeDropDownList($searchModel, 'shop_acount_type', \common\models\shop\Shop::getOptionsTypeAcount() , ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                                ],
                                'phone',
                                'email:email',
                                'created_time' => [
                                    'attribute' => 'created_time',
                                    'value' => function ($model) {
                                        return date('H:i d-m-Y', $model->created_time);
                                    },
                                    'filter' => Html::input('text', 'ShopSearch[created_time]', isset($_GET['ShopSearch']['created_time']) ? $_GET['ShopSearch']['created_time'] : '', ['id' => 'date-shop', 'class' => "form-control"])
                                ],
                                // 'address',
                                // 'facebook',
                                'viewed',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}'
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
    $(document).ready(function() {
        $('#date-shop').daterangepicker({
            autoApply: false,
            // autoUpdateInput : false,
            locale: {
                format: 'DD-MM-YYYY',
                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
            // singleDatePicker: true,
        }, function(start, end, label) {});
    });
    <?php if (!(isset($_GET['ShopSearch']['created_time']) &&  $_GET['ShopSearch']['created_time'])) { ?>
        setTimeout(function() {
            $('#date-shop').val('');
        }, 500);
    <?php } ?>
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.blockey').click(function() {
            var name = $(this).attr('data');
            if (confirm('Bạn có chắn chắn khóa ' + name)) {
                return true;
            }
            return false;
        })
    });
</script>