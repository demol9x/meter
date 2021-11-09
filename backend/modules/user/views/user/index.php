<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\shop\Shop;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý tài khoản';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?php // echo Html::a('Thêm tiền vào số điện thoại', ['create'], ['class' => 'btn btn-success pull-right']) 
                    ?>
                    <?= Html::a('Xuất exel', ['/exel/exel', 'type' => 'USER'], ['class' => 'btn btn-success pull-right', 'target' => '_blank']) ?>
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
                                'username',
                                [
                                    'header' => Yii::t('app', 'shop'),
                                    // 'type' =>'raw',
                                    'content' => function ($model) {
                                        if ($shop = Shop::findOne($model->id)) {
                                            return '<a href="' . Url::to(['/user/shop/index', 'ShopSearch[name]' => $shop->name]) . '">' . $shop->name . '</a>';
                                        }
                                        return 'N/A';
                                    }
                                ],
                                [
                                    'header' => 'Đăng ký bằng',
                                    'value' => function ($model) {
                                        switch ($model->type_social) {
                                            case 1:
                                                return 'Facebook';
                                                break;
                                            default:
                                                return 'Thường';
                                                break;
                                        }
                                    }
                                ],
                                'phone',
                                'email:email',
                                [
                                    'attribute' => 'id_social',
                                    'content' => function ($model) {
                                        return '<a target="_blank" href="https://www.facebook.com/profile.php?id='.$model->id_social.'">'.$model->id_social.'</a>';
                                    }
                                ],
                                // 'link_facebook',
                                'status' => [
                                    'attribute' => 'status',
                                    'value' => function ($model) {
                                        return $model->status == \common\components\ClaLid::STATUS_ACTIVED ? 'Hoạt Động' : 'Đã khóa';
                                    }
                                ],
                                'user_before' => [
                                    'attribute' => 'user_before',
                                    'value' => function ($model) {
                                        return ($model->user_before) ? $model->user_before : 'Không có';
                                    }
                                ],
                                'created_at' => [
                                    'attribute' => 'created_at',
                                    'value' => function ($model) {
                                        return date('H:i d-m-Y', $model->created_at);
                                    },
                                    'filter' => Html::input('text', 'UserSearch[created_at]', isset($_GET['UserSearch']['created_at']) ? $_GET['UserSearch']['created_at'] : '', ['id' => 'date-user', 'class' => "form-control"])
                                ],
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
    <script>
        $(document).ready(function() {
            $('#date-user').daterangepicker({
                // timePicker: true,
                // timePickerIncrement: 5,
                // timePicker24Hour: true,
                autoApply: false,
                // autoUpdateInput : false,
                locale: {
                    format: 'DD-MM-YYYY',
                    daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                },
                // singleDatePicker: true,
                // calender_style: "picker_4"
            }, function(start, end, label) {
                // console.log(start.toISOString(), end.toISOString(), label);
            });
        });
        <?php if (!(isset($_GET['UserSearch']['created_at']) && $_GET['UserSearch']['created_at'])) { ?>
            setTimeout(function() {
                $('#date-user').val('');
            }, 1000);
        <?php } ?>
    </script>
</div>