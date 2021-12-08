<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\user\ThoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách thợ';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
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
<div class="tho-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'value' => 'user.username'
            ],
            'tot_nghiep',
            'nghe_nghiep',
            'chuyen_nganh',
            'kinh_nghiem',
            [
                'attribute' => 'is_hot',
                'content' => function ($model) {
                    if ($model->is_hot) {
                        return '<div class="box-checkbox check" check="1">
                                                    <span class="switchery switcherys updateajax"  data-link="' . Url::to(['/user/tho/update-hot', 'user_id' => $model->user_id]) . '"><small></small></span>
                                                </div>';
                    }
                    return '<div class="box-checkbox"  check="0">
                                                <span class="switchery switcherys updateajax" data-link="' . Url::to(['/user/tho/update-hot', 'user_id' => $model->user_id]) . '" ><small></small></span>
                                            </div>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'is_hot', [1 => Yii::t('app', 'on'), 0 => Yii::t('app', 'off')], ['class' => 'form-control', 'prompt' => Yii::t('app', 'selects')])
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('d-m-Y', $model->created_at);
                }
            ],
//            ['class' => 'yii\grid\ActionColumn'],
        ]
    ]); ?>
</div>
<script type="text/javascript">
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
</script>
