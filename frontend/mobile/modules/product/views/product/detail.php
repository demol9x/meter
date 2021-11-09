<?php
date_default_timezone_set("Asia/Bangkok");

use yii\helpers\Url;
use common\models\product\Product;
use common\components\ClaHost;

$images = Product::getImages($model->id);
$siteinfo = common\components\ClaLid::getSiteinfo();
$check_register_product = 0;
if (!$model->status_quantity) {
    if (!($check_register_product = \common\models\product\ProductRegisterInfo::getCheck($model->id))) {
        $user = \common\models\User::findOne(Yii::$app->user->id);
    }
}
//quantity
$quality_range = explode(',', $model->quality_range);
$quantity_min = $model->getQuantityMin();
$quantity_max = $model->getQuantityMax();
$price_range = explode(',', $model->price_range);
$price_market = $model->getPriceMarket(1);
$text_price_market = $model->getPriceMarketText(1);
$price = $model->getPrice(1);
$text_price = $model->getPriceText(1);
$check = $model->checkInCart();
//promotion
$promotion = \common\models\promotion\Promotions::getPromotionNow();
if ($promotion) {
    $promotion_item = $model->getPromotionItemNow();
    if ($promotion_item) {
        $quantity_max = ($promotion_item->quantity - $promotion_item->quantity_selled) > 0 ? ($promotion_item->quantity - $promotion_item->quantity_selled) : $quantity_max;
        //thoi gian
        $list_time = explode(' ', $promotion->time_space);
        $hour_next = count($list_time) > 1 ? $promotion->getHourAfter($promotion->getHourNow()) : $promotion->enddate;
    } else {
        $promotion_item_after = $model->getPromotionItem();
    }
}
$certificate_ktx = '';
foreach ($certificates as $certificate) {
    if (isset($certificate_imgs[$certificate['id']])) {
        if ($certificate['id'] == 4) {
            $certificate_ktx = $certificate_imgs[$certificate['id']];
            break;
        }
    }
}
?>
<style type="text/css">
    .info-afffilate {
        color: red !important;
        clear: both;
        font-size: 13px !important;
        padding-top: 10px;
    }

    .table-shop table p span {
        font-size: 12px;
        text-decoration: line-through;
        color: #bebebe;
        display: inline-block;
        margin-left: 10px;
    }

    .open-video {
        cursor: pointer;
    }

    .big-img iframe {
        width: 100%;
        height: 100%;
    }

    .box-video {
        position: absolute;
        z-index: 0;
        width: 100%;
        height: 100%;
        left: 0px;
        top: 0px;
    }

    .view-certificate-img {
        float: right;
        list-style: none;
        margin-left: 10px;
        max-width: 30px;
        height: 30px;
        cursor: pointer;
    }

    .view-certificate-img img {
        max-height: 100%;
    }

    .title-detail-product .nice-select.transport-method .current:after {
        content: "<?= Yii::t('app', 'transport_method'); ?>:";
        position: absolute;
        left: 0px;
        top: -1px;
        line-height: 20px;
        white-space: nowrap;
        color: #232121;
    }

    svg {
        width: 20px;
        margin-right: 6px;
        position: absolute;
    }

    .text-left-svg {
        margin-left: 26px;
    }

    .clears {
        clear: both;
    }

    .promotion-after {
        font-size: 14px;
        font-weight: bold;
        display: inline-block;
        margin-top: 2px;
        margin-left: 4px;
        color: #17a349;
    }

    .promotion-after h {
        font-size: 25px;
        font-weight: bold;
        display: inline-block;
        margin-left: 4px;
        color: #17a349;
    }

    .box-infopro p {
        color: #17a349;
        font-size: 18px;
        text-transform: unset;
    }

    .address-ship.nice-selects {
        margin-top: -9px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('.open-video').click(function() {
            $('.box-video').css('z-index', '1');
            if ($('.box-video').find('iframe').attr('src') != $(this).attr('data')) {
                $('.box-video').find('iframe').attr('src', $(this).attr('data'));
            }
        });
        $('.open-image').click(function() {
            $('.box-video').css('z-index', '0');
            $('.box-video').find('iframe').attr('src', '');
        });
        $('.open-video').mouseenter(function() {
            $('.box-video').css('z-index', '1');
            if ($('.box-video').find('iframe').attr('src') != $(this).attr('data')) {
                $('.box-video').find('iframe').attr('src', $(this).attr('data'));
            }
        });
        $('.open-image').mouseenter(function() {
            $('.box-video').css('z-index', '0');
            $('.box-video').find('iframe').attr('src', '');
        });
    })

    function getCostTransport() {
        loadImgQR();
    }

    function loadImgQR() {
        var quantity = $('#qty').val();
        var product_id = '<?= $model->id ?>';
        var tranport_type = $('#input-transport').attr('data-id') ? $('#input-transport').attr('data-id') : 0;
        var shipfee = $('#fee-ship').attr('data-price') ? $('#fee-ship').attr('data-price') : 0;
        var province = $('#input-province').attr('data-provine') ? $('#input-province').attr('data-provine') : 0;
        var district = $('#input-province').attr('data-district') ? $('#input-province').attr('data-district') : 0;
        var address_id_from = $('#input-province-shop').attr('data-shop-address-id') ? $('#input-province-shop').attr('data-shop-address-id') : 0;
        loadAjaxPost('<?= Url::to(['/product/product/get-qr']) ?>', {
            product_id: product_id,
            quantity: quantity,
            tranport_type: tranport_type,
            shipfee: shipfee,
            province: province,
            district: district,
            address_id_from: address_id_from
        }, $('#img-qr'));
    }
