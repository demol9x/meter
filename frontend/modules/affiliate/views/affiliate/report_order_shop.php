<?php

use common\models\order\Order;
use common\models\affiliate\AffiliateOrder;

$this->title = 'Thông kê thưởng giới thiệu gian hàng';
$hour_confinement = \common\models\gcacoin\Config::getHourConfinement();

?>
<style type="text/css">
    /*# sourceMappingURL=custom.css.map */
    .help-block-error {
        color: #a94442;
    }

    .box-login-register .show-ctn {
        text-align: left;
    }

    .page-list-news .item-news-blog h2 {
        text-transform: initial;
    }

    .box-search-index.open {
        width: 100%;
    }

    .box-search-index.open .btn-hide-media {
        display: none;
    }

    .box-search-index.open .form-text-search button {
        display: block;
    }

    .box-search-index .form-text-search button {
        display: none;
    }

    .box-search-index.open button {
        color: #fff;
    }

    .form-create-store {}

    .form-create-store #daterange {
        padding: 6px 12px;
        border: 1px solid #666;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-create-store #daterange:after {}

    .form-create-store .content .block-bordered {
        background: #ebebeb;
        padding: 5px;
        display: inline-block;
        width: 100%;
        margin-top: 15px;
    }

    .form-create-store .content .block-bordered .block-header {
        text-align: center;
        white-space: nowrap;
        font-size: 15px;
        text-transform: uppercase;
        margin: 0px;
        background: #fff;
        float: left;
        width: 100%;
        padding: 7px;
        color: #71ad2c;
    }

    .form-create-store .content .block-bordered .block-content {
        text-align: center;
        width: 100%;
        float: left;
    }

    .form-create-store .content .block-bordered .text-center {
        width: 100%;
    }

    .form-create-store .content .block-bordered h3.text-center {
        white-space: nowrap;
        font-size: 15px;
        text-transform: uppercase;
        margin: 0px;
        width: 100%;
    }

    .t-tran-pending,
    .t-report {
        font-size: 20px;
    }

    .form-create-store .nav-tabs {
        margin-top: 15px;
    }

    .table-striped {
        min-width: 600px;
    }

    .note {
        color: red;
    }
</style>

