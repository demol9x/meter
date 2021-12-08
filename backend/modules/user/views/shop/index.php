<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\shop\Shop;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý nhà thầu';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .center {
        display: block;
        text-align: center;
    }

    select {
        width: 100%;
        height: 32px;
        background: #fff;
        padding: 0px 10px;
        min-width: 97px;
    }

    .fa-times {
        color: red;
    }

    .fa-check {
        color: green;
    }

    .updateajax {
        display: block;
        text-align: center;
        cursor: pointer;
    }

    .box-checkbox {
        position: relative;
        clear: both;
        cursor: pointer;
    }

    .box-checkbox::before {
        content: '';
        display: block;
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .box-checkbox.check .switcherys {
        background-color: rgb(38, 185, 154) !important;
        border-color: rgb(38, 185, 154);
        box-shadow: rgb(38, 185, 154) 0px 0px 0px 11px inset !important;
        transition: border 0.4s, box-shadow 0.4s, background-color 1.2s !important;
    }

    .box-checkbox.check .switcherys small {
        left: 11px !important;
        background-color: rgb(255, 255, 255) !important;
        transition: background-color 0.4s, left 0.2s !important;
    }

    .box-checkbox .switcherys {
        box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;
        border-color: rgb(223, 223, 223);
        background-color: rgb(255, 255, 255);
        transition: border 0.4s, box-shadow 0.4s;
    }

    .box-checkbox .switcherys small {
        left: 0px;
        transition: background-color 0.4s, left 0.2s;
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
                            [
                                'attribute' => 'name',
                                'content' => function ($model) {
                                    return '<a class="blue" target="_blank" title="' . Yii::t('app', 'view_on_web') . '" href="' . Url::to(Yii::$app->urlManagerFrontEnd->createUrl(['/site/router-url', 'id' => $model->user_id, 'alias' => $model->alias, 'url' => '/shop/shop/detail'])) . '">' . $model->name . '</a>';
                                }
                            ],
                            [
                                'header' => Yii::t('app', 'user_manager'),
                                'content' => function ($model) {
                                    if ($user = User::findOne($model->user_id)) {
                                        return '<a class="blue" target="_blank" title="' . Yii::t('app', 'view_user') . '" href="' . Url::to(['/user/user/index', 'UserSearch[id]' => $model->user_id]) . '">' . $user->username . '</a>';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Trạng thái',
                                'content' => function ($model) {
                                    switch ($model->status) {
                                        case 1:
                                            return '<a title="Khóa gian hàng" class="center blockey btn btn-success" data="' . $model->name . '" href="' . Url::to(['/user/shop/block', 'id' => $model->user_id]) . '">Khóa</a>';
                                            break;
                                        case 0:
                                            return '<a title="Khóa gian hàng" class="center blockey btn btn-danger" data="' . $model->name . '" href="' . Url::to(['/user/shop/block', 'id' => $model->user_id]) . '">Mở khóa</a>';
                                            break;

                                        default:
                                            return '<span class="center">' . Yii::t('app', 'waiting') . '<span>';;
                                            break;
                                    }
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'status', [2 => Yii::t('app', 'waiting'), 1 => Yii::t('app', 'status_1'), 0 => Yii::t('app', 'non_active')], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                            ],
                            'phone',
                            'email:email',
                            [
                                'attribute' => 'is_hot',
                                'content' => function ($model) {
                                    if ($model->is_hot) {
                                        return '<div class="box-checkbox check" check="1">
                                                    <span class="switchery switcherys updateajax"  data-link="' . Url::to(['/user/shop/update-hot', 'user_id' => $model->user_id]) . '"><small></small></span>
                                                </div>';
                                    }
                                    return '<div class="box-checkbox"  check="0">
                                                <span class="switchery switcherys updateajax" data-link="' . Url::to(['/user/shop/update-hot', 'user_id' => $model->user_id]) . '" ><small></small></span>
                                            </div>';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'is_hot', [1 => Yii::t('app', 'on'), 0 => Yii::t('app', 'off')], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
                            ],
                            'created_time' => [
                                'attribute' => 'created_time',
                                'value' => function ($model) {
                                    return date('H:i d-m-Y', $model->created_time);
                                },
                                'filter' => Html::input('text', 'ShopSearch[created_time]', isset($_GET['ShopSearch']['created_time']) ? $_GET['ShopSearch']['created_time'] : '', ['id' => 'date-shop', 'class' => "form-control"])
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
    $(document).ready(function () {
        jQuery(document).on('click', '.box-checkbox', function() {
            if (confirm("<?= Yii::t('app', 'you_sure_change') ?>")) {
                $(this).css('display', 'none');
                setTimeout(function() {
                    $('.box-checkbox').css('display', 'block');
                }, 1000);
                var checkbox = $(this).find('.updateajax').first();
                changeHot(checkbox);
                var label = $(this).find('.switchery').first();
                if (!$(this).hasClass('check')) {
                    $(this).addClass('check');
                } else {
                    $(this).removeClass('check');
                }
            }
            return false;
        });

        function changeHot(_this) {
            var link = _this.attr('data-link');
            if (link) {
                jQuery.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: link,
                    data: null,
                    success: function(res) {
                        if (res.code == 200) {
                            // _this.html(res.html);
                            _this.attr('data-link', res.link);
                            // _this.attr('title',res.title);
                        } else {
                            alert('<?= Yii::t('app', 'update_fail') ?>');
                        }
                    },
                    error: function() {
                        alert('<?= Yii::t('app', 'update_fail') ?>');
                    }
                });
            }
        }



        $('#date-shop').daterangepicker({
            autoApply: false,
            // autoUpdateInput : false,
            locale: {
                format: 'DD-MM-YYYY',
                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
            // singleDatePicker: true,
        }, function (start, end, label) {
        });
    });
    <?php if (!(isset($_GET['ShopSearch']['created_time']) && $_GET['ShopSearch']['created_time'])) { ?>
    setTimeout(function () {
        $('#date-shop').val('');
    }, 500);
    <?php } ?>
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.blockey').click(function () {
            var name = $(this).attr('data');
            if (confirm('Bạn có chắn chắn khóa ' + name)) {
                return true;
            }
            return false;
        })
    });
</script>