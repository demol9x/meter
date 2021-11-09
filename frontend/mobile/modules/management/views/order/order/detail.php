<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<div class="box-account">
    <span class="mfp-close"></span>
    <div class="bg-pop-white">
        <div class="title-popup">
            <h2><?= Yii::t('app', 'order_detail') ?></h2>
        </div>
        <div class="ctn-popup">
            <div class="box-detail-order">
                <h2>
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <b><?= Yii::t('app', 'order') ?></b>
                    #<?= $product['t_id'] ?>
                </h2>
                <div class="table-shop">
                    <table>
                        <tbody>
                            <tr>
                                <td class="bg-eb" width="150">
                                    <p><?= Yii::t('app', 'custumer') ?></p>
                                </td>
                                <td>
                                    <p><?= $product['o_name'] ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-eb" width="150">
                                    <p><?= Yii::t('app', 'product') ?></p>
                                </td>
                                <td>
                                    <p><?= $product['name'] ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-eb" width="150">
                                    <p><?= Yii::t('app', 'quantity') ?></p>
                                </td>
                                <td>
                                    <p><?= $product['t_quantity'] ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-eb" width="150">
                                    <p><?= Yii::t('app', 'date_sell') ?></p>
                                </td>
                                <td>
                                    <p><?= date('d/m/Y', $product['t_created_at']) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-eb" width="150">
                                    <p><?= Yii::t('app', 'costs') ?></p>
                                </td>
                                <td>
                                    <b><?= number_format($product['t_price'] * $product['t_quantity'], 0, ',', '.').' '.Yii::t('app', 'currency') ?></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h2>
                    <i class="fa fa-truck" aria-hidden="true"></i>
                    <b>Lịch sử giao hàng</b>
                </h2>
                <p>
                    Giao Hàng Tiết Kiệm | Mã Vận Đơn. S14268.MT10.D16.67192985
                </p>
                <div class="infor-nguoigiao">
                    <p>Người giao hàng: Nguyễn Việt Hưng</p>
                    <p>841284067479</p>
                    <p>
                        Bưu điện Phước Sơn huyện Tuy Phước tỉnh Bình Định, Xã Phước Sơn, Huyện Tuy Phước, Bình Định
                    </p>
                    <ul>
                        <li class="active">
                            <p>
                                <span>12:34 12-03-2018</span> Đã đối soát
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Chưa đối soát
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Đã giao hàng / 
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Đã điều phối giao hàng / đang giao hàng
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Shipper báo đã lấy hàng
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Đã lấy hàng / đã nhập kho
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Đã điều phối lấy hàng / đang lấy hàng
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Đã tiếp nhận
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Thông tin tới người bán
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Tạo đơn hàng
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>