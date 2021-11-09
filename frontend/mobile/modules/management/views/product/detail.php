<?php
    date_default_timezone_set("Asia/Bangkok");
    use yii\helpers\Url;
    use common\models\product\Product;
    use common\components\ClaHost;
    use common\components\ClaLid;
    use frontend\components\AttributeHelper;
    
    $siteinfo = common\components\ClaLid::getSiteinfo();
    $check_register_product = 0;
    if(!$model->status_quantity) {
        if(!($check_register_product = \common\models\product\ProductRegisterInfo::getCheck($model->id))) {
            $user = \common\models\User::findOne(Yii::$app->user->id);
        }
    }
    //quantity
    $quality_range = explode(',', $model->quality_range);
    $quantity_min = $model->getQuantityMin();
    $quantity_max = $model->getQuantityMax();
    //price
    $price_range = explode(',', $model->price_range);
    $price = $model->price;
    $price_market = $model->price_market > $model->price ? $model->price_market : '';
    $text_price_market = $model->price_market > 0 ? number_format($model['price_market'], 0, ',', '.') : '';
    $text_price = $price ? number_format($model['price'], 0, ',', '.') : 'Liên hệ';
    
    if ($model->price_range) {
        $price_range = explode(',', $model->price_range);
        $price_max = number_format($price_range[0], 0, ',', '.');
        $price_min = number_format($price_range[count($price_range) - 1], 0, ',', '.');
    }
    //promotion
    $promotion = \common\models\promotion\Promotions::getPromotionNow();
    if($promotion) {
        $promotion_item = $model->getPromotionItemNow();
        if($promotion_item) {
            $quantity_max = ($promotion_item->quantity - $promotion_item->quantity_selled) > 0 ? ($promotion_item->quantity - $promotion_item->quantity_selled) : $quantity_max;
            $price_market = $price;
            $text_price_market = $text_price; 
            //thoi gian
            $list_time = explode(' ', $promotion->time_space);
            $hour_next = count($list_time) > 1 ? $promotion->getHourAfter($promotion->getHourNow()) : $promotion->enddate;
        } else {
            $promotion_item_after = $model->getPromotionItem();
        }
    }
    $price_market = intval($price_market);
    $price = intval($model->getPrice($quantity_min));
    $text_price = $price ? number_format($price, 0, ',', '.') : 'Liên hệ';
?>
<style type="text/css">
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
        float:right;
        list-style: none;
        margin-left: 10px;
        width: 15px;
        cursor: pointer;
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
    .promotion-after h{
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
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('.open-video').click(function () {
            $('.box-video').css('z-index', '1');
            if($('.box-video').find('iframe').attr('src') != $(this).attr('data')) {
                $('.box-video').find('iframe').attr('src', $(this).attr('data'));
            }
        });
        $('.open-image').click(function () {
            $('.box-video').css('z-index', '0');
            $('.box-video').find('iframe').attr('src', '');
        });
        $('.open-video').mouseenter(function () {
            $('.box-video').css('z-index', '1');
            if($('.box-video').find('iframe').attr('src') != $(this).attr('data')) {
                $('.box-video').find('iframe').attr('src', $(this).attr('data'));
            }
        });
        $('.open-image').mouseenter(function () {
            $('.box-video').css('z-index', '0');
            $('.box-video').find('iframe').attr('src', '');
        });
    })
    function getCostTransport() {
    }
