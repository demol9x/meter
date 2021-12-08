<link rel="stylesheet" href="<?= yii::$app->homeUrl?>css/quanlysanpham.css">

<div class="item_right">
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
            <div class="count-product content_14">12 Sản phẩm</div>
            <ul class="manager-nav tab-menu">
                <li class="active">
                    <a id="1" class="content_14" href="javascript:void(0);">Tất cả</a>
                </li>
                <li>
                    <a id="2" load="1" class="content_14" href="javascript:void(0);">Còn hàng</a>
                </li>
                <li>
                    <a id="3" load="1" class="content_14" href="javascript:void(0);">Hết hàng</a>
                </li>
            </ul>
        </div>
        <div class="filter-manager-product">
            <div class="search-filter">
                <form action="">
                    <input type="text" name="keyword" value="" class="content_14" placeholder="Tìm kiếm sản phẩm">
                    <button><i class="fa fa-search"></i></button>
                </form>
                <select id="select-order">
                    <option class="content_14" value="">Sắp xếp theo</option>
                    <option class="content_14" value="name">Từ A - Z</option>
                    <option class="content_14" value="name DESC">Từ Z - A</option>
                    <option class="content_14" value="price DESC">Giá từ cao - thấp</option>
                    <option class="content_14" value="price">Giá từ thấp - cao</option>
                </select>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#select-order').change(function() {
                        var order = $(this).val();
                        document.location.href = '/quan-ly-san-pham.html?order=' + order;
                    });
                });
            </script>
        </div>
        <div class="list-product-manager section-product">
            <div class="row-5 product-in-store tab-menu-read tab-menu-read-1 tab-active" style="display: block;" id="tab-product-1">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" style="height: 0.3384px;">
                            </a>
                        </div>
                        <h3>
                        </h3>
                        <p class="content_14 price">
                            <del>300.000đ</del>200.000đ/kg
                        </p>
                        <div class="review">
                            <div class="star">
                                <i class="fa fa-star yellow"></i>
                                <i class="fa fa-star yellow"></i>
                                <i class="fa fa-star yellow"></i>
                                <i class="fa fa-star yellow"></i>
                                <i class="fa fa-star yellow"></i>
                                <span class="content_14">(50)</span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-manager">
                            <a href="">
                                <button>
                                    <span class="plus-circle"><i class="fa fa-plus"></i></span>
                                    <p class="content_14">Thêm sản phẩm mới</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="sản phẩm" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="sản phẩm">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="sản phẩm" class="content_14">sản phẩm</a>
                        </h3>
                        <p class="price content_14">
                            10.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="15168">
                            <button>
                                <a href=""><span class="solid-out-circle content_14" data="15168">Cập nhật</span></a>
                                <span class="solid-out-circle delete-produc content_14t" data="15168">Xóa</span>
                                <span class="solid-out-circle notselectedbt content_14">Chọn</span>
                                <span class="solid-out-circle do-not-product content_14" data="15168">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="paginate">
                </div>
            </div>
            <div class="row-5 product-in-store tab-menu-read tab-menu-read-2" style="display: none;" id="tab-product-2">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="paginate">
                </div>
            </div>
            <div class="row-5 product-in-store tab-menu-read tab-menu-read-3" style="display: none;" id="tab-product-3">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="item-product-inhome">
                        <div class="img">
                            <a href="" title="thit lợn 2" style="height: 0.3384px;">
                                <img src="asset/img/nhathau_pro.png" alt="thit lợn 2">
                            </a>
                        </div>
                        <h3>
                            <a href="" title="thit lợn 2">thit lợn 2</a>
                        </h3>
                        <p class="price">
                            1.000.000 đ </p>
                        <div class="review">
                            <div class="star">
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span class="fa fa-star yellow"></span>
                                <span></span>
                            </div>
                            <div class="wishlist">
                                <a href=""><img src="asset/img/tim.png" alt=""></a>
                            </div>
                            <div class="car-ship">
                                <i class="fa fa-truck"></i>
                            </div>
                        </div>
                        <div class="add-product-managers solid-out" data="14942">
                            <button>
                                <a href=""><span class="solid-out-circle" data="14942">Cập nhật</span></a>
                                <span class="solid-out-circle delete-product" data="14942">Xóa</span>
                                <span class="solid-out-circle notselectedbt">Chọn</span>
                                <span class="solid-out-circle do-not-product" data="14942">Còn hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="paginate">
                </div>
            </div>
        </div>
    </div>

</div>