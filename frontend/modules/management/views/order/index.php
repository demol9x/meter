<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 12/1/2021
 * Time: 9:48 AM
 */
?>
<style type="text/css">
    .bg-pop-white {
        min-height: 400px;
    }

    .bg-pop-white > img {
        margin-left: 47%;
    }

    .code-item {
        font-size: 16px;
    }

    .bottom-item-info-donhang .btn-view-shop {
        height: unset;
    }

    .bottom-item-info-donhang .code-donhang a {
        line-height: 36px;
        height: 35px;
        text-transform: uppercase;
        font-weight: 500;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        -webkit-border-radius: 12px;
        -moz-border-radius: 12px;
        border-radius: 3px;
        background-color: #17a349;
        -webkit-box-shadow: 2px 3px 6px rgba(0, 0, 0, 0.25);
        -moz-box-shadow: 2px 3px 6px rgba(0, 0, 0, 0.25);
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25);
        color: #fff !important;
        font-size: 13px;
        display: inline-block;
        padding: 0px 20px;
        white-space: nowrap;
        font-family: "Roboto", Arial, sans-serif;
        border: none;
        margin-bottom: 11px;
        border: 1px solid #17a349;
        transition: all 0.4s ease;
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        -ms-transition: all 0.4s ease;
        margin-left: 20px;
    }

    .nav-donhang {
        float: left;
        width: 100%;
        overflow-x: auto;
    }

    .nav-donhang ul {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .nav-donhang li {
        display: inline-block;
        position: relative;
        float: left;
    }

    .nav-donhang li.active a {
        color: #2f80ed;
        background: #ebebeb69;
    }

    .nav-donhang li a {
        color: #4f4f4f;
        font-family: Helvetica Neue medium;
        text-transform: uppercase;
        float: left;
        padding: 15px 15px 10px 15px;
        text-align: center;
        width: 100%;
        font-size: 14px;
    }

    .nav-donhang a:hover, a:focus {
        color: #23527c;
        text-decoration: underline;
    }

    .item-info-donhang {
        position: relative;
    }

    .item-info-donhang {
        float: left;
        width: 100%;
        background: #fff;
        box-shadow: 0px 1px 6px #ccc;
        margin-bottom: 15px;
        padding: 15px 0;
    }

    .table-shop {
        overflow-x: auto;
    }

    .table-donhang {
        float: left;
        width: 100%;
    }

    .table-shop table {
        width: 100%;
    }

    .table-donhang .img {
        width: 100px;
    }

    .table-shop table tr:first-child td {
        border-top: none;
    }

    .table-shop table > tbody > tr > td, .table-shop table > tfoot > tr > td {
        padding: 15px;
        line-height: 1.42857143;
        vertical-align: middle;
        border-top: 1px solid #eee;
        text-align: left;
        font: 14px/18px "arial";
        color: #4a4a4a;
    }

    .item-info-donhang .title {
        float: left;
        width: 100%;
        padding: 10px 15px 0 15px;
        /*border-bottom: 1px solid #ebebeb;*/
    }

    .code-item {
        font-size: 16px;
    }

    .bottom-item-info-donhang .btn-view-shop {
        height: unset;
    }

    .item-info-donhang .btn-view-shop {
        float: left;
        line-height: 31px;
        color: #2f80ed;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .item-info-donhang .code-donhang {
        float: right;
        line-height: 31px;
        font-size: 13px;
    }

    .bottom-item-info-donhang .code-donhang a {
        line-height: 36px;
        height: 35px;
        text-transform: uppercase;
        font-weight: 500;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        -webkit-border-radius: 12px;
        -moz-border-radius: 12px;
        border-radius: 3px;
        background-color: #17a349;
        -moz-box-shadow: 2px 3px 6px rgba(0, 0, 0, 0.25);
        color: #fff !important;
        font-size: 13px;
        display: inline-block;
        padding: 0px 20px;
        white-space: nowrap;
        font-family: "Roboto", Arial, sans-serif;
        border: none;
        margin-bottom: 11px;
        border: 1px solid #17a349;
        transition: all 0.4s ease;
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        -ms-transition: all 0.4s ease;
        margin-left: 20px;
    }

    body .code-donhang .cancer {
        background-color: #EA4335 !important;
        border-color: #EA4335 !important;
    }
    @media (max-width: 991px) {
        .nav-donhang li a {
            font-size: 13px;
            padding: 10px 15px 10px 15px;
        }
        .form-create-store .title-form h2 {
            padding: 10px 0 10px 20px;
        }
    }
    @media (max-width: 600px) {
        .nav-donhang li a {
            font-size: 11px;
            padding: 10px;
        }
        .bottom-item-info-donhang .code-donhang a {
            margin-left: 10px;
        }
    }
    @media (max-width: 480px) {
        .nav-donhang li a {
            font-size: 10px;
            padding: 7px;
        }
        .bottom-item-info-donhang .code-donhang a {
            line-height: 30px;
            height: 30px;
            padding: 0px 10px;
            font-size: 12px;
        }
    }
</style>
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt=""> Danh sách đơn hàng
            </h2>
        </div>
        <div class="nav-donhang">
            <ul class="tab-menu">
                <li class="stt-order active" onclick="getOrder(this)" data-status="1">
                    <a href="javascript:void(0);"><?= Yii::t('app', 'new_order') ?> </a>
                </li>
                <li class="stt-order" onclick="getOrder(this)" data-status="2">
                    <a href="javascript:void(0);"><?= Yii::t('app', 'order_waiting_add') ?> </a>
                </li>
                <li class="stt-order" onclick="getOrder(this)" data-status="3">
                    <a href="javascript:void(0);"><?= Yii::t('app', 'order_waiting_transport') ?> </a>
                </li>
                <li class="stt-order" onclick="getOrder(this)" data-status="4">
                    <a href="javascript:void(0);"><?= Yii::t('app', 'order_recived') ?> </a>
                </li>
                <li class="stt-order" onclick="getOrder(this)" data-status="0">
                    <a href="javascript:void(0);"><?= Yii::t('app', 'order_canced') ?> </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="ctn-donhang tab-menu-read tab-menu-read-1" id="body-order">
        <?php if ($orders): ?>
            <?php foreach ($orders as $order): ?>
                <div class="item-info-donhang  " id="box-b1-632">
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="table-donhang table-shop">
                            <table>
                                <tbody>
                                <tr>
                                    <td width="100">
                                        <div class="img">
                                            <a target="_blank" href="<?= \yii\helpers\Url::to(['/product/product/detail', 'id' => $item['product_id']]) ?>">
                                                <img src="<?= \common\components\ClaHost::getImageHost() . $item['avatar_path'] . $item['avatar_name'] ?>"
                                                     alt="<?= $item['name'] ?>">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="vertical-top" width="250">
                                        <h2>
                                            <a target="_blank" href="<?= \yii\helpers\Url::to(['/product/product/detail', 'id' => $item['product_id']]) ?>"><?= $item['name'] ?></a>
                                        </h2>
                                        <span class="quantity">x<?= (int)$item['quantity'] ?></span>
                                    </td>
                                    <td>
                                        <p class="price-donhang"><?= number_format($item['price']) ?> đ</p>
                                    </td>
                                    <td style="text-align: right;">
                                        <p class="price-donhang">
                                            <?= number_format($item['price'] * $item['quantity']) ?> đ </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endforeach; ?>
                    <div class="title bottom-item-info-donhang">
                        <p class="code-item">Đơn hàng: <b>OR<?= $order['id'] ?></b></p>
                        <div class="btn-view-shop">
                            <p>
                                Phí vận chuyển: Liên hệ </p>
                            <p>
                                Tổng tiền: <?= number_format($order['order_total']) ?> đ </p>

                        </div>
                        <div class="code-donhang">
                            <?php if ($order['status'] == 1): ?>
                                <a class="click cancer" onclick="cancer(<?= $order['id'] ?>)">Hủy đơn hàng</a>
                            <?php endif; ?>
                            <a class="open-popup-link open-popup-link-b" data-id="632" href="#donhang-chuanbi">Chi tiết đơn hàng</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<script>
    function getOrder(t) {
        $('.stt-order').removeClass('active');
        $(t).addClass('active');
        $.ajax({
            url: "<?= \yii\helpers\Url::to(['/management/order/load']) ?>",
            type:'get',
            data: {
                status: $(t).data('status')
            },
            success: function (result) {
                $('#body-order').empty().html(result);
            }
        });
    }

    $(document).ready(function () {
    });
</script>