<!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <div class="ctn-form">
        <div class="form-create-stores">
            <form method="GET" id="form-search-daterange">
                <input type="hidden" name="start_date" id="start_date" />
                <input type="hidden" name="end_date" id="end_date" />
            </form>
            <input type="text" name="daterange" id="daterange" value="<?= str_replace('-', '/', $start_date) ?> - <?= str_replace('-', '/', $end_date) ?>" />
            <script type="text/javascript">
                //
                $(function() {
                    //
                    $('input[name="daterange"]').daterangepicker({
                        locale: {
                            format: 'DD/MM/YYYY'
                        },
                        maxDate: new Date()
                    });
                    //
                    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                        var start_date = picker.startDate.format('DD-MM-YYYY');
                        start_date = encodeURI(start_date);
                        var end_date = picker.endDate.format('DD-MM-YYYY');
                        end_date = encodeURI(end_date);
                        $('input#start_date').val(start_date);
                        $('input#end_date').val(end_date);
                        $('#form-search-daterange').submit();
                    });
                });
                //
            </script>

            <div class="content">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="block block-bordered">
                            <div class="block-header">
                                <h3 class="block-title text-center">
                                    <i class="fa fa-money"></i> Thưởng (₫)
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="pull-r-l pull-t">
                                    <table class="block-table text-center bg-gray-lighter" style="table-layout:fixed;">
                                        <tbody>
                                            <tr>
                                                <td class="border-r">
                                                    <div class="t-report t-tran-success h3 push-5" id="">
                                                        <span id="valid-conversion-payout-value"><?= number_format($commission[Order::ORDER_DELIVERING], 0, ',', '.') ?></span><sup><?= __VOUCHER_RED ?></sup>
                                                    </div>
                                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                                </td>
                                                <td class="border-r">
                                                    <div class="t-report t-tran-pending h3 push-5" id=""><span id="pending-conversion-payout-value"><?= number_format($commission[Order::ORDER_WAITING_PROCESS], 0, ',', '.') ?></span><sup><?= __VOUCHER_RED ?></sup>
                                                    </div>
                                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                                </td>
                                                <td>
                                                    <div class="t-report t-tran-cancel h3 push-5" id=""><span id="invalid-conversion-payout-value"><?= number_format($commission[Order::ORDER_CANCEL], 0, ',', '.') ?></span><sup><?= __VOUCHER_RED ?></sup>
                                                    </div>
                                                    <div class="h6 text-muted text-uppercase push-5-t">Hủy</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block">

                    <div class="block-content tab-content">
                        <hr />
                        <p class="note">Lưu ý: Số V trong đơn hàng ở trạng thái thành công nếu không có khiếu nại sau 3 ngày sẽ được cộng vào tài khoản của quý khách.</p>
                        <div class="tab-pane active" id="tabs1_conversion">
                            <div class="table_block">
                                <div class="table-responsive">
                                    <div id="table-conversion-list_wrapper" class="dataTables_wrapper form-inline dt-bootstrap dataTables_extended_wrapper no-footer">
                                        <table class="table table-striped table-vcenter table-hover dataTable no-footer" id="table-conversion-list" role="grid" aria-describedby="table-conversion-list_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="STT">STT</th>

                                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thời gian">Thời
                                                        gian
                                                    </th>
                                                    <th class="hidden-sm hidden-md hidden-xs sorting_disabled" rowspan="1" colspan="1" aria-label="Thời gian Click">Mã gian hàng
                                                    </th>
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="STT">Mã sản
                                                        phẩm
                                                    </th>
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Số lượng">Giá
                                                    </th>
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thưởng">Hoa
                                                        hồng
                                                    </th>
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thưởng">
                                                        ID đơn hàng
                                                    </th>
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Trạng thái">
                                                        Trạng
                                                        thái
                                                    </th>
                                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thưởng">
                                                        Tạm giữ
                                                    </th>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (isset($orderItems) && $orderItems) {
                                                    foreach ($orderItems as $item) {
                                                ?>
                                                        <tr role="row" class="filter">
                                                            <td rowspan="1" colspan="1">
                                                                <?= $i++ ?>
                                                            </td>

                                                            <td rowspan="1" colspan="1">
                                                                <?= date('d-m-Y H:i', $item['created_at']) ?>
                                                            </td>
                                                            <td class="hidden-sm hidden-md hidden-xs" rowspan="1" colspan="1">
                                                                <?= $item['shop_id'] ?>
                                                            </td>

                                                            <td rowspan="1" colspan="1">
                                                                <?= $item['product_id'] ?>
                                                            </td>
                                                            <td style="min-width: 200px;" rowspan="1" colspan="1">
                                                                <?= number_format($item['price'], 0, ',', '.') ?> x
                                                                <?= $item['quantity'] ?>
                                                                =
                                                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') . Yii::t('app', 'currency') ?>
                                                            </td>
                                                            <td rowspan="1" colspan="1">
                                                                <?= formatMoney($item['sale_before_shop']) . ' ' . __VOUCHER_RED ?>
                                                            </td>
                                                            <td>
                                                                <?= $item['order_id'] ?>
                                                            </td>
                                                            <td rowspan="1" colspan="1">
                                                                <?= Order::getOrderStatusName($item['status']); ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $return = '';
                                                                $order_status = $item['status'];
                                                                if ($order_status == Order::ORDER_DELIVERING) {
                                                                    if ($item['status_check_cancer'] == \common\components\ClaLid::STATUS_ACTIVED) {

                                                                        $return = 'Hoàn thành';
                                                                    } else {
                                                                        $time = ($item['updated_at'] + $hour_confinement) - time();
                                                                        $time = $time > 0 ? $time / (60 * 60) : 0;
                                                                        if ($time) {
                                                                            $return = 'Gần ' . (($time / 24 > 1) ? CEIL($time / 24) . ' ngày' : CEIL($time) . ' giờ');
                                                                        } else {
                                                                            $return = 'Hoàn thành';
                                                                        }
                                                                    }
                                                                } else if ($order_status == Order::ORDER_CANCEL) {
                                                                    $return = '';
                                                                } else {
                                                                    $return = 'Hơn 3 ngày';
                                                                }
                                                                echo $return;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </thead>
                                        </table>

                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>