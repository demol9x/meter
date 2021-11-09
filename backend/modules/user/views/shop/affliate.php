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
                                    'header' => 'Thông tin thay đổi',
                                    'content' => function ($model) {
                                        if ($model->status_affiliate_waitting == 1) {
                                            if ($model->status_affiliate == 1) {
                                                return "Thay đổi thông tin affilate";
                                            } else {
                                                return "Tham gia affilate";
                                            }
                                        } else {
                                            if ($model->status_affiliate == 1) {
                                                return "Hủy tham gia affilate";
                                            } else {
                                                return "Thay đổi thông tin affilate";
                                            }
                                        }
                                    },
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
                                    'template' => '{view}'
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