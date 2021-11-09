<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\shop\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'product_management');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .add-product-managers {
        opacity: 0;
    }
    .add-product-managers:hover {
        opacity: 1;
    }
    .selectedt {
        opacity: 0.8 !important;
    }

</style>
<div class="manager-product-store">
    <div class="nav-manager-product">
        <div class="count-product"><?= $totalitem ?> <?= Yii::t('app', 'product') ?></div>
        <ul class="manager-nav tab-menu">
            <li class="active"> <a id="1" href="javascript:void(0);"><?= Yii::t('app', 'all') ?></a> </li>
            <li>
                <a id="2" load="1" href="javascript:void(0);"><?= Yii::t('app', 'have_product') ?></a>
            </li>
            <li>
                <a id="3" load="1" href="javascript:void(0);"><?= Yii::t('app', 'not_product') ?></a>
            </li>
        </ul>
    </div>
    <div class="filter-manager-product">
        <div class="btn-tool">
            <a class="click" id="check-all" data="1"><?= Yii::t('app', 'check_all') ?></a>
            <a class="remove click" id="delete-all"><?= Yii::t('app', 'delete') ?></a>
            <?php if(\common\models\promotion\Promotions::getPromotionNow()) { ?>
                <a class="new-add-version" id="add-promotion" href="<?= Url::to(['/management/promotion/add-product-space']) ?>">Quản lý khuyễn mãi</a>
            <?php } ?>
        </div>
        <?= frontend\widgets\html\HtmlWidget::widget([
                'view' => 'view_product_tool'
            ]);
        ?>
    </div>
    <div class="list-product-manager section-product">
        <div class="row-5 product-in-store tab-menu-read tab-menu-read-1 tab-active" style="display: block;" id="tab-product-1">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                <div class="item-product-inhome">
                    <div class="img">
                        <a href="">
                        </a>
                    </div>
                    <h3>
                    </h3>
                    <p class="price">
                        <del>300.000đ</del>200.000đ/kg
                    </p>
                    <div class="review">
                        <div class="star">
                            <i class="fa fa-star yellow"></i>
                            <i class="fa fa-star yellow"></i>
                            <i class="fa fa-star yellow"></i>
                            <i class="fa fa-star yellow"></i>
                            <i class="fa fa-star yellow"></i>
                            <span>(50)</span>
                        </div>
                        <div class="wishlist">
                            <a href=""><i class="fa fa-heart-o"></i></a>
                        </div>
                        <div class="car-ship">
                            <i class="fa fa-truck"></i>
                        </div>
                    </div>
                    <div class="add-product-manager">
                        <a href="<?= Url::to(['/management/product/create']) ?>">
                        <button>
                            <span class="plus-circle"><i class="fa fa-plus"></i></span>
                            <p><?= Yii::t('app', 'add_new_product') ?></p>
                        </button>
                        </a>
                    </div>
                </div>
            </div>
            <?php
                if($products) {
                    echo frontend\widgets\html\HtmlWidget::widget([
                        'input' => [
                            'products' => $products,
                            'div_col' => '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">'
                        ],
                        'view' => 'view_product_tool_1'
                    ]);
                }
            ?>
            <div class="paginate">
                <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => new yii\data\Pagination([
                            'pageSize' => $limit,
                            'totalCount' => $totalitem
                        ])
                    ]);
                ?>
            </div>
        </div>
        <div class="row-5 product-in-store tab-menu-read tab-menu-read-2" style="display: none;" id="tab-product-2">
        </div>
        <div class="row-5 product-in-store tab-menu-read tab-menu-read-3" style="display: none;"  id="tab-product-3">
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#1').click(function (){
            $('.tab-menu-read').removeClass('tab-active');
            $('#tab-product-1').addClass('tab-active');
        });
        $('#2').click(function (){
            $('.tab-menu-read').removeClass('tab-active');
            $('#tab-product-2').addClass('tab-active');
            if($(this).attr('load') == '1') {
                var _this = $(this);
                _this.attr('load','0');
                jQuery.ajax({
                    url: '<?= Url::to(['/management/product/load-product']) ?>',
                    data: {status: 1},
                    // type: 'POST',
                    beforeSend: function () {
                    },
                    success: function (res) {
                       $('#tab-product-2').html(res);
                    },
                    error: function () {
                    }
                });
            }
        });
        $('#3').click(function (){
            $('.tab-menu-read').removeClass('tab-active');
            $('#tab-product-3').addClass('tab-active');
            if($(this).attr('load') == '1') {
                var _this = $(this);
                _this.attr('load','0');
                jQuery.ajax({
                    url: '<?= Url::to(['/management/product/load-product']) ?>',
                    data: {status: 0},
                    // type: 'POST',
                    beforeSend: function () {
                    },
                    success: function (res) {
                       $('#tab-product-3').html(res);
                    },
                    error: function () {
                    }
                });
            }
        });
        $('#check-all').click(function (){
            if($(this).attr('data') == '1') {
                $(this).attr('data' ,'0');
                $('.tab-active').find('.add-product-managers').addClass('selectedt');
                $(this).html('<?= Yii::t('app', 'cancer_all') ?>');
                $('.tab-active').find('.notselectedbt').html('<?= Yii::t('app', 'selected') ?>');
                $('.tab-active').find('.notselectedbt').removeClass('notselectedbt').addClass('selectedbt');
            } else {
                $(this).attr('data' ,'1');
                $('.add-product-managers').removeClass('selectedt');
                $(this).html('<?= Yii::t('app', 'check_all') ?>');
                $('.selectedbt').html('<?= Yii::t('app', 'select') ?>');
                $('.selectedbt').removeClass('selectedbt').addClass('notselectedbt');
            }
        });
        $('#delete-all').click(function (){
            if(confirm('<?= Yii::t('app', 'are_you_delete') ?>')){
                var data = $('.tab-active').find('.selectedt');
                var listid = Array();
                for (var i = 0; i < data.length ; i++) {
                    listid[i] = $(data[i]).attr('data');
                }
                if(listid.length > 0) {
                    $.getJSON(
                    "<?= Url::to(['/management/product/deleteall']) ?>",
                    {listid:listid}
                    ).done(function (data) {
                        if(data != '0') {
                            $('.tab-active').find('.selectedt').parent().parent().remove();
                        }
                    }).fail(function (jqxhr, textStatus, error) {
                        var err = textStatus + ", " + error;
                        console.log("Request Failed: " + err);
                    });
                }
            }
            return false;
        });
    });
    jQuery(document).on('click', '.selectedt', function () {
        $(this).removeClass('selectedt');
        event.stopPropagation();
    });
    jQuery(document).on('click', '.notselectedbt', function () {
        $(this).parent().parent().addClass('selectedt');
        $(this).removeClass('notselectedbt');
        $(this).addClass('selectedbt');
        $(this).html('<?= Yii::t('app', 'selected') ?>');
        event.stopPropagation();
    });
    jQuery(document).on('click', '.selectedbt', function () {
        $(this).parent().parent().removeClass('selectedt');
        $(this).removeClass('selectedbt');
        $(this).addClass('notselectedbt');
        $(this).html('<?= Yii::t('app', 'selecte') ?>');
        event.stopPropagation();
    });
    jQuery(document).on('click', '.delete-product', function () {
        if(confirm('<?= Yii::t('app', 'are_you_delete') ?>')){
            $(this).parent().parent().parent().parent().remove();
            var id = $(this).attr('data');
            jQuery.ajax({
                url: '<?= Url::to(['/management/product/delete']) ?>',
                data: {id:id},
                type: 'POST',
                beforeSend: function () {
                },
                success: function (res) {
                   // $(this).parent().parent().parent().remove();
                },
                error: function () {
                }
            });
        }
        return false;
    });
    jQuery(document).on('click', '.do-not-product', function () {
        if(confirm('<?= Yii::t('app', 'are_sure_change_to_over') ?>')){
            $(this).parent().parent().parent().parent().remove();
            var id = $(this).attr('data');
            jQuery.ajax({
                url: '<?= Url::to(['/management/product/change-status-quantity']) ?>',
                data: {id: id, status_quantity: 0},
                type: 'POST',
                beforeSend: function () {
                },
                success: function (res) {
                    $('#3').attr('load','1');
                   // $(this).parent().parent().parent().remove();
                },
                error: function () {
                }
            });
        }
        return false;
    });
    jQuery(document).on('click', '.do-have-product', function () {
        if(confirm('<?= Yii::t('app', 'are_sure_change_to_having') ?>')){
            $(this).parent().parent().parent().parent().remove();
            var id = $(this).attr('data');
            jQuery.ajax({
                url: '<?= Url::to(['/management/product/change-status-quantity']) ?>',
                data: {id: id, status_quantity: 1},
                type: 'POST',
                beforeSend: function () {
                },
                success: function (res) {
                    $('#2').attr('load','1');
                   // $(this).parent().parent().parent().remove();
                },
                error: function () {
                }
            });
        }
        return false;
    });
    jQuery(document).on('click', '.paginate-load>.pagination>li>a', function () {
        var href = $(this).attr('href');
        jQuery.ajax({
            url: href,
            // type: 'POST',
            beforeSend: function () {
            },
            success: function (res) {
               $('.tab-active').html(res);
            },
            error: function () {
            }
        });
        return false;
    });
</script>
