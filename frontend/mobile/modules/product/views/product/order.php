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
                    <i class=""><i class="fa fa-check-circle" aria-hidden="true"></i> Đơn hàng mới</i>
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
