<?php

use  common\components\ClaHost;
use common\models\product\ProductAttribute;
use common\models\product\ProductAttributeItem;
use common\models\product\ProductVariables;
use yii\helpers\Url;

if (isset($attributes) && $attributes) {
    $product_attr_varable = ProductVariables::getVarable(['default' => 1, 'product_id' => $model->id]);
    $isset_vairable = ProductVariables::getVarable(['product_id' => $model->id]);
    if ($product_attr_varable) {
        $product_attr_varable['key'] = json_decode($product_attr_varable['key']); //
        $model->price = (isset($product_attr_varable['price']) && $product_attr_varable['price']) ? $product_attr_varable['price'] : 0; //Ưu tiên giá của biến thể mặc định
    }
}
$price_market = $model->price_market;
$text_price_market = number_format($model->price_market, 0, ',', '.') . Yii::t('app', 'currency');
$price = $model->price;
$text_price = number_format($model->price, 0, ',', '.') . Yii::t('app', 'currency');
?>
<style>
    .content-category {
        height: 380px;
        overflow: hidden;
        position: relative;
        margin-bottom: 20px;
    }

    .main-content {
        height: 100%;
    }

    .content-category.active {
        height: 100%;
    }

    .hide-seo.active-btn {
        /* background-image:none; */
        /* height: 100px; */
        position: unset;
    }

    .hide-btn {
        display: none;
    }

    .btn-seo {
        height: 45px;
        width: 137px;
        display: inline-block;
        text-align: center;
        line-height: 30px;
        padding: 7px 15px;
        background-color: #289300;
        color: #fff;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        overflow: hidden;
    }
    .btn-seo span i{
        margin-left: 5px;
        transform: translateY(1px);
    }
    /* .btn-seo:hover {
    color: #2d7eaf;
    border: 2px solid #2d7eaf;
} */

    .hide-seo.active-btn .btn-seo .show-btn {
        display: none;
    }

    .hide-seo.active-btn .btn-seo .hide-btn {
        display: block;
    }

    .hide-seo {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9;
        padding: 10px 0;
        background: #FFF;
        /* background-image: linear-gradient(to bottom, transparent, rgba(99, 88, 66, .1)); */
        text-align: center;
    }

    .hide-seo.active-btn::after {
        display: none;
    }

    .hide-seo::after {
        content: '';
        position: absolute;
        bottom: 46px;
        left: 0;
        background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0)), to(#fff));
        background-image: -o-linear-gradient(rgba(255, 255, 255, 0), #fff);
        /* background-image: linear-gradient(rgba(255,255,255,0),#fff); */
        width: 100%;
        height: 9.375rem;
        display: block;
    }
</style>
<div class="site51_prodel_col12_chitietnhathau">
    <div class="container_fix">
        <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>
        <div class="pro_detail">
            <div class="detail_left wow fadeInLeft" data-wow-duration="3s" style="visibility: visible; animation-duration: 3s;">
                <div class="left_env">
                    <div class="slide_detail_on">
                        <?php if ((isset($videos) && $videos)) foreach ($videos as $video) { ?>
                            <div class="img_detail">
                                <a data-fancybox="gallery" href="<?= \common\components\ClaAll::getEmbedToLink($video) ?>">
                                    <img src="<?= ClaHost::getImageHost(), $model->avatar_path, 's800_800/', $model->avatar_name ?>" alt="<?= $model->name ?>">
                                    <div class="play-video"><i class="fas fa-play"></i></div>
                                </a>
                            </div>
                        <?php } ?>
                        <?php if ($model->avatar_path && $model->avatar_name) { ?>
                            <div class="img_detail">
                                <a data-fancybox="gallery" href="<?= ClaHost::getImageHost(), $model->avatar_path, $model->avatar_name ?>" data-image="<?= ClaHost::getImageHost(), $model->avatar_path, $model->avatar_name ?>">
                                    <img src="<?= ClaHost::getImageHost(), $model->avatar_path, 's800_800/', $model->avatar_name ?>" alt="<?= $model->name ?>" />
                                </a>
                            </div>
                        <?php } ?>
                        <?php
                        if ((isset($images) && $images)) { ?>
                            <?php foreach ($images as $img) { ?>
                                <div class="img_detail">
                                    <a data-fancybox="gallery" href="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>" data-image="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>">
                                        <img src="<?= ClaHost::getImageHost(), $img['path'], 's800_800/', $img['name'] ?>" alt="<?= $model->name ?>" />
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="slide_detail_in">
                        <?php if ((isset($videos) && $videos)) foreach ($videos as $video) { ?>
                            <div class="img_detail_1">
                                <a data-fancybox="gallery" href="<?= \common\components\ClaAll::getEmbedToLink($video) ?>">
                                    <img src="<?= ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name ?>" alt="<?= $model->name ?>">
                                    <div class="play-video"><i class="fas fa-play"></i></div>
                                </a>
                            </div>

                        <?php } ?>
                        <?php if ($model->avatar_path && $model->avatar_name) { ?>
                            <div class="img_detail_1">
                                <a data-fancybox="gallery" href="<?= ClaHost::getImageHost(), $model->avatar_path, $model->avatar_name ?>">
                                    <img src="<?= ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name ?>" alt="<?= $model->name ?>" />
                                </a>
                            </div>
                        <?php } ?>
                        <?php
                        if ((isset($images) && $images)) { ?>
                            <?php foreach ($images as $img) { ?>
                                <div class="img_detail_1">
                                    <a data-fancybox="gallery" href="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>" data-image="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>">
                                        <img src="<?= ClaHost::getImageHost(), $img['path'], 's100_100/', $img['name'] ?>" alt="<?= $model->name ?>" />
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="detail_right wow fadeInRight" data-wow-duration="3s" style="visibility: visible; animation-duration: 3s;">
                <div class="content">
                    <div class="title title_28">
                        <?= $model->name ?>
                    </div>
                    <div class="item-options">
                        <div class="star">
                            <div class="icon">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $model->rate) {
                                ?>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                    <?php } else if ($model->rate > (int)$model->rate && 1 + (int)$model->rate == $i) { ?>
                                        <i class="fa fa-star-half -o yellow" aria-hidden="true"></i>
                                    <?php } else { ?>
                                        <i class="fa fa-star -o yellow" aria-hidden="true"></i>
                                <?php }
                                } ?>
                            </div>
                            <span><?= $model->rate_count ? $model->rate_count : 0 ?></span>
                        </div>
                        <div class="description">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                            </svg>
                            <span class="content_16">Đã bán <?= $model->total_buy ?></span>
                        </div>
                    </div>
                </div>

                <div class="item-price-sale">
                    <div class="price">
                        <h4 class="title_36 price_custom"><?= $price ? $text_price . ($model['unit'] ? ' /' . $model['unit'] : '') : 'Liên hệ' ?></h4>
                        <div class="sale">
                            <?php if ($price_market) { ?>
                                <span class="content_16"><?= $text_price_market ?></span>
                                <?php if ($price_market > $price && $price > 0) { ?>
                                    <span class="content_16">-<?= \common\components\ClaLid::getDiscount($price_market, $price) ?>%</span>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php if ($model->short_description) { ?>
                    <p class="content_16"><span>Mô tả:</span> <?= $model->short_description ?></p>
                <?php } ?>
                <p class="content_16">
                    <span>Vận Chuyển: </span> <?= ($model->fee_ship) ? 'Miễn phí vận chuyển' : 'Liên hệ' ?>
                </p>
                <?php if ($model->note) { ?>
                    <?= $model->note ?>
                <?php } ?>
                <?php if (isset($attributes) && $attributes && isset($isset_vairable) && $isset_vairable) {
                ?>
                    <div class="">
                        <?php foreach ($attributes as $key => $attribute) {
                            $group_name = ProductAttribute::getName($key);
                            if ($group_name == 'Màu sắc') {
                        ?>
                                <div class="item-color psattr multi-select">
                                    <h5 class="content_16"><?= $group_name ?>:</h5>
                                    <div class="color-pro">
                                        <?php foreach ($attribute as $key2 => $valuex) {
                                            $attr = ProductAttributeItem::getItemByAttribute($valuex);
                                            $key_attr = $key . '~' . $valuex;
                                        ?>
                                            <label class="get_attr <?= ($product_attr_varable['key'] && in_array($key_attr, $product_attr_varable['key'])) ? 'active' : '' ?>" data="<?= $key_attr ?>">
                                                <input name="color" type="radio" value="<?= $key_attr ?>" <?= ($product_attr_varable['key'] && in_array($key_attr, $product_attr_varable['key'])) ? 'checked' : '' ?>>
                                                <div class="color" style="background: <?= $attr['value_option'] ?>"></div>
                                                <span class="content_16"><?= $attr['value'] ?></span>
                                            </label>
                                        <?php } ?>

                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="item-Size psattr multi-select">
                                    <h5 class="content_16"><?= $group_name ?>:</h5>
                                    <div class="Size-pro">
                                        <?php foreach ($attribute as $key2 => $valuex) {
                                            $attr = ProductAttributeItem::getItemByAttribute($valuex);
                                            $key_attr = $key . '~' . $valuex;
                                        ?>
                                            <label class="get_attr <?= ($product_attr_varable['key'] && in_array($key_attr, $product_attr_varable['key'])) ? 'active' : '' ?>" data="<?= $key_attr ?>">
                                                <input name="Size" type="radio" id="<?= $key_attr ?>" value="<?= $key_attr ?>" <?= ($product_attr_varable['key'] && in_array($key_attr, $product_attr_varable['key'])) ? 'checked' : '' ?>>
                                                <div class="size content_16"><?= $attr['value'] ?></div>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <input type="hidden" class="attr_vairable" value='<?= isset($product_attr_varable['id']) && $product_attr_varable['id'] ? $product_attr_varable['id'] : 0 ?>'>
                <?php } ?>
                <div class="item-justify">
                    <div class="quantity">
                        <h4 class="title3">Số lượng</h4>
                        <div class="custom custom-btn-numbers form-control">
                            <button onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty) && qty > 1 ) result.value--;return false;" class="btn-minus btn-cts" type="button">-
                            </button>
                            <div class="input">
                                <input type="text" min="<?= $model->quality_range ? $quality_range[0] : 1 ?>" title="<?= Yii::t('app', 'quality') ?>" value="<?= $model->quality_range ? $quality_range[0] : 1 ?>" maxlength="12" id="qty" name="quantity" class="qty input-text" oninput="validity.valid||(value='');">
                            </div>
                            <button onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty)) result.value++;return false;" class="btn-plus btn-cts" type="button">+
                            </button>
                        </div>
                    </div>
                    <div class="item-buy">
                        <a href="##" title="" class="butt content_16" id="btn_kiemtradonhang" <?= Yii::$app->user->getId() ? '' : 'onclick="logine(this)"' ?>>
                            <img src="<?= Yii::$app->homeUrl ?>images/cart.png" alt="icon">
                            Mua ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?= frontend\widgets\productRelation\ProductRelationWidget::widget([
            'product_id' => $model->id,
            'category_id' => $model->category_id,
            'limit' => 8,
            'title' => 'Thiết bị tương tự',
        ]) ?>
        <div class="pro_main">
            <div class="pro_flex_left">
                <div class="nav_menu">
                    <a id="scroll_load_1" href="#" class="nav_list active title_18">Mô tả</a>
                    <a id="scroll_load_2" href="#" class="nav_list title_18">thông số kỹ thuật</a>
                    <a id="scroll_load_3" href="#" class="nav_list title_18">Đánh giá</a>
                </div>
                <div id="pro_desc_list" class="pro_description">
                    <?php if ($model->description) {
                        $length_description = strlen($model->description);
                    ?>
                        <?= $model->description ?>
                        <?php if ($length_description >= 500) { ?>
                            <div class="button_position">
                                <a class="content_16 btn-animation">Xem thêm <i class="fas fa-chevron-down"></i></a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div id="pro_desc_list_1" class="pro_description_1">
                    <?php if ($model->specifications) {
                        $length_specifications = strlen($model->specifications);
                    ?>
                        <div class="pro_package">
                            <div class="pro_content">
                                <div class="content_text">
                                    <h3>thông số kỹ thuật</h3>
                                </div>
                            </div>
                            <div class="pro_flex">
                                <table>
                                    <tbody><tr>
                                        <td>Thương hiệu</td>
                                        <td>LIEBHERR</td>
                                    </tr>
                                    <tr>
                                        <td>Mẫu</td>
                                        <td>Cần cẩu di động</td>
                                    </tr>
                                    <tr>
                                        <td>Loại</td>
                                        <td>2009</td>
                                    </tr>
                                    <tr>
                                        <td>Năm sản xuất</td>
                                        <td>100 m</td>
                                    </tr>
                                    <tr>
                                        <td>Chiều cao nâng</td>
                                        <td>DT26589</td>
                                    </tr>
                                    <tr>
                                        <td>Machineryline ID</td>
                                        <td>1200 t</td>
                                    </tr>
                                    <tr>
                                        <td>Dung tích ở đầu cuối</td>
                                        <td>Tình trạngđã qua sử dụng</td>
                                    </tr>
                                    <tr>
                                        <td>Tình trạng</td>
                                        <td>HCCI</td>
                                    </tr>
                                    <tr>
                                        <td>Trụ sở chính</td>
                                        <td>Số 292 Ngõ Văn Chương, Phố Khâm Thiên, Phường Khâm Thiên, Quận Đống Đa, TP Hà Nội</td>
                                    </tr>
                                    <tr>
                                        <td>Tên Công ty</td>
                                        <td>CÔNG TY CỔ PHẦN ĐẦU TƯ XÂY DỰNG DÂN DỤNG HÀ NỘI</td>
                                    </tr>
                                    <tr>
                                        <td>Tên Công ty</td>
                                        <td>CÔNG TY CỔ PHẦN ĐẦU TƯ XÂY DỰNG DÂN DỤNG HÀ NỘI</td>
                                    </tr>
                                    <tr>
                                        <td>Tên tiếng Anh</td>
                                        <td>HANOI CIVIL CONSTRUCTION INVESTMENT JOINT STOCK COMPANY</td>
                                    </tr>
                                    <tr>
                                        <td>Tên viết tắt</td>
                                        <td>HCCI</td>
                                    </tr>
                                    <tr>
                                        <td>Trụ sở chính</td>
                                        <td>Số 292 Ngõ Văn Chương, Phố Khâm Thiên, Phường Khâm Thiên, Quận Đống Đa, TP Hà Nội</td>
                                    </tr>
                                    <tr>
                                        <td>Tên Công ty</td>
                                        <td>CÔNG TY CỔ PHẦN ĐẦU TƯ XÂY DỰNG DÂN DỤNG HÀ NỘI</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if (isset($hot_package) && $hot_package) { ?>
                <?php
                echo frontend\widgets\html\HtmlWidget::widget([
                    'input' => [
                        'hot_package' => $hot_package,
                        'title' => 'Nổi bật',
                    ],
                    'view' => 'view_package1'
                ]);
                ?>
            <?php } ?>
        </div>

        <?=
        \frontend\widgets\rating\RatingWidget::widget([
            'view' => 'view',
            'type' => \common\models\rating\Rating::TYPE_PRODUCT,
            'object_id' => $model->id,
            'title' => 'Đánh giá thiết bị',
            'rating' => [
                'rate' => $model->rate,
                'rate_count' => $model->rate_count
            ]
        ])
        ?>

        <?php if (isset($users) && $users) { ?>
            <?php
            echo frontend\widgets\html\HtmlWidget::widget([
                'input' => [
                    'users' => $users,
                    'title' => 'THIẾT BỊ CÔNG NGHIỆP KHÁC',
                ],
                'view' => 'view_user1'
            ]);
            ?>
        <?php } ?>

    </div>
</div>


<div class="site51_popup_col9_kiemtradonhang" id="kiemtradonhang">
</div>
<script>
    <?php if (Yii::$app->user->getId()) { ?>
        $('#btn_kiemtradonhang').click(function() {
            var price = $('.price_custom').html;
            if (price === 'Liên hệ') {
                window.location.href = "<?= Url::to('/site/contact') ?>";
            }
            var href = '/product/shoppingcart/add-cart?id=<?= $model->id ?>&quantity=' + $('#qty').val() + '&var_id=' + $('.attr_vairable').val();
            loadAjax(href, {
                ajax: 1
            }, $('#kiemtradonhang'));
            $('#kiemtradonhang').show();
            return false;
        });
    <?php } ?>
    $('.multi-select label').click(function() {
        $(this).closest('.multi-select').find('label').removeClass('active');
        $(this).addClass('active');
        $(this).closest('.psattr').attr("data", $(this).attr("data"));
        psattr = $('.psattr .get_attr.active');
        var data = new Array();
        var i = 0;
        psattr.each(function() {
            data[i++] = $(this).attr("data");
        });

        $.ajax({
            url: '<?= Url::to('/product/product/get-variable') ?>',
            data: {
                product_id: <?= $model->id ?>,
                data: data
            },
            type: 'GET',
            success: function(result) {
                if (result.code === 200) {
                    $('.attr_vairable').val(result.var_id);
                    $('.price_custom').html(result.price);
                }
            }
        });
    })
    // xem thêm
    $(document).ready(function() {
        $(".btn-seo").click(function() {
            $(".content-category").toggleClass("active");
            $(".hide-seo").toggleClass("active-btn");
        });
        var height = $(".seo-content").height();
        console.log(height);
        if (height <= 380) {
            $(".hide-seo").css("display", "none");
            $(".content-category").css("height", "auto");
        } else {
            console.log("aaaaaaaaaaaaaaaa");
            $(".hide-seo").css("display", "block");
        }

    });
</script>