</script>
<div class="detail-product-page">
    <div class="container">
        <div class="white-full">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    <div class="img-detail-product">
                        <div class="app-figure" id="zoom-fig">
                            <div style="max-height: 500px; overflow: hidden;">
                                <div class="big-img">
                                    <?php if ($price_market > $price && $price > 0) { ?>
                                        <span class="sale-label">-<?= \common\components\ClaLid::getDiscount($price_market, $price) ?>
                                            %</span>
                                    <?php } ?>
                                    <a id="Zoom-1" class="MagicZoom" data-options="selectorTrigger: hover; transitionEffect: false;zoomDistance: 20;zoomWidth:520px; zoomHeight:500px;variableZoom: true" title="Show your product in stunning detail with Magic Zoom Plus." href="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>">
                                        <img src="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>" />
                                    </a>
                                    <div class="box-video">
                                        <iframe width="100%" style="height: 100%; max-height:500px" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $videos = explode(',.,', $model->videos);
                            if ((isset($images) && $images) || $videos) { ?>
                                <div class="thumb-img">
                                    <div id="owl-detail" class="selectors owl-carousel owl-theme">
                                        <?php if ((isset($videos) && $videos)) foreach ($videos as $video)
                                            if ($video) { ?>
                                            <a class="open-video" data="<?= \common\components\ClaAll::getEmbedToLink($video) ?>">
                                                <img src="images/video.jpg" atl="video san pham gcaeco">
                                            </a>
                                        <?php } ?>
                                        <?php if ((isset($images) && $images)) foreach ($images as $img) { ?>
                                            <a class="open-image" data-zoom-id="Zoom-1" href="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>" data-image="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>">
                                                <img src="<?= ClaHost::getImageHost(), $img['path'], 's100_100/', $img['name'] ?>" alt="<?= $model->name ?>" />
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="title-detail-product">
                        <h2><?= $model['name'] ?></h2>
                        <p>
                            <?= Yii::t('app', 'menu') ?>: <a href="<?= Url::to(['/product/product/category', 'id' => $category->id, 'alias' => $category->alias]) ?>"><?= $category->name ?></a>
                        </p>
                        <div class="price-product">
                            <div class="item-price-product">
                                <p>
                                    <?= $price ? $text_price . ($model['unit'] ? ' /' . $model['unit'] : '') : $text_price ?>
                                    <?php if ($price_market > $price && $price > 0) { ?>
                                        <span><?= $text_price_market ?></span>
                                    <?php } ?>
                                </p>
                                <?php if ($promotion) {
                                    if ($promotion_item) { ?>
                                        <a href="<?= Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias]) ?>">
                                            <div class="time-promotion-product-detail">
                                                <div style="display: inline-block;">
                                                    <img style="margin-top: 7px;" src="<?= Yii::$app->homeUrl ?>images/flas.png" class="left img-top" alt="">
                                                    <span class="left text-top">
                                                        <i style="font-size: 25px; margin-top: 7px; color: #17a349;" class="fa fa-clock-o" aria-hidden="true"></i>
                                                    </span>
                                                    <div class="time" id="countdown"></div>
                                                </div>
                                                <script type="text/javascript">
                                                    $(document).ready(function() {
                                                        var myDate = new Date();
                                                        myDate.setSeconds(myDate.getSeconds() + <?= $hour_next - time() ?>);
                                                        $("#countdown").countdown(myDate, function(event) {
                                                            $(this).html(
                                                                event.strftime(
                                                                    '<?= count($list_time) > 1 ? '<span><b>%H</b></span><span><b>%M</b></span><span><b>%S</b></span>' : '<span><b>%D</b></span><span><b>%H</b></span><span><b>%M</b></span><span><b>%S</b></span>' ?> '
                                                                )
                                                            );
                                                            if (event['offset']['minutes'] == 0 && event['offset']['hours'] == 0 && event['offset']['seconds'] == 0) {
                                                                location.reload();
                                                            };
                                                        });
                                                    });
                                                </script>
                                            </div>
                                            <div class="box-infopro">
                                                <p>
                                                    Số lượng còn: <?= number_format($quantity_max, 0, ',', '.'); ?>
                                                </p>
                                            </div>
                                        </a>
                                        <?php } else if ($promotion_item_after) {
                                        $hour_ef = $promotion_item_after->hour_space_start;
                                        $time_start = $hour_ef > date('H', time()) ? strtotime(date('d-m-Y', time()) . $hour_ef . ':00') : strtotime(date('d-m-Y', time() + 60 * 60 * 24) . $hour_ef . ':00');
                                        $quality_max_after = $promotion_item_after->quantity - $promotion_item_after->quantity_selled;
                                        if ($time_start < $promotion->enddate && $quality_max_after > 0) {
                                        ?>
                                            <a href="<?= Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias, 'hour' => $promotion_item_after->hour_space_start]) ?>">
                                                <div class="time-promotion-product-detail">
                                                    <div style="display: inline-block;">
                                                        <img style="margin-top: 7px;" src="<?= Yii::$app->homeUrl ?>images/flas.png" class="left img-top" alt="">
                                                        <div class="promotion-after">
                                                            chỉ còn:
                                                            <h><?= number_format($promotion_item_after->price, 0, ',', '.'); ?></h>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-infopro">
                                                    <p>
                                                        Bắt đầu
                                                        vào: <?= $hour_ef . 'h ' . ($hour_ef > date('H', time()) ? 'hôm nay' : 'ngày mai') ?>
                                                        với số
                                                        lượng: <?= number_format($quality_max_after, 0, ',', '.'); ?>
                                                    </p>
                                                </div>
                                            </a>
                                <?php }
                                    }
                                } ?>
                            </div>
                        </div>
                        <?php
                        //$this->render('price_distributor', ['model' => $model, 'shop' => $shop]);
                        ?>
                        <div class="description-product">
                            <ul>
                                <li>
                                    <p>
                                        <?= Yii::t('app', 'date_product_start') ?>
                                        : <?= date('d/m/Y', $model['created_at']) ?>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        <?= Yii::t('app', 'product_viewed') ?>: <?= $model['viewed'] ?>
                                    </p>
                                </li>
                                <li class="review">
                                    <p>
                                        <?= Yii::t('app', 'rate') ?>:
                                        <a href="#review" title="<?= $model->rate ?>">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $model->rate) {
                                            ?>
                                                    <i class="fa fa-star yellow" aria-hidden="true"></i>
                                                <?php } else if ($model->rate > (int) $model->rate && 1 + (int) $model->rate == $i) { ?>
                                                    <i class="fa fa-star-half-o yellow" aria-hidden="true"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-star-o yellow" aria-hidden="true"></i>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </a>
                                        <span>(<?= $model->rate_count ? $model->rate_count : 0 ?>)</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <!-- price -->
                        <?php if ($model->price_range) { ?>
                            <div class="table-shop table-banbuon">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label for=""><?= Yii::t('app', 'quantity') ?></label>
                                            </td>
                                            <td>
                                                <label for=""><?= Yii::t('app', 'price') ?></label>
                                            </td>
                                        </tr>
                                        <?php for ($i = 0; $i < count($price_range); $i++) { ?>
                                            <tr>
                                                <td>
                                                    <p><?= $quality_range[$i + 1] ? Yii::t('app', 'from') . ' ' . $quality_range[$i] . ' - ' . (($i != count($price_range) - 1) ? $quality_range[$i + 1] - 1 : $quality_range[$i + 1]) : '≥ ' . $quality_range[$i] ?></p>
                                                </td>
                                                <td>
                                                    <?php
                                                    $prqlt = $model->getPrice($quality_range[$i]);
                                                    if ($prqlt < $price_range[$i]) { ?>
                                                        <p class="red">
                                                            <?= number_format($prqlt, 0, ',', '.'); ?> <?= Yii::t('app', 'currency') ?>
                                                            <span><?= number_format($price_range[$i], 0, ',', '.'); ?></span>
                                                        </p>

                                                    <?php } else { ?>
                                                        <p class="red"><?= number_format($prqlt, 0, ',', '.'); ?> <?= Yii::t('app', 'currency') ?></p>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        <!-- price -->
                        <!-- status -->
                        <p><?= Yii::t('app', 'status') ?>: <b class="red"><?= $model->status_quantity ? Yii::t('app', 'have_product') : Yii::t('app', 'not_product') ?></b>
                        </p>
                        <?php if (!$model->status_quantity) { ?>
                            <p><?= Yii::t('app', 'contact_when_have_product') ?>
                                <?php if (!$check_register_product) { ?>
                                    <span class="checked-register-product">
                                        <a class="open-popup-link check-register-product" href="#register-box-popup"><?= Yii::t('app', 'send_info') ?></a>
                                    </span>
                                <?php } else { ?>
                                    <span class="checked-register-product"><?= Yii::t('app', 'is_send_info') ?></span>
                                <?php } ?>
                            </p>
                        <?php } ?>
                        <?php if ($model->type != 1) { ?>
                            <?php if ($model->start_time > time()) { ?>
                                <p class="clears">
                                    <svg class="gcaeco-svg-icon icon-preorder" enable-background="new 0 0 18 18" viewBox="0 0 18 18" x="0" y="0">
                                        <g>
                                            <g transform="translate(-517 -388)">
                                                <g transform="translate(155 224)">
                                                    <g transform="translate(342)">
                                                        <g transform="translate(17 20)">
                                                            <g transform="translate(2)">
                                                                <g transform="translate(0 143)">
                                                                    <g transform="translate(2 2)">
                                                                        <g>
                                                                            <path d="m13.6 11.7h-1.3v-1.3c0-.2-.2-.4-.4-.4s-.4.2-.4.4v1.6c0 .2.2.4.4.4h1.7c.2 0 .4-.2.4-.4s-.2-.3-.4-.3z"></path>
                                                                            <path d="m11.9 7.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1c0-2.2-1.8-4.1-4.1-4.1zm0 7.4c-1.8 0-3.3-1.5-3.3-3.3s1.5-3.3 3.3-3.3 3.3 1.5 3.3 3.3c0 1.9-1.4 3.3-3.3 3.3z"></path>
                                                                            <path d="m7 14.2h-5.5c-.4 0-.7-.3-.7-.7v-6.7h13.4.8v-.8-3.4c0-.7-.6-1.4-1.4-1.4h-2v-1c0-.1-.1-.2-.2-.2h-.6c-.1 0-.2.1-.2.2v1.1h-6.3v-1.1c0-.1-.1-.2-.2-.2h-.6c-.1 0-.2.1-.2.2v1.1h-1.9c-.8 0-1.4.6-1.4 1.3v3.4.8 6.8c0 .8.6 1.4 1.4 1.4h5.6c.2 0 .4-.2.4-.4s-.2-.4-.4-.4zm-6.2-11.4c0-.4.3-.7.7-.7h1.8v.7c0 .1.1.2.2.2h.6c.1 0 .2-.1.2-.2v-.7h6.3v.7c0 .1.1.2.2.2h.6c.1 0 .2-.1.2-.2v-.7h1.9c.4 0 .7.3.7.7v3.2h-13.4z"></path>
                                                                            <path d="m4.1 12.4c.2 0 .4-.2.4-.4v-1.3h1.3c.2 0 .4-.2.4-.4-.1-.1-.2-.3-.4-.3h-1.3v-1.2c0-.2-.2-.4-.4-.4s-.4.2-.4.4v1.2h-1.2c-.2 0-.4.2-.4.4s.2.4.4.4h1.3v1.2c-.1.2.1.4.3.4z"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="text-left-svg">
                                        <?= Yii::t('app', 'start_time_product') ?>: <b class="red"><?= date('d-m-Y', $model->start_time) ?></b>
                                    </span>

                                </p>
                            <?php } ?>
                            <?php if ($model->number_time) { ?>
                                <p class="clears">
                                    <svg class="gcaeco-svg-icon icon-preorder" enable-background="new 0 0 18 18" viewBox="0 0 18 18" x="0" y="0">
                                        <g>
                                            <g transform="translate(-517 -388)">
                                                <g transform="translate(155 224)">
                                                    <g transform="translate(342)">
                                                        <g transform="translate(17 20)">
                                                            <g transform="translate(2)">
                                                                <g transform="translate(0 143)">
                                                                    <g transform="translate(2 2)">
                                                                        <g>
                                                                            <path d="m13.6 11.7h-1.3v-1.3c0-.2-.2-.4-.4-.4s-.4.2-.4.4v1.6c0 .2.2.4.4.4h1.7c.2 0 .4-.2.4-.4s-.2-.3-.4-.3z"></path>
                                                                            <path d="m11.9 7.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1c0-2.2-1.8-4.1-4.1-4.1zm0 7.4c-1.8 0-3.3-1.5-3.3-3.3s1.5-3.3 3.3-3.3 3.3 1.5 3.3 3.3c0 1.9-1.4 3.3-3.3 3.3z"></path>
                                                                            <path d="m7 14.2h-5.5c-.4 0-.7-.3-.7-.7v-6.7h13.4.8v-.8-3.4c0-.7-.6-1.4-1.4-1.4h-2v-1c0-.1-.1-.2-.2-.2h-.6c-.1 0-.2.1-.2.2v1.1h-6.3v-1.1c0-.1-.1-.2-.2-.2h-.6c-.1 0-.2.1-.2.2v1.1h-1.9c-.8 0-1.4.6-1.4 1.3v3.4.8 6.8c0 .8.6 1.4 1.4 1.4h5.6c.2 0 .4-.2.4-.4s-.2-.4-.4-.4zm-6.2-11.4c0-.4.3-.7.7-.7h1.8v.7c0 .1.1.2.2.2h.6c.1 0 .2-.1.2-.2v-.7h6.3v.7c0 .1.1.2.2.2h.6c.1 0 .2-.1.2-.2v-.7h1.9c.4 0 .7.3.7.7v3.2h-13.4z"></path>
                                                                            <path d="m4.1 12.4c.2 0 .4-.2.4-.4v-1.3h1.3c.2 0 .4-.2.4-.4-.1-.1-.2-.3-.4-.3h-1.3v-1.2c0-.2-.2-.4-.4-.4s-.4.2-.4.4v1.2h-1.2c-.2 0-.4.2-.4.4s.2.4.4.4h1.3v1.2c-.1.2.1.4.3.4z"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="text-left-svg">
                                        <?= Yii::t('app', 'number_time_product') ?>: <b class="red"><?= $model->number_time ?></b>
                                    </span>
                                </p>
                            <?php } ?>
                        <?php } ?>
                        <!-- status -->
                        <!-- phí vận chuyển -->
                        <?=
                            frontend\widgets\html\HtmlWidget::widget([
                                'input' => [
                                    'model' => $model,
                                    'shop' => $shop
                                ],
                                'view' => 'transport_detail'
                            ]);
                        ?>
                        <?php if ($model['fee_ship'] && $model['note_fee_ship']) { ?>
                            <span style="background: green; font-style: italic; color: #fff; display: inline-block; padding: 2px 15px; border-radius: 15px;">Vận chuyển: <?= nl2br($model['note_fee_ship']); ?></span>
                            <br />
                        <?php } ?>
                        <?php if ($model->status_quantity && $price > 0) { ?>
                            <!-- phí vận chuyển -->
                            <br />
                            <div class="option-product-detail">
                                <div class="item-option-product-detail">
                                    <label><?= Yii::t('app', 'quantity') ?>:</label>
                                    <div class="quality-product-detail">
                                        <div class=" pull-left">
                                            <input type="text" min="<?= $model->quality_range ? $quality_range[0] : 1 ?>" title="<?= Yii::t('app', 'quality') ?>" value="<?= $model->quality_range ? $quality_range[0] : 1 ?>" maxlength="12" id="qty" name="quantity" class="input-text" oninput="validity.valid||(value='');">
                                            <div class="btn_count">
                                                <button id="countup" class="increase items-count" type="button"><i class="fa fa-plus"></i></button>

                                                <button id="count-down" class="reduced items-count" type="button"><i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="addcart-detail-product">
                                    <script type="text/javascript">
                                        function isAlphaNum(a) {
                                            var txt = ($('#qty').val() + a).replace(/^\D+/g, '');
                                            var txt2 = ($('#qty').val()).replace(/^\D+/g, '');
                                            var qty_old = $('#qty').val();
                                            var numb;
                                            var min = <?= $quantity_min ?>;
                                            var max = <?= $quantity_max ?>;
                                            if (txt != '') {
                                                var numb = txt.match(/\d/g);
                                                numb = numb.join("");
                                                var numb2 = txt2.match(/\d/g);
                                                numb2 = numb2.join("");
                                            }
                                            if (numb == null) {
                                                numb = 0;
                                            }
                                            if (numb2 == null) {
                                                numb2 = 0;
                                            }
                                            if (max >= numb) {
                                                $('#qty').val(numb2);
                                            } else {
                                                $('#qty').val(max);
                                                if ($('#input-transport') && parseInt(qty_old) != max) getCostTransport();
                                                return false;
                                            }
                                            return true;
                                        }

                                        function checkRange() {
                                            var min = <?= $quantity_min ?>;
                                            var max = <?= $quantity_max ?>;
                                            var txt = ($('#qty').val()).replace(/^\D+/g, '');
                                            if (txt != '') {
                                                var numb = txt.match(/\d/g);
                                                numb = numb.join("");
                                            }
                                            if (numb == null) {
                                                numb = 0;
                                            }
                                            if (min <= numb && max >= numb) {
                                                $('#qty').val(numb);
                                            } else {
                                                if (min > numb) {
                                                    $('#qty').val(min);
                                                } else {
                                                    $('#qty').val(max);
                                                }
                                                return false;
                                            }
                                            return true;
                                        }

                                        $(document).ready(function() {
                                            $('#qty').keydown(function(e) {
                                                var keyCode = (e.keyCode ? e.keyCode : e.which);
                                                if (!(keyCode > 47 && keyCode < 58 || keyCode == 8)) {
                                                    switch (keyCode) {
                                                        case 40:
                                                            $('#count-down').click();
                                                            return false;
                                                        case 38:
                                                            $('#countup').click();
                                                            return false;
                                                    }
                                                    return false;
                                                } else {
                                                    if (!isAlphaNum(String.fromCharCode(e.keyCode))) {
                                                        return false;
                                                    }
                                                }
                                            });
                                            $('#qty').change(function(e) {
                                                checkRange();
                                                if ($('#input-transport')) getCostTransport();
                                            });
                                            $('#add-cart-ajax').click(function() {
                                                if ($('#add-cart-ajax').attr('add') == '0') {
                                                    return false;
                                                }
                                                var href = '<?= Url::to(['/product/shoppingcart/add-cart', 'id' => $model['id'], 'quantity' => '']) ?>' + $('#qty').val();
                                                loadAjax(href, {
                                                    ajax: 1
                                                }, $('#box-shopping-cart'));
                                                return false;
                                            });
                                            $('#add-cart-href').click(function() {
                                                $('#add-cart-href').attr('href', '<?= Url::to(['/product/shoppingcart/add-cart', 'id' => $model['id'], 'quantity' => '']) ?>' + $('#qty').val());
                                            });
                                            $('#count-down').click(function() {
                                                var result = document.getElementById('qty');
                                                var qty = result.value;
                                                if (!isNaN(qty) && qty > <?= $quantity_min ?>) {
                                                    result.value--;;
                                                    if (checkRange() && $('#input-transport')) getCostTransport();
                                                }
                                                return false;
                                            });
                                            $('#countup').click(function() {
                                                var result = document.getElementById('qty');
                                                var qty = result.value;
                                                if (!isNaN(qty) && qty < <?= $quantity_max ?>) {
                                                    result.value++;
                                                    if (checkRange() && $('#input-transport')) getCostTransport();
                                                }
                                                return false;
                                            });
                                        });
                                    </script>
                                    <a class="btn-style-1 click" id="add-cart-ajax" add="<?= $check ? '0' : 1 ?>"><i class="fa fa-shopping-cart"></i><?= $check ? Yii::t('app', 'added_shoppingcart') : Yii::t('app', 'add_to_bag') ?>
                                    </a>

                                    <?php if (Yii::$app->user->getId()) { ?>
                                        <a class="chat-buyer btn-style-1" id="add-cart-href" href="<?= Url::to(['/product/shoppingcart/add-cart', 'id' => $model['id']]) ?>"><i class="fa fa-check"></i><?= Yii::t('app', 'buy_now') ?></a>
                                    <?php } else { ?>
                                        <!-- <a class="btn-style-1 open-popup-link" href="#login-box-popup"><i class="fa fa-shopping-cart"></i><?= Yii::t('app', 'add_to_bag') ?>
                                        </a> -->
                                        <a class="btn-style-1 open-popup-link" href="#login-box-popup"><i class="fa fa-check"></i><?= Yii::t('app', 'buy_now') ?></a>
                                    <?php } ?>
                                    <?php
                                    $phone = \common\models\shop\Shop::findOne($model->shop_id)->phone;
                                    ?>
                                    <!-- <a class="chat-buyer btn-style-1"  href=""> <i class="fa fa-comments-o"></i><?= Yii::t('app', 'chat_with_user') ?></a> -->
                                    <p class="tel-phone"><?= Yii::t('app', 'call_shopping') ?>:<a onclick="ShowPopCall('<?= $phone ?>')" href="javascript:void(0)">
                                            <span><?= $siteinfo->hotline ?></span> </a></p>

                                </div>
                                <div class="social-detail-product">
                                    <!--  <img src="images/fb-like.png" alt="">
                                         <a href="">Xem các sản phẩm đã lưu ở đây</a> -->
                                </div>
                            </div>
                        <?php } else {
                            $phone = \common\models\shop\Shop::findOne($model->shop_id)->phone; ?>
                            <p class="tel-phone"><?= Yii::t('app', 'call_shopping') ?>:<a href="javascript:void(0)" onclick="ShowPopCall('<?= $phone ?>')">
                                    <span><?= $siteinfo->hotline ?></span> </a></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <div class="infor-buyer-store">
                        <div class="address-buyer-store">
                            <div class="page-store">
                                <div class="section-intro">
                                    <div class="left-intro">
                                        <?=
                                            frontend\widgets\html\HtmlWidget::widget([
                                                'input' => [
                                                    'model' => $shop,
                                                    'product' => $model
                                                ],
                                                'view' => 'view_shop_info_pd'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="share" style="padding: 26px 0px 0px 0px; clear: both;">
                            <?=
                                frontend\widgets\shareSocial\ShareSocialWidget::widget([
                                    'view' => 'product_detail'
                                ]);
                            ?>
                            <?php if ($model->status_affiliate && $shop->status_affiliate && $model->affiliate_gt_product > 0 && Yii::$app->user->id) { ?>
                                <p class="info-afffilate">
                                    Tham gia chương trình affiliate marketing <?php if ($laf = $model->getLinkAffiliate(Yii::$app->user->id)) { ?>
                                        (<a class="open-popup-link" href="#alert-getLink" data-link="<?= $laf ?>">COPY LINK</a>)
                                    <?php } else { ?>
                                        (<span><a onclick="createLink($(this), '<?= Url::to(['/product/product/detail', 'id' => $model['id'], 'alias' => $model['alias']], true) ?>', <?= $model['id'] ?>)" href="javascript:void(0)">COPY LINK</a></span>)
                                    <?php } ?> 
                                    gửi đến bạn bè giúp họ mua sản phẩm này bạn nhận được (<?= $model->affiliate_gt_product ?>%) từ nhà cung cấp.
                                </p>
                                <div id="alert-getLink" class="white-popup mfp-hide">
                                    <div class="box-account">
                                        <div class="bg-pop-whites">
                                            <div class="box-getlink">
                                                <span class="mfp-close"></span>
                                                <div class="textcopy">
                                                    <input id="linkcopy" value="">
                                                </div>
                                                <button onclick="copyText()">Copy Link</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style type="text/css">
                                    .get-link a {
                                        display: inline-block;
                                        padding: 5px 5px;
                                        width: 75px;
                                        background: #17a349;
                                        color: #fff;
                                        border-radius: 3px;
                                    }

                                    .get-link a:hover {
                                        opacity: 0.8;
                                    }

                                    .affiliate-link-index .img {
                                        max-width: 100px;
                                        max-height: 50px;
                                        overflow: hidden;
                                    }

                                    .box-getlink .textcopy {
                                        overflow-x: auto;
                                        border: 1px dashed #ccc;
                                        padding: 7px 15px;
                                        background: #ebebeb;
                                        width: 100%;
                                    }

                                    .box-getlink .textcopy input {
                                        margin-bottom: 0px;
                                        white-space: nowrap;
                                        border: none;
                                        background: transparent;
                                        width: 100%;
                                    }

                                    .box-getlink button {
                                        white-space: nowrap;
                                        background: #17a349;
                                        border: none;
                                        color: #fff;
                                        padding: 0px 20px;
                                    }

                                    .box-getlink {
                                        max-width: 500px;
                                        margin: 0 auto;
                                        background: #fff;
                                        padding: 15px;
                                        display: flex;
                                        position: relative;
                                    }

                                    .box-getlink .mfp-close {
                                        background: #17a349 !important;
                                        top: -30px !important;
                                        opacity: 1;
                                        right: -30px !important;
                                        border-radius: 50%;
                                        cursor: pointer;
                                    }
                                </style>
                                <script type="text/javascript">
                                    function copyText() {
                                        var copyText = document.getElementById("linkcopy");
                                        copyText.select();
                                        document.execCommand("copy");
                                    }

                                    function createLink(_this, product_url, product_id) {
                                        $.getJSON(
                                            '<?= Url::to(['/affiliate/affiliate-link/create-link']) ?>', {
                                                url: product_url,
                                                type: <?= \common\models\affiliate\AffiliateLink::TYPE_PRODUCT ?>,
                                                object_id: product_id
                                            },
                                            function(data) {
                                                if (data.message == 'success') {
                                                    _this.parent().html('<a class="open-popup-link" href="#alert-getLink" data-link="' + data.link + '">COPY LINK</a>');
                                                    $('.open-popup-link').click(function() {
                                                        var link = $(this).attr('data-link');
                                                        $('#linkcopy').val(link);
                                                    });
                                                    $('.open-popup-link').magnificPopup({
                                                        type: 'inline',
                                                        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                                                    });
                                                    $('.open-popup-link').click();
                                                } else {
                                                    alert('Sản phẩm hiện chưa thỏa mãn điều kiện tham gia.');
                                                }
                                            }
                                        );
                                    }

                                    $(document).ready(function() {
                                        $('.open-popup-link').click(function() {
                                            var link = $(this).attr('data-link');
                                            $('#linkcopy').val(link);
                                        });
                                        $('.open-popup-link').magnificPopup({
                                            type: 'inline',
                                            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                                        });
                                    });
                                </script>
                            <?php } ?>
                        </div>
                        <?php if ($certificate_ktx) : ?>
                            <style>
                                .skts p {
                                    font-size: 20px
                                }

                                .skts img {
                                    width: 57%;
                                    display: block;
                                    margin-left: 20px;
                                    margin-right: auto;
                                    margin-bottom: 15px
                                }

                                .skts a {
                                    font-size: 16px;
                                    color: #17a349;
                                    font-weight: 550;
                                    display: -webkit-box;
                                    -webkit-line-clamp: 1;
                                    -webkit-box-orient: vertical;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                }
                            </style>
                            <div class="share skts" style="padding: 26px 0px 0px 0px; clear: both;">
                                <p>Truy xuất nguồn gốc:</p>
                                <img src="<?= ClaHost::getImageHost() . $certificate_ktx['avatar_path'] . $certificate_ktx['avatar_name'] ?>" alt="Truy xuất nguồn gốc">
                                <a href="<?= $certificate_ktx['link_certificate'] ?>" target="_blank"><?= $certificate_ktx['link_certificate'] ?></a>
                            </div>
                        <?php endif; ?>
                        <style>
                            .share p {
                                color: #dbbf6d;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $code = \common\models\product\CertificateProductItem::getCode($model->id, 4);
            $lsxs = $code ? \common\models\product\CerXtsShop::getDiaryDetail($model->shop_id, $code) : [];
            $infsxs = $code ? \common\models\product\CerXtsShop::getInfoCompany($model->shop_id) : [];
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-full">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="infor-detail-product">
                                <div class="infor-tab-detail">
                                    <ul>
                                        <li class="tablinks active" onclick="openCity(event, 'tab1')"><a><?= Yii::t('app', 'product_description') ?></a></li>
                                        <li class="tablinks" onclick="openCity(event, 'tab2')"><a>Nhật ký điện tử</a></li>
                                        <li class="tablinks" onclick="openCity(event, 'tab3')"><a>Nhà sản xuất</a></li>
                                        <li class="tablinks" onclick="openCity(event, 'tab4')"><a>Chứng thực</a></li>
                                        <li class="tablinks" onclick="openCity(event, 'tab5')"><a>Video</a></li>
                                        <li><a href="#review"><?= Yii::t('app', 'rate') ?></a></li>
                                    </ul>
                                </div>
                                <div id="tab1" class="tabcontent" style="display: block">
                                    <div class="ctn-detail-product">
                                        <div class="ctn-left-detail content-standard-ck">
                                            <?= $model['ckedit_desc'] ? $model['description'] : nl2br($model['description']) ?>
                                        </div>
                                    </div>
                                    <div class="view-more-detail">
                                        <?= Yii::t('app', 'show_all_content') ?>
                                    </div>
                                </div>
                                <?php if ($lsxs) { ?>
                                    <div id="tab2" class="tabcontent">
                                        <div class="ctn-detail-product">
                                            <div class="ctn-left-detail content-standard-ck">
                                                <p>Tên sản phẩm: <?= $lsxs['Name'] ?></p>
                                                <p>Đơn vị sản xuất: <?= $lsxs['CompanyName'] ?></p>
                                                <p>Địa chỉ: <?= $lsxs['Address'] ?></p>
                                                <h2>Nhật ký sản xuất:</h2>
                                                <ul>
                                                    <?php if ($lsxs['Actions']) foreach ($lsxs['Actions'] as $action) { ?>
                                                        <li>
                                                            <p><?= $action['ActionDate'] ?>: <?= $action['Name'] ?></p>
                                                            <p>Đánh giá: <?= $action['Status'] ?></p>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="view-more-detail">
                                            <?= Yii::t('app', 'show_all_content') ?>
                                        </div>
                                    </div>
                                    <?php if ($infsxs) {
                                        $infsx = $infsxs[0]; ?>
                                        <div id="tab3" class="tabcontent">
                                            <div class="ctn-detail-product">
                                                <div class="ctn-left-detail content-standard-ck">
                                                    <div class="box-infd">
                                                        <img style="width: 200px; float: left; margin-right: 15px;" class="inforl" src="<?= $infsx['Logo'] ?>" alt=" <?= $infsx['Name'] ?>">
                                                        <div class="r-fns">
                                                            <h3>Đơn vị sản xuất: <?= $infsx['Name'] ?></h3>
                                                            <p>Điện thoại: <a href="tel:<?= $infsx['Phone'] ?>"><?= $infsx['Phone'] ?></a></p>
                                                        </div>
                                                    </div>
                                                    <p>Email: <a href="mailto:<?= $infsx['Email'] ?>"><?= $infsx['Email'] ?></a></p>
                                                    <p>Địa chỉ: <?= $infsx['Address'] ?></p>
                                                    <p>Website: <a target="_blank" href="<?= $infsx['Website'] ?>"><?= $infsx['Website'] ?></a></p>
                                                    <p>Fanpage: <a target="_blank" href="<?= $infsx['Fanpage'] ?>"><?= $infsx['Fanpage'] ?></a></p>
                                                    <h2>Giới thiệu:</h2>
                                                    <div>
                                                        <?= nl2br($infsx['ProfileInfo']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="view-more-detail">
                                                <?= Yii::t('app', 'show_all_content') ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div id="tab3" class="tabcontent">
                                        <div class="ctn-detail-product">
                                            <div class="ctn-left-detail content-standard-ck">
                                                <h2><?= $shop['name'] ?></h2>
                                                <div>
                                                    <?= nl2br($shop['description']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="view-more-detail">
                                            <?= Yii::t('app', 'show_all_content') ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div id="tab4" class="tabcontent">
                                    <div class="ctn-detail-product">
                                        <div class="certificate">
                                            <style>
                                                .certificate li {
                                                    list-style: none;
                                                }

                                                .certificate li {
                                                    list-style: none;
                                                }

                                                .certificate li .tilte img {
                                                    width: 20px;
                                                    margin-right: 10px;
                                                }
                                            </style>
                                            <ul>
                                                <?php
                                                foreach ($certificates as $certificate) {
                                                    if (isset($certificate_imgs[$certificate['id']])) {
                                                        $certificate_img = $certificate_imgs[$certificate['id']]; ?>
                                                        <li class="view-certificate-imgs click" data="<?= ClaHost::getImageHost(), $certificate_img['avatar_path'], $certificate_img['avatar_name'] ?>" title="<?= $certificate['name'] ?>">
                                                            <p class="tilte">
                                                                <img src="<?= ClaHost::getImageHost(), $certificate['avatar_path'], $certificate['avatar_name'] ?>"> <?= $certificate['name'] ?>
                                                            </p>
                                                            <p class="img">
                                                                <img src="<?= ClaHost::getImageHost(), $certificate_img['avatar_path'], $certificate_img['avatar_name'] ?>" alt="<?= $certificate['name'] ?>">
                                                            </p>
                                                        </li>
                                                <?php }
                                                } ?>
                                            </ul>
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    $('.view-certificate-imgs').click(function() {
                                                        $('#box-index').attr('src', $(this).attr('data'));
                                                        $('.box-index').css('display', 'block');
                                                    });
                                                })
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab5" class="tabcontent">
                                    <div class="ctn-detail-product">
                                        <div class="certificate">
                                            <?php if ((isset($videos) && $videos)) foreach ($videos as $video)
                                                if ($video) { ?>
                                                <p style="margin-bottom: 10px;">
                                                    <iframe class="video-youtube" src="<?= \common\components\ClaAll::getEmbedToLink($video) ?>" frameborder="0" style="width:100%" width="100%"></iframe>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .tabcontent {
                        display: none;
                    }

                    .tablinks {
                        cursor: pointer;
                    }

                    .infor-tab-detail ul li {
                        height: 50px;
                    }
                </style>
                <script>
                    function openCity(evt, cityName) {
                        var i, tabcontent, tablinks;
                        tabcontent = document.getElementsByClassName("tabcontent");
                        for (i = 0; i < tabcontent.length; i++) {
                            tabcontent[i].style.display = "none";
                        }
                        tablinks = document.getElementsByClassName("tablinks");
                        for (i = 0; i < tablinks.length; i++) {
                            tablinks[i].className = tablinks[i].className.replace(" active", "");
                        }
                        document.getElementById(cityName).style.display = "block";
                        evt.currentTarget.className += " active";
                        if (cityName == 'tab5') {
                            $("#tab5 .video-youtube").height($("#tab5 .video-youtube").width() * 0.564);
                        }
                    }
                </script>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-full">
                    <h2 class="title-full"><?= Yii::t('app', 'address_shoper') ?></h2>
                    <div class="map">
                        <?=
                            \frontend\widgets\html\HtmlWidget::widget([
                                'view' => 'map',
                                'input' => [
                                    'center' => $shop,
                                    'zoom' => 10,
                                    'listMap' => $shopadd ? $shopadd : [0 => $shop]
                                ]
                            ])
                        ?>
                        <style type="text/css">
                            body .ctn-left-detail {
                                height: 234px;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
        <div class="full-width">
            <div class="row">
                <div class="product-inhome">
                    <div class="container">
                        <?=
                            frontend\widgets\productAttr\ProductAttrWidget::widget([
                                'attr' => [
                                    'shop_id' => $model->shop_id,
                                ],
                                'view' => 'hot_category',
                                '_product' => $model->id,
                                'limit' => 12,
                                'title' => 'Sản phẩm cùng gian hàng',
                                'order' => 'ishot DESC, id DESC'
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="white-full">
            <h2 class="title-full"><?= Yii::t('app', 'comment') ?></h2>
            <div class="map">
                <?= \frontend\widgets\facebookcomment\FacebookcommentWidget::widget([]) ?>
            </div>
        </div>
        <?=
            \frontend\widgets\rating\RatingWidget::widget([
                'title' => Yii::t('app', 'item_reviews'),
                'data' => $model->attributes,
                'type' => common\models\rating\Rating::RATING_PRODUCT,
                'object_id' => $model->id
            ])
        ?>
    </div>
</div>
<?php if (!$model->status_quantity && !$check_register_product) { ?>
    <div id="register-box-popup" class="white-popup mfp-hide">
        <div class="box-account">
            <span class="mfp-close"></span>
            <div class="bg-pop-white">
                <h2><?= Yii::t('app', 'register_news_when_have_product') ?></h2>
                <p>
                    <?= Yii::t('app', 'register_news_when_have_product_2') ?>
                </p>
                <form action="" id="form-register-pub">
                    <input required="" type="text" id="info-phone" minlength="9" maxlength="15" name="ProductRegisterInfo[phone]" placeholder="<?= Yii::t('app', 'enter_phone') ?>(*)" value="<?= isset($user->phone) ? $user->phone : '' ?>">
                    <input required="" type="email" id="info-email" name="ProductRegisterInfo[email]" placeholder="<?= Yii::t('app', 'enter_email') ?>(*)" value="<?= isset($user->email) ? $user->email : '' ?>">
                    <textarea style="width: 100%; min-height: 160px; border-color: #ebebeb; margin-bottom: 12px; padding: 20px;" id="info-note" name="ProductRegisterInfo[note]" placeholder="<?= Yii::t('app', 'enter_note') ?>"></textarea>
                    <input required="" type="hidden" name="ProductRegisterInfo[product_id]" value="<?= $model->id ?>">
                    <input required="" type="hidden" name="ProductRegisterInfo[shop_id]" value="<?= $model->shop_id ?>">
                    <center style="color: red" id="error-register"></center>
                    <button class="btn-register"><?= Yii::t('app', 'send') ?></button>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.btn-register').click(function() {
                    var _this = $(this);
                    $(this).css('display', 'none');
                    var form = $('#form-register-pub').serialize();
                    var url = '<?= Url::to(['/site/save-register-product']) ?>';
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form,
                        success: function(responce) {
                            if (responce == '1') {
                                $('.mfp-close').click();
                                $('.checked-register-product').html('<?= Yii::t('app', 'is_send_info') ?>');
                            } else {
                                $('#error-register').html(responce);
                                _this.css('display', 'inline-block');
                            }
                        },
                    });
                    return false;
                });
            });
        </script>
    </div>
<?php } ?>