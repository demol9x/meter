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
                    <b>L???ch s??? giao h??ng</b>
                </h2>
                <p>
                    Giao H??ng Ti???t Ki???m | M?? V???n ????n. S14268.MT10.D16.67192985
                </p>
                <div class="infor-nguoigiao">
                    <p>Ng?????i giao h??ng: Nguy???n Vi???t H??ng</p>
                    <p>841284067479</p>
                    <p>
                        B??u ??i???n Ph?????c S??n huy???n Tuy Ph?????c t???nh B??nh ?????nh, X?? Ph?????c S??n, Huy???n Tuy Ph?????c, B??nh ?????nh
                    </p>
                    <ul>
                        <li class="active">
                            <p>
                                <span>12:34 12-03-2018</span> ???? ?????i so??t
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Ch??a ?????i so??t
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> ???? giao h??ng / 
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> ???? ??i???u ph???i giao h??ng / ??ang giao h??ng
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Shipper b??o ???? l???y h??ng
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> ???? l???y h??ng / ???? nh???p kho
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> ???? ??i???u ph???i l???y h??ng / ??ang l???y h??ng
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> ???? ti???p nh???n
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> Th??ng tin t???i ng?????i b??n
                            </p>
                        </li>
                        <li>
                            <p>
                                <span>12:34 12-03-2018</span> T???o ????n h??ng
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>