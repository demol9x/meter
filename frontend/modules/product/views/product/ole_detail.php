<?php

use common\models\product\Product;
use common\components\ClaHost;
use common\components\ClaLid;

$images = Product::getImages($model->id);
?>



<div class="detail-product">
    <div class="container">
        <div class="row">
            <div class="ctn-detail">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 content">
                    <?php if (isset($images) && $images) { ?>
                        <div class="img-detail-product">
                            <?php if ($model['price_market'] > 0 && $model['price'] > 0) { ?>
                                <span class="icon-sale"><spam>Sale -<?= ClaLid::getDiscount($model['price_market'], $model['price']) ?>%</spam></span>
                            <?php } ?>
                            <div class="wrapper-images">
                                <?php
                                $i = 0;
                                foreach ($images as $image) {
                                    $i++;
                                    if ($i < 5) {
                                        ?>
                                        <div class="item-img-detail">
                                            <a href="<?= ClaHost::getImageHost(), $image['path'], $image['name'] ?>" rel="group1" class="fancybox">
                                                <img class="zoom-img" src="<?= ClaHost::getImageHost(), $image['path'], $image['name'] ?>" data-zoom-image="<?= ClaHost::getImageHost(), $image['path'], $image['name'] ?>">
                                            </a>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 rightSidebar">
                    <form id="form-add-to-cart" method="POST">
                        <div class="ctn-detail-product">
                            <h1><?= $model->name ?> </h1>
                            <span class="price-public">
                                <?= number_format($model->price, 0, ',', '.') ?> đ
                                <?php if ($model->price_market > 0) { ?>
                                    <spam><?= number_format($model->price_market, 0, ',', '.') ?> đ </spam>
                                <?php } ?>
                            </span>
                            <?php if ($model->short_description) { ?>
                                <p>
                                    <?= $model->short_description ?>
                                </p>
                            <?php } ?>
                            <p class="color">
                                <span>Mã sản phẩm:</span> #<?= $model->id ?>
                            </p>
                            <p class="color">
                                <span>Màu sắc:</span> <span id="wrap-color-select"><?= $first_color ?></span>
                            </p>
                            <?php if (isset($colors) && $colors) { ?>
                                <div class="select-color">
                                    <select onchange="changeColor(this)" style="width: 100px;" name="Shoppingcart[color]" id="_colorInput">
                                        <?php foreach ($colors as $color) { ?>
                                            <option value="<?= trim($color) ?>" data-color="<?= str_replace(' ', '', $color) ?>"><?= $color ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <br/>
                            <?php } ?>

                            <?php
                            if (isset($configurables) && $configurables) {
                                $i = 0;
                                foreach ($configurables as $color_code => $configs) {
                                    $i++;
                                    ?>
                                    <div style="display: <?= $i == 1 ? 'block' : 'none' ?>" class="size-select size-select-<?= str_replace(' ', '', $color_code) ?>">
                                        <?php foreach ($configs as $size) { ?>
                                            <label for="size-<?= $size['size'] . $i ?>" class="product-size _product-size <?= $size['out_of_stock'] ? 'disabled _disabled' : '' ?>" data-sku="<?= $size['size'] ?>">
                                                <input type="radio" value="<?= $size['size'] ?>" name="Shoppingcart[size]" id="size-<?= $size['size'] . $i ?>" <?= $size['out_of_stock'] ? 'disabled="disabled"' : '' ?> class="_sizeInput">
                                                <span class="size-name" title="<?= $size['size'] ?>"><?= $size['size'] ?></span>
                                            </label>
                                        <?php } ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <input type="hidden" name="Shoppingcart[product_id]" value="<?= $model['id'] ?>" />
                            <br>
                            <?php if ($model['status'] == ClaLid::STATUS_ACTIVED) { ?>
                                <a style="width: 216px;" class="btn btn-success btn-lg" onclick="addtocart(this)" href="javascript:void(0)" data-href="<?= yii\helpers\Url::to(['/product/shoppingcart/add-cart', 'id' => $model['id']]) ?>">
                                    <i class="fa fa-fw fa-shopping-cart"></i>
                                    Thêm vào giỏ hàng
                                </a>
                            <?php } else { ?>
                                <a style="width: 266px;" class="btn btn-warning btn-lg" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-shopping-cart"></i>
                                    Sản phẩm tạm hết hàng
                                </a>
                            <?php } ?>
                            <br>
                            <br>
                            <a style="width: 216px;" href="https://www.facebook.com/vebiz.vn" target="_blank" class="btn btn-primary btn-lg">
                                <i class="fa fa-fw fa-facebook"></i>
                                Chat với shop
                            </a>
                            <br>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    String.prototype.replaceAll = function (search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };

    function changeColor(_this) {
        var color = $(_this).val();
        $('#wrap-color-select').text(color);
        color = color.replaceAll(' ', '');
        $('.size-select').hide();
        $('.size-select-' + color).show();
        var html = $("body").data(color);
        if (html) {
            $('.wrapper-images').html(html);
            $(".zoom-img").ezPlus({
                zoomType: 'inner',
                cursor: 'crosshair',
                scrollZoom: true
            });
        } else {
            $.getJSON(
                '<?= yii\helpers\Url::to(['/product/product/get-images']) ?>',
                {color: color, id: <?= $model->id ?>},
                function (data) {
                    if (data.code == 200) {
                        $("body").data(color, data.html);
                        $('.wrapper-images').html(data.html);
                        $(".zoom-img").ezPlus({
                            zoomType: 'inner',
                            cursor: 'crosshair',
                            scrollZoom: true
                        });
                    }
                }
            );
        }
    }

    function addtocart(_this) {
        var color = $('#_colorInput').val();
        var size = $('._sizeInput:checked').val();
        var url = $(_this).attr('data-href');
        if (color && size) {
            url = url + '&color=' + color + '&size=' + size;
            location.href = url;
        } else {
            alert('Bạn phải chọn kích cỡ');
            return false;
        }
    }
</script>


<div class="detail-product-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="name-product">
                    <h2><a href="">Sản phẩm mẫu</a></h2>
                </div>
                <div class="img-detail-product">
                    <div class="app-figure" id="zoom-fig">
                        <div class="big-img">
                            <a id="Zoom-1" class="MagicZoom" data-options="selectorTrigger: hover; transitionEffect: false;zoomDistance: 20;zoomWidth:520px; zoomHeight:500px;variableZoom: true" title="Show your product in stunning detail with Magic Zoom Plus." href="images/ring1.jpg" >
                                <img src="images/ring1.jpg" alt=""/>
                            </a>
                            <spam class="discout-price">-10%</spam>
                        </div>
                        <div class="thumb-img">
                            <div id="owl-detail" class="selectors">
                                <a data-zoom-id="Zoom-1" href="images/ring1.jpg"
                                   data-image="images/ring1.jpg">
                                    <img src="images/ring1.jpg"/>
                                </a>
                                <a data-zoom-id="Zoom-1" href="images/ring2.jpg"
                                   data-image="images/ring2.jpg" >
                                    <img src="images/ring2.jpg"/>
                                </a>
                                <a data-zoom-id="Zoom-1" href="images/ring3.jpg"
                                   data-image="images/ring3.jpg" >
                                    <img src="images/ring3.jpg"/>
                                </a>
                                <a data-zoom-id="Zoom-1" href="images/ring4.jpg"
                                   data-image="images/ring4.jpg" >
                                    <img src="images/ring4.jpg"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="title-detail-product">
                    <div class="item-price-product">
                        <span>1.900.000 VNĐ </span>
                        <p>1.800.000 VNĐ</p>
                    </div>
                    <div class="option-product-detail">
                        <div class="item-option-product-detail">
                            <div class="title-ring-size">
                                <img src="images/item-detail.png" alt="">
                                <label for="">ring size</label>
                            </div>
                            <select name="" id="">
                                <option value="xl">XL</option>
                                <option value="xl">L</option>
                                <option value="xl">M</option>
                                <option value="xl">S</option>
                                <option value="xl">XS</option>
                            </select>
                        </div>
                        <div class="item-option-product-detail">
                            <div class="title-ring-size">
                                <img src="images/item-detail2.png" alt="">
                                <label for="">Carat Weight</label>
                            </div>
                            <select name="" id="">
                                <option value="xl">1 kg</option>
                                <option value="xl">2 kg</option>
                                <option value="xl">3 kg</option>
                                <option value="xl">4 kg</option>
                                <option value="xl">5 kg</option>
                            </select>
                        </div>
                        <div class="item-option-product-detail">
                            <div class="title-ring-size">
                                <img src="images/item-detail3.png" alt="">
                                <label for="">Center stone</label>
                            </div>
                            <select name="" id="">
                                <option value="xl">Kim cương</option>
                                <option value="xl">Đá quý</option>
                                <option value="xl">Ngọc</option>
                            </select>
                        </div>
                        <div class="item-option-product-detail">
                            <div class="title-ring-size">
                                <img src="images/item-detail4.png" alt="">
                                <label for="">Stones</label>
                            </div>
                            <select name="" id="">
                                <option value="xl">Kim cương</option>
                                <option value="xl">Đá quý</option>
                                <option value="xl">Ngọc</option>
                            </select>
                        </div>
                        <div class="item-option-product-detail">
                            <div class="title-ring-size">
                                <img src="images/item-detail5.png" alt="">
                                <label for="">Warranty</label>
                            </div>
                            <select name="" id="">
                                <option value="xl">1 năm</option>
                                <option value="xl">2 năm</option>
                                <option value="xl">3 năm</option>
                                <option value="xl">4 năm</option>
                                <option value="xl">5 năm</option>
                            </select>
                        </div>
                        <div class="item-option-product-detail">
                            <div class="title-ring-size">
                                <img src="images/item-detail.png" alt="">
                                <label for="">Engraving</label>
                            </div>
                            <select name="" id="">
                                <option value="xl">Kim cương</option>
                                <option value="xl">Đá quý</option>
                                <option value="xl">Ngọc</option>
                            </select>
                        </div>
                        <div class="addcart-detail-product">
                            <a class="btn-add-cart hvr-float-shadow" href=""><img src="images/bag-detail.png" alt="">ADD to bag</a>
                        </div>
                        <div class="view-detaill-more">
                            <a class="hvr-float-shadow" href="">View product details</a>
                        </div>
                        <div class="list-box-social">
                            <div class="item-social-detail">
                                <a class="hvr-float-shadow" href="">Add to my wishlist</a>
                            </div>
                            <div class="item-social-detail">
                                <a class="hvr-float-shadow" href="">Add to compare</a>
                            </div>
                            <div class="item-social-detail">
                                <p  class="hvr-float-shadow">
                                    <a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1025 </a>
                                    <a href=""><i class="fa fa-share" aria-hidden="true"></i> 346 </a>
                                </p>
                            </div>
                            <div class="item-social-detail">
                                <a class="hvr-float-shadow" href=""><img src="images/icon-commnet.png" alt="">Live chat</a>
                            </div>
                            <div class="item-social-detail">
                                <a class="hvr-float-shadow" href="tel:091 205 0231"><img src="images/icon-phone.png" alt="">091 205 0231</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cate-product-trangsuc" style="background: #fff; border-top: 1px solid #d7d7d7;">
                <div class="title-cate-product">
                    <h2><a href="">Phụ kiện mua cùng sản phẩm này</a></h2>
                </div>
                <div class="owl-product-trangsuc">
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cate-product-trangsuc" style="background: #fff; border-top: 1px solid #d7d7d7;">
                <div class="title-cate-product">
                    <h2><a href="">Có thể bạn cũng thích</a></h2>
                </div>
                <div class="owl-product-trangsuc">
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="br-logo">
                    <img src="images/icon-logo.png" alt="">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="infor-detail-product">
                    <div class="ctn-detail-product">
                        <div class="ctn-left-detail">
                            <h2>Mô Tả Sản Phẩm </h2>
                            <p>
                                Coupling a blended linen construction with tailored style, the River Island HR Jasper Blazer will imprint a touch of dapper charm into your after-dark wardrobe. Our model is wearing a size medium blazer, and usually takes a size medium/38L shirt. He is 6’2 1/2” (189 cm) tall with a 38” (96 cm) chest and a 31” (78 cm) waist.
                            </p>
                            <ul>
                                <li>
                                    <p>Length: 74cm</p>
                                </li>
                                <li>
                                    <p>Regular fit</p>
                                </li>
                                <li>
                                    <p>Notched lapels</p>
                                </li>
                                <li>
                                    <p>Twin button front fastening</p>
                                </li>
                                <li>
                                    <p>Front patch pockets; chest pocket</p>
                                </li>
                                <li>
                                    <p>Internal pockets</p>
                                </li>
                                <li>
                                    <p>Centre-back vent</p>
                                </li>
                                <li>
                                    <p>Please refer to the garment for care instructions.</p>
                                </li>
                                <li>
                                    <p>Material: Outer: 50% Linen & 50% Polyamide; Body Lining: 100% Cotton; </p>
                                </li>
                            </ul>
                            <div class="table-attribute-detail">
                                <h2>Engagement Ring Information</h2>
                                <div class="row">
                                    <div class="item-attribute-detail">
                                        <p>
                                            Style number
                                            <span>D1235</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Metal
                                            <span>14k White gold</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Stones
                                            <span>Diamond</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Gender
                                            <span>Women</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Style number
                                            <span>D1235</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Metal
                                            <span>14k White gold</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Stones
                                            <span>Diamond</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Gender
                                            <span>Women</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Style number
                                            <span>D1235</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Metal
                                            <span>14k White gold</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Stones
                                            <span>Diamond</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Gender
                                            <span>Women</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Style number
                                            <span>D1235</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Metal
                                            <span>14k White gold</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Stones
                                            <span>Diamond</span>
                                        </p>
                                    </div>
                                    <div class="item-attribute-detail">
                                        <p>
                                            Gender
                                            <span>Women</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="review-product">
                <div class="title-cate-product">
                    <h2><a href="">Item Reviews</a></h2>
                </div>
                <div class="rating-box  clearfix">
                    <div class="rating-box-summary summary">
                        <div class="summary-heading">Đánh giá trung bình</div>
                        <div class="summary-subheading">(Có 0 lượt đánh giá)</div>
                        <div class="summary-rating">
                            <div class="stars">
                                <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                                <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                                <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                                <span class="stars-star star star-off"><i class="fa fa-star"></i></span>
                                <span class="stars-star star star-off"><i class="fa fa-star"></i></span>
                            </div>
                        </div>

                        <div class="summary-rating-number">0</div>
                    </div>

                    <div class="rating-box-details">
                        <div class="rating-row rrow rrow-5">
                            <div class="rrow-label">
                                <span class="hidden-xs hidden-sm">Rất tốt</span><span class="visible-xs visible-sm">5 sao</span>
                            </div>
                            <div class="rrow-percent">
                                <div class="progress-bar progress-bar--5" data-percent="0">
                                    <div class="progress-bar-inner" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="rrow-counting">
                                0 </div>
                            <div class="rrow-descr">
                                đánh giá
                            </div>
                        </div>
                        <div class="rating-row rrow rrow-4">
                            <div class="rrow-label">
                                <span class="hidden-xs hidden-sm">Tốt</span><span class="visible-xs visible-sm">4 sao</span>
                            </div>
                            <div class="rrow-percent">
                                <div class="progress-bar progress-bar-5" data-percent="0">
                                    <div class="progress-bar-inner" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="rrow-counting">
                                0 </div>
                            <div class="rrow-descr">
                                đánh giá
                            </div>
                        </div>
                        <div class="rating-row rrow rrow-3">
                            <div class="rrow-label">
                                <span class="hidden-xs hidden-sm">Trung bình</span><span class="visible-xs visible-sm">3 sao</span>
                            </div>
                            <div class="rrow-percent">
                                <div class="progress-bar progress-bar-5" data-percent="0">
                                    <div class="progress-bar-inner" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="rrow-counting">
                                0 </div>
                            <div class="rrow-descr">
                                đánh giá
                            </div>
                        </div>
                        <div class="rating-row rrow rrow-2">
                            <div class="rrow-label">
                                <span class="hidden-xs hidden-sm">Không tốt</span><span class="visible-xs visible-sm">2 sao</span>
                            </div>
                            <div class="rrow-percent">
                                <div class="progress-bar progress-bar-5" data-percent="0">
                                    <div class="progress-bar-inner" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="rrow-counting">
                                0 </div>
                            <div class="rrow-descr">
                                đánh giá
                            </div>
                        </div>
                        <div class="rating-row rrow rrow-1">
                            <div class="rrow-label">
                                <span class="hidden-xs hidden-sm">Rất tệ</span><span class="visible-xs visible-sm">1 sao</span>
                            </div>
                            <div class="rrow-percent">
                                <div class="progress-bar progress-bar-5" data-percent="0">
                                    <div class="progress-bar-inner" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="rrow-counting">
                                0 </div>
                            <div class="rrow-descr">
                                đánh giá
                            </div>
                        </div>
                    </div>
                    <div class="btn-send-review hvr-float-shadow">
                        <a class="open-popup-link" href="#review-product-popup">Write a review</a>
                    </div>
                </div>
            </div>
            <div class="comment-box-user">
                <div class="item-user-comment">
                    <div class="img-user-comment">
                        <img src="images/testimonial1.jpg" alt="">
                        <h2>Lion messi</h2>
                        <span>From Chile</span>
                    </div>
                    <div class="content-user-comment">
                        <div class="rattings-star stars">
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-off"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-off"><i class="fa fa-star"></i></span>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto dolore facilis quo deserunt, rerum officiis, pariatur ipsa fugit nobis, ipsam natus totam. Dolore officiis, deleniti est hic provident nisi.
                        </p>
                    </div>
                </div>
                <div class="item-user-comment">
                    <div class="img-user-comment">
                        <img src="images/testimonial-image1.jpg" alt="">
                        <h2>Lion messi</h2>
                        <span>From Chile</span>
                    </div>
                    <div class="content-user-comment">
                        <div class="rattings-star stars">
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-off"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-off"><i class="fa fa-star"></i></span>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto dolore facilis quo deserunt, rerum officiis, pariatur ipsa fugit nobis, ipsam natus totam. Dolore officiis, deleniti est hic provident nisi.
                        </p>
                    </div>
                </div>
                <div class="item-user-comment">
                    <div class="img-user-comment">
                        <img src="images/testimonial1.jpg" alt="">
                        <h2>Lion messi</h2>
                        <span>From Chile</span>
                    </div>
                    <div class="content-user-comment">
                        <div class="rattings-star stars">
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-on"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-off"><i class="fa fa-star"></i></span>
                            <span class="stars-star star star-off"><i class="fa fa-star"></i></span>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto dolore facilis quo deserunt, rerum officiis, pariatur ipsa fugit nobis, ipsam natus totam. Dolore officiis, deleniti est hic provident nisi.
                        </p>
                    </div>
                </div>
                <div class="paginate">
                    <ul class="pagination" id="yw0">
                        <li class="first hidden"><a href="#">Trang đầu</a></li>
                        <li class="previous hidden"><a href="#">«</a></li>
                        <li class="page active"><a href="#">1</a></li>
                        <li class="page"><a href="#">2</a></li>
                        <li class="page"><a href="#">3</a></li>
                        <li class="page"><a href="#">4</a></li>
                        <li class="page"><a href="#">5</a></li>
                        <li class="page"><a href="#">6</a></li>
                        <li class="page"><a href="#">7</a></li>
                        <li class="page"><a href="#">8</a></li>
                        <li class="next"><a href="#">»</a></li>
                        <li class="last"><a href="#">Trang cuối</a></li>
                    </ul>
                </div>
            </div>
            <div class="cate-product-trangsuc" style="background: #fff;">
                <div class="title-cate-product">
                    <h2><a href="">Sản phẩm bạn vừa xem</a></h2>
                </div>
                <div class="owl-product-trangsuc">
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                    <div class="item-product-trangsuc">
                        <div class="img-product-trangsuc fix-height-auto">
                            <a href="">
                                <img class="img-load-1" src="images/img-1.jpg" alt="">
                                <img class="img-load-2" src="images/img-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-product-trangsuc">
                            <h3>
                                <a href="">Vòng vàng 18k phú quý</a>
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                            <a href="" class="btn-view-detail hvr-float-shadow">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