</script>
<div class="detail-product-page">
    <div class="container">
        <div class="white-full">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    <div class="img-detail-product">
                        <div class="certificate">
                            <ul>
                                <?php
                                foreach ($certificates as $certificate)
                                    if (isset($certificate_imgs[$certificate['id']])) {
                                        $certificate_img = $certificate_imgs[$certificate['id']];
                                        ?>
                                        <li class="view-certificate-img" data="<?= ClaHost::getImageHost(), $certificate_img['avatar_path'], $certificate_img['avatar_name'] ?>" title="<?= $certificate['name'] ?>">
                                            <img src="<?= ClaHost::getImageHost(), $certificate['avatar_path'], $certificate['avatar_name'] ?>">
                                        </li>
                                    <?php } ?>
                            </ul>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $('.view-certificate-img').click(function () {
                                        $('#box-index').attr('src', $(this).attr('data'));
                                        $('.box-index').css('display', 'block');
                                    });
                                })
                            </script>
                        </div>    
                        <div class="app-figure" id="zoom-fig">
                            <div style="max-height: 500px; overflow: hidden;">
                                <div class="big-img">
                                    <?php if ($price_market > $price && $price > 0) { ?>
                                        <span class="sale-label">-<?= \common\components\ClaLid::getDiscount($price_market, $price) ?>%</span>
                                    <?php } ?>
                                    <a id="Zoom-1" class="MagicZoom" data-options="selectorTrigger: hover; transitionEffect: false;zoomDistance: 20;zoomWidth:520px; zoomHeight:500px;variableZoom: true" title="Show your product in stunning detail with Magic Zoom Plus." href="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>" >
                                        <img src="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>" />
                                    </a>
                                    <div class="box-video">
                                        <iframe src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                            
                            <?php 
                                $videos = explode(',.,', $model->videos);
                                if ((isset($images) && $images ) || (isset($certificate_imgs) && $certificate_imgs) && $videos) { ?>
                                <div class="thumb-img">
                                    <div id="owl-detail" class="selectors owl-carousel owl-theme">
                                        <?php if ((isset($videos) && $videos )) foreach ($videos as $video)
                                            if($video) { ?>
                                            <a class="open-video" data="<?= \common\components\ClaAll::getEmbedToLink($video) ?>" >
                                                <img src="images/video.jpg" atl="video san pham gcaeco">
                                            </a>
                                        <?php } ?>
                                        <?php  if ((isset($images) && $images )) foreach ($images as $img) { ?>
                                            <a class="open-image" data-zoom-id="Zoom-1" href="<?= ClaHost::getImageHost(), $img['path'] , $img['name'] ?>"
                                               data-image="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>">
                                                <img src="<?= ClaHost::getImageHost(), $img['path'], 's100_100/', $img['name'] ?>" alt="<?= $model->name ?>" />
                                            </a>
                                        <?php } ?>
                                        <?php if ((isset($certificate_imgs) && $certificate_imgs )) foreach ($certificate_imgs as $img) { ?>
                                            <a class="open-image" data-zoom-id="Zoom-1" href="<?= ClaHost::getImageHost(), $img['avatar_path'] , $img['avatar_name'] ?>"
                                               data-image="<?= ClaHost::getImageHost(), $img['avatar_path'], 's800_800/', $img['avatar_name'] ?>">
                                                <img src="<?= ClaHost::getImageHost(), $img['avatar_path'], 's100_100/', $img['avatar_name'] ?>"  alt="<?= $model->name ?>" />
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
                                    <?= $price ? $text_price.' '.Yii::t('app', 'currency').($model['unit'] ? ' /' . $model['unit'] : '') : $text_price ?>
                                    <?php if ($price_market > 0) { ?>
                                        <span><?= $text_price_market ?></span>
                                    <?php } ?>
                                </p>
                                <?php if($promotion) {
                                    if($promotion_item) {?>
                                        <a href="<?= Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias]) ?>">
                                            <div class="time-promotion-product-detail">
                                                <div style="display: inline-block;">
                                                    <img  style="margin-top: 7px;" src="<?= Yii::$app->homeUrl ?>images/flas.png" class="left img-top" alt="">
                                                    <span class="left text-top">
                                                        <i style="font-size: 25px; margin-top: 7px; color: #17a349;" class="fa fa-clock-o" aria-hidden="true"></i>
                                                    </span>
                                                    <div class="time" id="countdown"></div>
                                                </div>
                                                <script type="text/javascript">
                                                    $(document).ready(function(){
                                                            var myDate = new Date();
                                                            myDate.setSeconds(myDate.getSeconds() + <?= $hour_next - time() ?>);
                                                            $("#countdown").countdown(myDate, function (event) {
                                                                $(this).html(
                                                                    event.strftime(
                                                                        '<?= count($list_time) > 1 ? '<span><b>%H</b></span><span><b>%M</b></span><span><b>%S</b></span>' : '<span><b>%D</b></span><span><b>%H</b></span><span><b>%M</b></span><span><b>%S</b></span>' ?> '
                                                                    )
                                                                );
                                                                if(event['offset']['minutes'] == 0 && event['offset']['hours']==0 && event['offset']['seconds']==0) {
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
                                    <?php } else if($promotion_item_after) {
                                        $hour_ef =$promotion_item_after->hour_space_start;
                                        $time_start = $hour_ef > date('H', time()) ? strtotime(date('d-m-Y', time()).$hour_ef. ':00') : strtotime(date('d-m-Y', time()+60*60*24).$hour_ef. ':00');
                                        $quality_max_after = $promotion_item_after->quantity - $promotion_item_after->quantity_selled;
                                        if($time_start < $promotion->enddate && $quality_max_after > 0) {
                                            ?>
                                            <a href="<?= Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias, 'hour' => $promotion_item_after->hour_space_start]) ?>">
                                                <div class="time-promotion-product-detail">
                                                    <div style="display: inline-block;">
                                                        <img  style="margin-top: 7px;" src="<?= Yii::$app->homeUrl ?>images/flas.png" class="left img-top" alt="">
                                                        <div class="promotion-after">
                                                            chỉ còn: <h><?= number_format($promotion_item_after->price, 0, ',', '.'); ?></h>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-infopro">
                                                    <p>
                                                        Bắt đầu vào: <?= $hour_ef.'h '.($hour_ef > date('H', time()) ? 'hôm nay' : 'ngày mai') ?>
                                                   với số lượng: <?= number_format($quality_max_after, 0, ',', '.'); ?>
                                                    </p>
                                                </div>
                                            </a>
                                        <?php }
                                    } 
                                }?>
                            </div>
                        </div>
                        <div class="description-product">
                            <ul>
                                <li>
                                    <p>
                                        <?= Yii::t('app', 'date_product_start') ?>: <?= date('d/m/Y', $model['created_at']) ?>
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
                                                    <p><?= $quality_range[$i + 1] ? Yii::t('app', 'from') .' '. $quality_range[$i] . ' - ' . (($i != count($price_range) - 1) ? $quality_range[$i + 1] - 1 : $quality_range[$i + 1]) : '≥ ' . $quality_range[$i] ?></p>
                                                </td>
                                                <td>
                                                    <p class="red"><?= number_format($price_range[$i], 0, ',', '.'); ?> <?= Yii::t('app', 'currency') ?></p>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        <!-- price -->
                        <!-- status -->
                           <p><?= Yii::t('app', 'status') ?>: <b class="red"><?= $model->status_quantity ? Yii::t('app', 'have_product') : Yii::t('app', 'not_product') ?></b></p>
                            <?php if(!$model->status_quantity) { ?>
                                <p><?= Yii::t('app', 'contact_when_have_product') ?> 
                                    <?php if(!$check_register_product) { ?>
                                        <span class="checked-register-product">
                                            <a class="open-popup-link check-register-product" href="#register-box-popup"><?= Yii::t('app', 'send_info') ?></a>
                                        </span>
                                    <?php } else { ?>
                                        <span class="checked-register-product"><?= Yii::t('app', 'is_send_info') ?></span>
                                    <?php } ?>
                                </p>
                            <?php } ?>
                            <?php if($model->type != 1) { ?>
                                <?php if($model->start_time > time()) { ?>
                                    <p class="clears">
                                        <svg class="gcaeco-svg-icon icon-preorder" enable-background="new 0 0 18 18" viewBox="0 0 18 18" x="0" y="0"><g><g transform="translate(-517 -388)">
                                            <g transform="translate(155 224)"><g transform="translate(342)"><g transform="translate(17 20)"><g transform="translate(2)"><g transform="translate(0 143)"><g transform="translate(2 2)"><g><path d="m13.6 11.7h-1.3v-1.3c0-.2-.2-.4-.4-.4s-.4.2-.4.4v1.6c0 .2.2.4.4.4h1.7c.2 0 .4-.2.4-.4s-.2-.3-.4-.3z"></path><path d="m11.9 7.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1c0-2.2-1.8-4.1-4.1-4.1zm0 7.4c-1.8 0-3.3-1.5-3.3-3.3s1.5-3.3 3.3-3.3 3.3 1.5 3.3 3.3c0 1.9-1.4 3.3-3.3 3.3z"></path><path d="m7 14.2h-5.5c-.4 0-.7-.3-.7-.7v-6.7h13.4.8v-.8-3.4c0-.7-.6-1.4-1.4-1.4h-2v-1c0-.1-.1-.2-.2-.2h-.6c-.1 0-.2.1-.2.2v1.1h-6.3v-1.1c0-.1-.1-.2-.2-.2h-.6c-.1 0-.2.1-.2.2v1.1h-1.9c-.8 0-1.4.6-1.4 1.3v3.4.8 6.8c0 .8.6 1.4 1.4 1.4h5.6c.2 0 .4-.2.4-.4s-.2-.4-.4-.4zm-6.2-11.4c0-.4.3-.7.7-.7h1.8v.7c0 .1.1.2.2.2h.6c.1 0 .2-.1.2-.2v-.7h6.3v.7c0 .1.1.2.2.2h.6c.1 0 .2-.1.2-.2v-.7h1.9c.4 0 .7.3.7.7v3.2h-13.4z"></path><path d="m4.1 12.4c.2 0 .4-.2.4-.4v-1.3h1.3c.2 0 .4-.2.4-.4-.1-.1-.2-.3-.4-.3h-1.3v-1.2c0-.2-.2-.4-.4-.4s-.4.2-.4.4v1.2h-1.2c-.2 0-.4.2-.4.4s.2.4.4.4h1.3v1.2c-.1.2.1.4.3.4z"></path></g></g></g></g></g></g></g></g></g>
                                        </svg>
                                        <span class="text-left-svg">
                                            <?= Yii::t('app', 'start_time_product') ?>: <b class="red"><?= date('d-m-Y', $model->start_time) ?></b>
                                        </span>
                                        
                                    </p>
                                <?php } ?>
                                <?php if($model->number_time) { ?>
                                    <p class="clears">
                                        <svg class="gcaeco-svg-icon icon-preorder" enable-background="new 0 0 18 18" viewBox="0 0 18 18" x="0" y="0">
                                            <g><g transform="translate(-517 -388)"><g transform="translate(155 224)"><g transform="translate(342)"><g transform="translate(17 20)"><g transform="translate(2)"><g transform="translate(0 143)"><g transform="translate(2 2)"><g><path d="m13.6 11.7h-1.3v-1.3c0-.2-.2-.4-.4-.4s-.4.2-.4.4v1.6c0 .2.2.4.4.4h1.7c.2 0 .4-.2.4-.4s-.2-.3-.4-.3z"></path><path d="m11.9 7.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1c0-2.2-1.8-4.1-4.1-4.1zm0 7.4c-1.8 0-3.3-1.5-3.3-3.3s1.5-3.3 3.3-3.3 3.3 1.5 3.3 3.3c0 1.9-1.4 3.3-3.3 3.3z"></path><path d="m7 14.2h-5.5c-.4 0-.7-.3-.7-.7v-6.7h13.4.8v-.8-3.4c0-.7-.6-1.4-1.4-1.4h-2v-1c0-.1-.1-.2-.2-.2h-.6c-.1 0-.2.1-.2.2v1.1h-6.3v-1.1c0-.1-.1-.2-.2-.2h-.6c-.1 0-.2.1-.2.2v1.1h-1.9c-.8 0-1.4.6-1.4 1.3v3.4.8 6.8c0 .8.6 1.4 1.4 1.4h5.6c.2 0 .4-.2.4-.4s-.2-.4-.4-.4zm-6.2-11.4c0-.4.3-.7.7-.7h1.8v.7c0 .1.1.2.2.2h.6c.1 0 .2-.1.2-.2v-.7h6.3v.7c0 .1.1.2.2.2h.6c.1 0 .2-.1.2-.2v-.7h1.9c.4 0 .7.3.7.7v3.2h-13.4z"></path><path d="m4.1 12.4c.2 0 .4-.2.4-.4v-1.3h1.3c.2 0 .4-.2.4-.4-.1-.1-.2-.3-.4-.3h-1.3v-1.2c0-.2-.2-.4-.4-.4s-.4.2-.4.4v1.2h-1.2c-.2 0-.4.2-.4.4s.2.4.4.4h1.3v1.2c-.1.2.1.4.3.4z"></path></g></g></g></g></g></g></g></g></g>
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
                        <?php if($model->status_quantity) { ?>
                        <!-- phí vận chuyển -->
                        <br/>
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
                            <?php if($model['fee_ship'] && $model['note_fee_ship']) { ?>
                                <br/>
                                    <span style="color: green; font-style: italic;"><?= nl2br($model['note_fee_ship']); ?></span>
                            <?php } ?>
                            <div class="addcart-detail-product">
                                <a class="btn-style-1 click" ><i class="fa fa-shopping-cart"></i><?= Yii::t('app', 'add_to_bag') ?></a>
                                <a class="chat-buyer btn-style-1"><i class="fa fa-check"></i><?= Yii::t('app', 'buy_now') ?></a>
                                <p class="tel-phone"><?= Yii::t('app', 'call_shopping') ?>:<a href="tel:<?= $siteinfo->hotline ?>"> <span><?= formatPhone($siteinfo->hotline) ?></span> </a></p>
                            </div>
                        </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-full">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="infor-detail-product">
                                <div class="infor-tab-detail">
                                    <ul>
                                        <li class="active"><a><?= Yii::t('app', 'product_description') ?></a></li>
                                        <li><a href="#review"><?= Yii::t('app', 'rate') ?></a></li>
                                    </ul>
                                </div>
                                <div class="ctn-detail-product">
                                    <div class="ctn-left-detail content-standard-ck">
                                        <?= nl2br($model['description']) ?>
                                    </div>
                                </div>
                                <div class="view-more-detail">
                                    <?= Yii::t('app', 'show_all_content') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <br/>
                        <p>
                            <b><?= Yii::t('app', 'address') ?></b>: <?= ($shop->address ? $shop->address . ', ' : '') . $shop->ward_name . ', ' . $shop->district_name . ', ' . $shop->province_name ?>
                        </p>
                        <style type="text/css">
                            body .ctn-left-detail {
                                height: 350px;
                            }
                        </style>
                        <!-- <p>
                            <b><?= Yii::t('app', 'phone') ?></b>: <?= formatPhone($shop->phone) ?>
                        </p> -->
                        <p>
                            <b><?= Yii::t('app', 'email') ?></b>: <?= $shop->email ?>
                        </p>
                    </div>
                    <!-- </div> -->
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
                                'category_id' => $model->category_id,
                            ],
                            'view' => 'hot_category',
                            '_product' => $model->id,
                            'limit' => 12,
                            'title' => Yii::t('app', 'product_relation'),
                            'order' => 'ishot DESC, id DESC'
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="white-full">
            <h2 class="title-full"><?= Yii::t('app', 'comment')  ?></h2>
            <div class="map">
                <?=
                \frontend\widgets\facebookcomment\FacebookcommentWidget::widget([
                        // 'view' => 'share',
                ])
                ?>
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
<?php if(!$model->status_quantity && !$check_register_product) { ?>
    <div id="register-box-popup" class="white-popup mfp-hide">
        <div class="box-account">
            <span class="mfp-close"></span>
            <div class="bg-pop-white">
                <h2><?= Yii::t('app', 'register_news_when_have_product') ?></h2>
                <p>
                    <?= Yii::t('app', 'register_news_when_have_product_2') ?>
                </p>
                <form action=""  id="form-register-pub">
                    <input required="" type="text" id="info-phone" minlength="9" maxlength="15" name="ProductRegisterInfo[phone]" placeholder="<?= Yii::t('app', 'enter_phone') ?>(*)" value="<?= isset($user->phone) ? $user->phone : '' ?>">
                    <input required="" type="email" id="info-email" name="ProductRegisterInfo[email]" placeholder="<?= Yii::t('app', 'enter_email') ?>(*)" value="<?= isset($user->email) ? $user->email : '' ?>">
                    <textarea style="width: 100%; min-height: 160px; border-color: #ebebeb; margin-bottom: 12px; padding: 20px;" id="info-note" name="ProductRegisterInfo[note]" placeholder="<?= Yii::t('app', 'enter_note') ?>"></textarea>
                    <input required="" type="hidden"  name="ProductRegisterInfo[product_id]"  value="<?= $model->id ?>">
                    <input required="" type="hidden"  name="ProductRegisterInfo[shop_id]"  value="<?= $model->shop_id ?>">
                    <center style="color: red" id="error-register"></center>
                    <button class="btn-register"><?= Yii::t('app', 'send') ?></button>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.btn-register').click(function () {
                    var _this = $(this);
                    $(this).css('display', 'none');
                    var form = $('#form-register-pub').serialize();
                    var url = '<?= Url::to(['/site/save-register-product']) ?>';
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form,
                        success: function (responce) {
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