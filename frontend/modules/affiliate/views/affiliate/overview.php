<?php

use common\models\order\Order;
?>
<style type="text/css">
    /*# sourceMappingURL=custom.css.map */
    .help-block-error{
        color: #a94442;
    }

    .box-login-register .show-ctn{
        text-align: left;
    }
    .page-list-news .item-news-blog h2{
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

    .form-create-store{

    }
    .form-create-store #daterange{
        padding: 6px 12px;
        border: 1px solid #666;
        border-radius: 5px;
        font-size: 14px;
    }
    .form-create-store #daterange:after{

    }
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
    .form-create-store .content .block-bordered .block-content{
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
    .t-tran-pending, .t-report{
        font-size: 20px;
    }
    .form-create-store .nav-tabs {
        margin-top: 15px;
    }

    .table-striped{
        min-width: 600px;
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
                $(function () {
                    //
                    $('input[name="daterange"]').daterangepicker({
                        locale: {
                            format: 'DD/MM/YYYY'
                        },
                        maxDate: new Date()
                    });
                    //
                    $('#daterange').on('apply.daterangepicker', function (ev, picker) {
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
            <div class="content bg-white border-b">
                <div class="row items-push text-uppercase">

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <div class="block block-bordered">
                            <div class="block-header">
                                <h3 class="block-title text-center">
                                    Click
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="pull-r-l pull-t">
                                    <div class="h6 text-muted text-uppercase push-5-t">Số lượng</div>
                                    <div class="t-report t-cvr h3 push-5"><span id="cr-order-convert"><?= $clickCount ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <div class="block block-bordered">
                            <div class="block-header">
                                <h3 class="block-title text-center">
                                    Đơn hàng
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="pull-r-l pull-t">
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                    <div class="t-report t-cvr h3 push-5"><span id="cr-order-convert"><?= $orderCompleteCount ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <div class="block block-bordered">
                            <div class="block-header">
                                <h3 class="block-title text-center">
                                    Đơn hàng
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="pull-r-l pull-t">
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                    <div class="t-report t-cvr h3 push-5"><span id="cr-order-convert"><?= $orderWaitingCount ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <div class="block block-bordered">
                            <div class="block-header">
                                <h3 class="block-title text-center">
                                    Tỉ lệ chuyển đổi
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="pull-r-l pull-t">
                                    <div class="h6 text-muted text-uppercase push-5-t">Đơn hàng / Click</div>
                                    <div class="t-report t-cvr h3 push-5"><span id="cr-order-convert"><?= number_format($rate, 0, ',', '.') ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <div class="block block-bordered">
                            <div class="block-header">
                                <h3 class="block-title text-center">
                                    Thưởng
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="pull-r-l pull-t">
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                    <div class="t-report t-cvr h3 push-5"><span id="cr-order-convert"><?= number_format($commission[Order::ORDER_DELIVERING], 0, ',', '.') ?></span><sup><?= __VOUCHER_RED ?></sup></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <div class="block block-bordered">
                            <div class="block-header">
                                <h3 class="block-title text-center">
                                    Thưởng
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="pull-r-l pull-t">
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                    <div class="t-report t-cvr h3 push-5"><span id="cr-order-convert"><?= number_format($commission[Order::ORDER_WAITING_PROCESS], 0, ',', '.') ?></span><sup><?= __VOUCHER_RED ?></sup></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Ngày', 'Click', 'Đơn hàng'],
            <?php
            $str = '';
            foreach ($data as $day => $item) {
                if ($str != '') {
                    $str .= ',';
                }
                $str .= '["' . $day . '", ' . $item['click'] . ', ' . $item['order'] . ']';
            }
            echo $str;
            ?>
                        ]);

                        var options = {
                            title: 'Click & Order',
                            titlePosition: 'none',
                            hAxis: {
                                title: 'Thống kê Click và Đơn hàng',
                                titleTextStyle: {color: '#333'}
                            },
                            vAxis: {
                                minValue: 0
                            },
                            chartArea: {
                                width: '80%'
                            },
                            legend: {position: 'top', maxLines: 3},
                            pointShape: 'circle',
                            pointSize: 3
                        };

                        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
                    }
                </script>
            <div id="chart_div" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
</div>