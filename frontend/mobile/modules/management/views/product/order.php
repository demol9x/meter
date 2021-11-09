<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="images/ico-hoso.png" alt=""> Thông báo đơn hàng
        </h2>
    </div>
    <div class="nav-donhang">
        <ul class="tab-menu">
            <li class="active"> <a id="1" href="javascript:void(0);">Đơn hàng mới</a> </li>
            <li>
                <a id="2" href="javascript:void(0);">Chờ lấy hàng</a>
            </li>
            <li>
                <a id="3" href="javascript:void(0);">Đang giao</a>
            </li>
            <li>
                <a id="4" href="javascript:void(0);">Đã giao</a>
            </li>
            <li>
                <a id="5" href="javascript:void(0);">Đã hủy</a>
            </li>
        </ul>
    </div>
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-1" style="display: block;">
    <?php if($products) foreach ($products as $product) { 
        $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
        $s_url = Url::to(['/shop/shop/detail', 'id' => $product['shop_id'], 'alias' =>$product['s_alias']]);
        ?>
        <div class="item-info-donhang">
            <div class="title">
                <div class="img">
                    <a href="<?= $s_url ?>">
                        <img src="<?= ClaHost::getImageHost(), $product['s_avatar_path'], $product['s_avatar_name'] ?>" alt="<?= $product['s_name'] ?>">
                        <?= $product['s_name'] ?>
                    </a>
                </div>
                <div class="btn-view-shop">
                    <a href="<?=$s_url ?>"><i class="fa fa-home"></i><?= Yii::t('app', 'view_shop') ?></a>
                </div>
                <div class="code-donhang">
                    <p class="success-order">
                        <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> <?= Yii::t('app', 'new_order') ?></i>
                    </p>
                </div>
            </div>
            <div class="table-donhang table-shop">
                <table>
                    <tbody>
                        <tr>
                            <td width="100">
                                <div class="img"><a href="<?= $url ?>"><img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>" alt="<?= $product['name'] ?>"></a></div>
                            </td>
                            <td class="vertical-top" width="250">
                                <h2><a href="<?= $url ?>"><?= $product['name'] ?></a></h2>
                                <span class="quantity">x<?= $product['t_quantity'] ?></span>
                            </td>
                            <td>
                                <p class="price-donhang"><?= number_format($product['t_price'], 0, ',', '.').' '.Yii::t('app', 'currency') ?></p>
                            </td>
                            <td width="250" class="txt-right">
                                <div class="btn-table-donhang">
                                    <a class="open-popup-link open-popup-link-b1" href="#donhang-chuanbi0" data-id="<?= $product['t_id'] ?>" data-name="<?= $product['name'] ?>" data-time="<?= date('d/m/Y', $product['t_created_at']) ?>" >Chuẩn bị đơn hàng</a>
                                    <span>Ngày đặt hàng: <?= date('d/m/Y', $product['t_created_at']) ?></span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-2" style="display: none;">
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
            <div class="code-donhang">
                <p>
                    Đơn hàng: #0123456 
                </p>
                <span>|</span>
                <p>
                    ngày 17/03/2018
                </p>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top" width="250">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                        </td>
                        <td>
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                        <td width="250" class="txt-right">
                            <div class="btn-table-donhang">
                                <a class="open-popup-link" href="#donhang-chuanbi1">Chuẩn bị đơn hàng</a>
                                <span>Trước 3h chiều ngày 17/03/2018</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-3" style="display: none;">
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                            <p>
                                Nhận sản phẩm trước: <b>22/03/2018</b>
                            </p>
                        </td>
                        <td width="250" class="txt-right">
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bottom-info-donhang">
            <div class="btn-table-donhang">
                <a href="">Đã nhận hàng</a>
                <a href="" class="no-background">Chi tiết đơn hàng</a>
                <a href="" class="no-background">Trả hàng/hoàn tiền</a>
            </div>
            <b class="price">Tổng đơn hàng: 2.180.000</b>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                            <p>
                                Nhận sản phẩm trước: <b>22/03/2018</b>
                            </p>
                        </td>
                        <td width="250" class="txt-right">
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bottom-info-donhang">
            <div class="btn-table-donhang">
                <a href="">Đã nhận hàng</a>
                <a href="" class="no-background">Chi tiết đơn hàng</a>
                <a href="" class="no-background">Trả hàng/hoàn tiền</a>
            </div>
            <b class="price">Tổng đơn hàng: 2.180.000</b>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                            <p>
                                Nhận sản phẩm trước: <b>22/03/2018</b>
                            </p>
                        </td>
                        <td width="250" class="txt-right">
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bottom-info-donhang">
            <div class="btn-table-donhang">
                <a href="">Đã nhận hàng</a>
                <a href="" class="no-background">Chi tiết đơn hàng</a>
                <a href="" class="no-background">Trả hàng/hoàn tiền</a>
            </div>
            <b class="price">Tổng đơn hàng: 2.180.000</b>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                            <p>
                                Nhận sản phẩm trước: <b>22/03/2018</b>
                            </p>
                        </td>
                        <td width="250" class="txt-right">
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bottom-info-donhang">
            <div class="btn-table-donhang">
                <a href="">Đã nhận hàng</a>
                <a href="" class="no-background">Chi tiết đơn hàng</a>
                <a href="" class="no-background">Trả hàng/hoàn tiền</a>
            </div>
            <b class="price">Tổng đơn hàng: 2.180.000</b>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                            <p>
                                Nhận sản phẩm trước: <b>22/03/2018</b>
                            </p>
                        </td>
                        <td width="250" class="txt-right">
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bottom-info-donhang">
            <div class="btn-table-donhang">
                <a href="">Đã nhận hàng</a>
                <a href="" class="no-background">Chi tiết đơn hàng</a>
                <a href="" class="no-background">Trả hàng/hoàn tiền</a>
            </div>
            <b class="price">Tổng đơn hàng: 2.180.000</b>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                            <p>
                                Nhận sản phẩm trước: <b>22/03/2018</b>
                            </p>
                        </td>
                        <td width="250" class="txt-right">
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bottom-info-donhang">
            <div class="btn-table-donhang">
                <a href="">Đã nhận hàng</a>
                <a href="" class="no-background">Chi tiết đơn hàng</a>
                <a href="" class="no-background">Trả hàng/hoàn tiền</a>
            </div>
            <b class="price">Tổng đơn hàng: 2.180.000</b>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                            <p>
                                Nhận sản phẩm trước: <b>22/03/2018</b>
                            </p>
                        </td>
                        <td width="250" class="txt-right">
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bottom-info-donhang">
            <div class="btn-table-donhang">
                <a href="">Đã nhận hàng</a>
                <a href="" class="no-background">Chi tiết đơn hàng</a>
                <a href="" class="no-background">Trả hàng/hoàn tiền</a>
            </div>
            <b class="price">Tổng đơn hàng: 2.180.000</b>
        </div>
    </div>
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-4" style="display: none;">
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
            <div class="code-donhang">
                <p class="success-order">
                    <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> Đơn hàng đã giao</i>
                </p>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top" width="250">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                        </td>
                        <td>
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                        <td width="250" class="txt-right">
                            <div class="btn-table-donhang">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="open-popup-link" href="#donhang-review1">Đánh giá</a>
                                    </div>
                                    <div class="col-xs-12">
                                        <a class="open-popup-link no-background" href="#donhang-detail1" href="">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
            <div class="code-donhang">
                <p class="success-order">
                    <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> Đơn hàng đã giao</i>
                </p>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top" width="250">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                        </td>
                        <td>
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                        <td width="250" class="txt-right">
                            <div class="btn-table-donhang">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="open-popup-link" href="#donhang-review1">Đánh giá</a>
                                    </div>
                                    <div class="col-xs-12">
                                        <a class="open-popup-link no-background" href="#donhang-detail1" href="">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
            <div class="code-donhang">
                <p class="success-order">
                    <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> Đơn hàng đã giao</i>
                </p>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top" width="250">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                        </td>
                        <td>
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                        <td width="250" class="txt-right">
                            <div class="btn-table-donhang">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="open-popup-link" href="#donhang-review1">Đánh giá</a>
                                    </div>
                                    <div class="col-xs-12">
                                        <a class="open-popup-link no-background" href="#donhang-detail1" href="">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
            <div class="code-donhang">
                <p class="success-order">
                    <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> Đơn hàng đã giao</i>
                </p>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top" width="250">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                        </td>
                        <td>
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                        <td width="250" class="txt-right">
                            <div class="btn-table-donhang">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="open-popup-link" href="#donhang-review1">Đánh giá</a>
                                    </div>
                                    <div class="col-xs-12">
                                        <a class="open-popup-link no-background" href="#donhang-detail1" href="">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
            <div class="code-donhang">
                <p class="success-order">
                    <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> Đơn hàng đã giao</i>
                </p>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top" width="250">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                        </td>
                        <td>
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                        <td width="250" class="txt-right">
                            <div class="btn-table-donhang">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="open-popup-link" href="#donhang-review1">Đánh giá</a>
                                    </div>
                                    <div class="col-xs-12">
                                        <a class="open-popup-link no-background" href="#donhang-detail1" href="">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
            <div class="code-donhang">
                <p class="success-order">
                    <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> Đơn hàng đã giao</i>
                </p>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top" width="250">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                        </td>
                        <td>
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                        <td width="250" class="txt-right">
                            <div class="btn-table-donhang">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="open-popup-link" href="#donhang-review1">Đánh giá</a>
                                    </div>
                                    <div class="col-xs-12">
                                        <a class="open-popup-link no-background" href="#donhang-detail1" href="">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-5" style="display: none;">
    <div class="item-info-donhang">
        <div class="title">
            <div class="img">
                <a href="">
                    <img src="images/img-danhmuc8.png" alt="">
                    Nguyễn Việt Hưng
                </a>
            </div>
            <div class="btn-view-shop">
                <a href=""><i class="fa fa-home"></i>Xem shop</a>
            </div>
            <div class="code-donhang">
                <p class="delete-order">
                    <i class=""><i class="fa fa-times" aria-hidden="true"></i> Đơn hàng đã hủy</i>
                </p>
            </div>
        </div>
        <div class="table-donhang table-shop">
            <table>
                <tbody>
                    <tr>
                        <td width="100">
                            <div class="img"><img src="images/img-product1.png" alt=""></div>
                        </td>
                        <td class="vertical-top" width="250">
                            <h2><a href="">Trà chanh mật ong nhập khẩu Hàn Quốc lọ 500g</a></h2>
                            <span class="quantity">x20</span>
                        </td>
                        <td>
                            <p class="price-donhang">109.000 đ</p>
                        </td>
                        <td width="250" class="txt-right">
                            <div class="btn-table-donhang">
                                <a class="open-popup-link" href="#donhang-detail1">Chi tiết</a>
                                <span>Trước 3h chiều ngày 17/03/2018</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="donhang-review1" class="white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup">
                <h2>Đánh giá của bạn cho sản phẩm này</h2>
            </div>
            <div class="ctn-review-popup">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-product">
                            <div class="img">
                                <a href="">
                                    <img src="images/img-product1.png" alt="">
                                </a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Bầu hồ lô quả to loại 2,5kg tốt cho người huyết áp cao, mụn nhọt và rôm sảy</a>
                                </h2>
                                <p class="price">500.000 đ</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="star-area">
                            <span class="number">5/5</span>
                            <i class="fa fa-star yellow"></i>
                            <i class="fa fa-star yellow"></i>
                            <i class="fa fa-star yellow"></i>
                            <i class="fa fa-star yellow"></i>
                            <i class="fa fa-star yellow"></i>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                        <button>Gửi đánh giá</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="donhang-detail1" class="white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup">
                <h2>Chi tiết đơn hàng</h2>
            </div>
            <div class="ctn-popup">
                <div class="box-detail-order">
                    <h2>
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <b>Đơn hàng</b>
                        #012312512
                    </h2>
                    <div class="table-shop">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Khách hàng</p>
                                    </td>
                                    <td>
                                        <p>Nguyễn Việt Hưng</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Sản phẩm</p>
                                    </td>
                                    <td>
                                        <p>Bầu hồ lô quả loại to 2,5 kg tốt cho người huyết áp cao, mụn nhọt, rôm...</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Số lượng</p>
                                    </td>
                                    <td>
                                        <p>20 quả</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Ngày mua</p>
                                    </td>
                                    <td>
                                        <p>17/03/2018</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Thành tiền</p>
                                    </td>
                                    <td>
                                        <b>625.000 đ</b>
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
</div>
<div id="donhang-chuanbi1" class="white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup">
                <h2>Chuẩn bị đơn hàng</h2>
            </div>
            <div class="ctn-popup">
                <div class="box-detail-order">
                    <h2>
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <b>Đơn hàng</b>
                        #012312512
                    </h2>
                    <div class="table-shop">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Ngày</p>
                                    </td>
                                    <td>
                                        <p>17/03/2018</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Ghi chú</p>
                                    </td>
                                    <td>
                                        <p>Bầu hồ lô quả loại to 2,5 kg tốt cho người huyết áp cao, mụn nhọt, rôm...</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Địa chỉ</p>
                                    </td>
                                    <td>
                                        <p>
                                            Chung cư 335, Phòng B2T10 chung cư 335 Cầu Giấy, Hà Nội <a href="javascript:void(0);" class="open-fixed"><i class="fa fa-pencil"></i>Thay đổi</a>
                                        </p>
                                        <div class="form-fixed">
                                            <input type="text" placeholder="Sửa thông tin giao hàng">
                                            <a href=""><i class="fa fa-check"></i>Lưu lại</a>
                                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p>
                        Bạn không thể thay đổi ngày giao hàng, hãy chắc chắn hàng của bạn sẵn sàng để chuyển đi vào ngày này
                    </p>
                    <div class="btn-table-donhang">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <a href="">Chuẩn bị hàng</a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <a href="" class="no-background">Hủy đơn hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="donhang-chuanbi0" class="white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup">
                <h2>Chuyển hàng sang trạng thái chờ lấy hàng</h2>
            </div>
            <div class="ctn-popup">
                <div class="box-detail-order">
                    <h2>
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <b>Đơn hàng</b>
                        # <span id="b0-id">012312512</span>
                    </h2>
                    <div class="table-shop">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Ngày</p>
                                    </td>
                                    <td>
                                        <p id="b0-time">17/03/2018</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Ghi chú</p>
                                    </td>
                                    <td>
                                        <p id="b0-name">Bầu hồ lô quả loại to 2,5 kg tốt cho người huyết áp cao, mụn nhọt, rôm...</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-eb" width="150">
                                        <p>Địa chỉ</p>
                                    </td>
                                    <td>
                                        <p>
                                            <span id="b0-address">Chung cư 335, Phòng B2T10 chung cư 335 Cầu Giấy, Hà Nội</span> <a href="javascript:void(0);" class="open-fixed"><i class="fa fa-pencil"></i>Thay đổi</a>
                                        </p>
                                        <div class="form-fixed">
                                            <input type="text" placeholder="Sửa thông tin giao hàng">
                                            <a><i class="fa fa-check"></i>Lưu lại</a>
                                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p>
                        Bạn sẽ không thể chuyển trạng thái đơn hàng ngược lại. Vì vậy hãy chắc chắn đơn hàng bạn đã ở đúng trạng thái tiếp theo.
                    </p>
                    <div class="btn-table-donhang">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <a class="save-b0 click">Chuyển trạng thái</a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <a href="" class="no-background">Hủy đơn hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.open-popup-link-b1').click(function() {
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            var time = $(this).attr('data-time');
            $('#b0-name').html(name);
            $('#b0-id').html(id);
            $('#b0-time').html(time);
        });
        $('.save-b0').click(function () {
            alert(1);
            id = $('#b0-id').html();
            $.ajax({
            url: "<?= Url::to(['/management/order/update12']) ?>",
            data:{id: id},
            success: function(result){
               alert(result);
            }
        });
        })
    });

</script>