<?php

use common\models\order\Order;
use common\models\affiliate\AffiliateOrder;

?>

<!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>

<div class="form-create-store">
    <div class="infor-account">
        <h2>
            Thưởng trên từng sản phẩm
        </h2>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="block block-bordered">
                    <div class="block-header">
                        <h3 class="block-title text-center"><i class="fa fa-cart-arrow-down"></i> Đơn hàng</h3>
                    </div>
                    <div class="block-content">
                        <div class="pull-r-l pull-t">
                            <table class="block-table text-center bg-gray-lighter" style="table-layout:fixed;">
                                <tbody>
                                <tr>
                                    <td class="border-r">
                                        <div class="t-report t-tran-success h3 push-5"><span
                                                    id="valid-conversion-count-value"><?= $orderSuccess ?></span>
                                        </div>
                                        <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                    </td>
                                    <td class="border-r">
                                        <div class="t-report t-tran-pending h3 push-5" id=""><span
                                                    id="pending-conversion-count-value"><?= $orderWaiting ?></span>
                                        </div>
                                        <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                    </td>
                                    <td>
                                        <div class="t-report t-tran-cancel h3 push-5" id=""><span
                                                    id="invalid-conversion-count-value"><?= $orderCancel ?></span>
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
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
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
                                            <span id="valid-conversion-payout-value"><?= number_format($userMoney['money'], 0, ',', '.') ?>
                                                <sup>₫</sup></span>
                                        </div>
                                        <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                    </td>
                                    <td class="border-r">
                                        <div class="t-report t-tran-pending h3 push-5" id="">
                                            <span id="pending-conversion-payout-value"><?= number_format($userMoney['money_waiting'], 0, ',', '.') ?>
                                                <sup>₫</sup></span>
                                        </div>
                                        <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                    </td>
                                    <td>
                                        <div class="t-report t-tran-cancel h3 push-5" id="">
                                            <span id="invalid-conversion-payout-value"><?= number_format($userMoney['money_cancel'], 0, ',', '.') ?>
                                                <sup>₫</sup></span>
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
            <ul class="nav nav-tabs" data-toggle="tabs" id="abc8">
                <li class="active" id="tour_tab_cvs">
                    <a href="javascript:void(0)">Đơn hàng</a>
                </li>
            </ul>
            <div class="block-content tab-content">
                <div class="tab-pane active" id="tabs1_conversion">
                    <div class="table_block">
                        <div class="table-responsive">
                            <div id="table-conversion-list_wrapper"
                                 class="dataTables_wrapper form-inline dt-bootstrap dataTables_extended_wrapper no-footer">
                                <table class="table table-striped table-vcenter table-hover dataTable no-footer"
                                       id="table-conversion-list" role="grid"
                                       aria-describedby="table-conversion-list_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="STT">
                                            STT
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="STT">
                                            Mã sản phẩm
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="STT">
                                            Tên sản phẩm
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thời gian">
                                            Thời gian
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Trạng thái">
                                            Trạng thái
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Số lượng">
                                            Giá
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Số lượng">
                                            Số lượng
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thưởng">
                                            Thưởng
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thưởng">
                                            ID đơn hàng
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thưởng">
                                            Trạng thái sản phẩm
                                        </th>
                                    </tr>
                                    <?php
                                    if (isset($allOrder) && $allOrder) {
                                        foreach ($allOrder as $item) {
                                            $orderItem = \common\models\order\OrderItem::findOne($item['order_item_id']);
                                            $product = \common\models\product\Product::findOne($orderItem['product_id']);
                                            ?>
                                            <tr role="row" class="filter">
                                                <td rowspan="1" colspan="1">
                                                    <?= $item['id'] ?>
                                                </td>
                                                <td rowspan="1" colspan="1">
                                                    <?= $product['code'] ?>
                                                </td>
                                                <td rowspan="1" colspan="1">
                                                    <?= $product['name'] ?>
                                                    <?php
                                                    if (isset($orderItem['is_configurable']) && $orderItem['is_configurable'] && isset($orderItem['configurable_id']) && $orderItem['configurable_id']) {
                                                        $dataConfig = \frontend\components\AttributeHelper::getProductConfigurable($orderItem['product_id'], $orderItem['configurable_id']);
                                                        echo ' - <span class="variant-title">' . $dataConfig['label_ext'] . '</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td rowspan="1" colspan="1">
                                                    <?= date('d-m-Y H:i', $item['created_at']) ?>
                                                </td>
                                                <td rowspan="1" colspan="1">
                                                    <?php
                                                    if ($item['type'] == \common\models\user\UserMoneyLog::TYPE_PLUS_DESIGN) {
                                                        echo 'Thành công';
                                                    } else if ($item['type'] == \common\models\user\UserMoneyLog::TYPE_PLUS_DESIGN_WAITING) {
                                                        echo 'Chờ duyệt';
                                                    } else if ($item['type'] == \common\models\user\UserMoneyLog::TYPE_PLUS_DESIGN_CANCEL) {
                                                        echo 'Hủy';
                                                    }
                                                    ?>
                                                </td>
                                                <td rowspan="1" colspan="1">
                                                    <?php
                                                    echo number_format($orderItem['price'], 0, ',', '.');
                                                    ?>
                                                </td>
                                                <td rowspan="1" colspan="1">
                                                    <?php
                                                    echo $orderItem['quantity'];
                                                    ?>
                                                </td>
                                                <td rowspan="1" colspan="1">
                                                    <?php
                                                    echo number_format($item['money_change'], 0, ',', '.');
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $item['order_id'] ?>
                                                </td>
                                                <td>
                                                    Thiết kế
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