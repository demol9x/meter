<?php

use yii\helpers\Url;
use common\models\product\Product;
use common\components\ClaHost;
use common\components\ClaLid;
use frontend\components\AttributeHelper;

$images = Product::getImages($model->id);
?>
<div class="detail-product-page">
    <div class="container">
        <div class="white-full">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    <div class="img-detail-product">
                        <div class="app-figure" id="zoom-fig">
                            <div class="big-img">
                                <a id="Zoom-1" class="MagicZoom" data-options="selectorTrigger: hover; transitionEffect: false;zoomDistance: 20;zoomWidth:520px; zoomHeight:500px;variableZoom: true" title="Show your product in stunning detail with Magic Zoom Plus." href="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>" >
                                    <img src="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>" />
                                </a>
                            </div>
                            <?php if (isset($images) && $images) { ?>
                                <div class="thumb-img">
                                    <div id="owl-detail" class="selectors">
                                        <?php foreach ($images as $img) { ?>
                                            <a data-zoom-id="Zoom-1" href="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>"
                                               data-image="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>">
                                                <img src="<?= ClaHost::getImageHost(), $img['path'], 's100_100/', $img['name'] ?>" />
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
                       <!--  <div class="sku-product">
                            <ul>
                                <li>
                                    <p><?= Yii::t('app', 'product_code') ?>:<span>#<?= $model['id'] ?> </span></p>
                                </li>
                            </ul>
                        </div> -->
                        <p>
                            <?= Yii::t('app', 'menu') ?>: <a href="<?= Url::to(['/product/product/category', 'id' => $category->id, 'alias' => $category->alias])  ?>"><?= $category->name  ?></a>
                        </p>
                        <div class="price-product">
                            <div class="item-price-product">
                                <?php 
                                $price_range = explode(',', $model->price_range);
                                $quality_range = explode(',', $model->quality_range);
                                if(!$model->price_range) {?>
                                    <p><?= $model['price'] ? number_format($model['price'], 0, ',', '.').' '.Yii::t('app', 'currency') : Yii::t('app','contact') ?></p>
                                    <?php if($model['price_market'] > 0) { ?>
                                        <span><?= number_format($model['price_market'], 0, ',', '.') ?> <?= Yii::t('app', 'currency') ?> </span>
                                    <?php } ?>
                                <?php } else{ 
                                    $price_range = explode(',', $model->price_range);
                                    $price_max =  number_format($price_range[0], 0, ',', '.');
                                    $price_min = number_format($price_range[count($price_range)-1], 0, ',', '.');
                                    ?>
                                    <p>
                                        <?= $price_max != $price_min ? $price_min.' - '.$price_max : $price_min ?>
                                        <?= Yii::t('app', 'currency') ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="description-product">
                            <ul>
                                <!--  <li>
                                    <p><?= Yii::t('app', 'product_code') ?>:<span>#<?= $model['id'] ?> </span></p>
                                </li>
                                <li>
                                    <p><?= Yii::t('app', 'status') ?>:<span class="upcase"><?= $model->status_quantity ? Yii::t('app', 'have_product') : Yii::t('app', 'not_product') ?></span></p>
                                </li> -->
                                <li>
                                    <p>
                                        Miễn phí vận chuyển cho đơn hàng từ 100.000đ 
                                    </p>
                                </li>
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
                                        <?php for ($i=1; $i <= 5 ; $i++) { 
                                            if( $i <= $model->rate) {
                                                ?> 
                                                <i class="fa fa-star yellow" aria-hidden="true"></i>
                                                <?php } else if($model->rate > (int)$model->rate && 1+ (int)$model->rate == $i)  { ?>
                                                <i class="fa fa-star-half-o yellow" aria-hidden="true"></i>
                                                <?php }else { ?>
                                                <i class="fa fa-star-o yellow" aria-hidden="true"></i>
                                             <?php }
                                        } ?>
                                        </a>
                                        <span>(<?= $model->rate_count ? $model->rate_count : 0 ?>)</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <?php if($model->price_range) { ?> 
                            <div class="table-shop table-banbuon">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label for="">Số lượng</label>
                                            </td>
                                            <td>
                                                <label for="">Giá</label>
                                            </td>
                                        </tr>
                                        <?php for ($i=0; $i < count($price_range); $i++) { ?>
                                            <tr>
                                                <td>
                                                    <p><?= $quality_range[$i+1] ? 'Từ '.$quality_range[$i].' - '.(($i != count($price_range)-1) ? $quality_range[$i+1]-1 : $quality_range[$i+1]) : '≥ '.$quality_range[$i] ?></p>
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
                        <p><?= Yii::t('app', 'status') ?>: <b class="red"><?= $model->status_quantity ? Yii::t('app', 'have_product') : Yii::t('app', 'not_product') ?></b></p>
                        <p>
                            Số lượng mua tối thiểu: <b class="red"><?= $model->quality_range ? $quality_range[0] : 1 ?></b>
                        </p>
                       <!--  <select name="" id="" class="address-ship">
                            <option value="Quận Cầu Giấy, Hà Nội">Quận Cầu Giấy, Hà Nội</option>
                            <option value="">Quận Tây Hồ, Hà Nội</option>
                            <option value="">Quận Tây Hồ, Hà Nội</option>
                            <option value="">Quận Tây Hồ, Hà Nội</option>
                            <option value="">Quận Tây Hồ, Hà Nội</option>
                            <option value="">Quận Tây Hồ, Hà Nội</option>
                        </select>
                        <select name="" id="" class="price-ship">
                            <option value="4.000 đ">4.000 đ</option>
                            <option value="">5.000 đ</option>
                            <option value="">6.000 đ</option>
                            <option value="">7.000 đ</option>
                            <option value="">8.000 đ</option>
                            <option value="">9.000 đ</option>
                        </select> -->
                        <em>Miễn phí vận chuyển cho đơn hàng có giá trị từ 90.000đ</em>
                        <div class="option-product-detail">
                            <div class="item-option-product-detail">
                                <label><?= Yii::t('app', 'quantity') ?>:</label>
                                <div class="quality-product-detail">
                                    <div class=" pull-left">
                                        <input onkeypress="isAlphaNum(event);" type="text" title="<?= Yii::t('app', 'quality') ?>" value="1" maxlength="12" id="qty" name="quantity" class="input-text" oninput="validity.valid||(value='');">
                                        <div class="btn_count">
                                            <button onclick="var result = document.getElementById('qty');
                                                    var qty = result.value;
                                                    if (!isNaN(qty))
                                                        result.value++;
                                                    return false;" class="increase items-count" type="button"><i class="fa fa-plus"></i></button>

                                            <button onclick="var result = document.getElementById('qty'); var qty = result.value; if (!isNaN(qty) && qty > 1) result.value--; return false;" class="reduced items-count" type="button"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="addcart-detail-product">
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#add-cart-href').click(function() {
                                            $('#add-cart-href').attr('href', '<?= Url::to(['/product/shoppingcart/add-cart', 'id' => $model['id'], 'quantity' => '']) ?>'+$('#qty').val());
                                        });
                                    });
                                </script>
                                <a class="btn-style-1" id="add-cart-href" href="<?= Url::to(['/product/shoppingcart/add-cart', 'id' => $model['id']]) ?>"><i class="fa fa-shopping-cart"></i><?= Yii::t('app', 'add_to_bag') ?></a>
                                <!-- <a class="chat-buyer btn-style-1"  href=""> <i class="fa fa-comments-o"></i><?= Yii::t('app', 'chat_with_user') ?></a> -->
                            </div>
                            <div class="social-detail-product">
                               <!--  <img src="images/fb-like.png" alt="">
                                <a href="">Xem các sản phẩm đã lưu ở đây</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <div class="infor-buyer-store">
                        <div class="helptext-store">
                            <!-- <b><?= Yii::t('app', 'ship_to') ?>:</b>  Tầng 19, Tòa nhà Saigon Centre – Tháp 2, Phường Bến Nghé, Quận 1
                            <a href=""><?= Yii::t('app', 'change') ?></a> -->
                        </div>
                        <div class="address-buyer-store">
                            <div class="page-store">
                                <div class="section-intro">
                                    <div class="left-intro">
                                        <?= frontend\widgets\html\HtmlWidget::widget([
                                                'input' => [
                                                    'model' => $shop,
                                                    'user' => $user
                                                ],
                                                'view' => 'view_shop_info_pd'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <?= nl2br($model['description'])  ?>
                            </div>
                        </div>
                        <div class="view-more-detail">
                            Hiển thị tất cả nội dung
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="white-full">
            <h2 class="title-full">Địa chỉ người bán</h2>
            <?=
                \frontend\widgets\html\HtmlWidget::widget([
                    'view' => 'map',
                    'input' => [
                        'center' => $shop,
                        'zoom' => 7,
                        'listMap' => $shopadd
                    ]
                ])
            ?>
        </div>
        <div class="full-width">
            <div class="row">
                <div class="product-inhome">
                    <div class="container">
                        <?= frontend\widgets\productAttr\ProductAttrWidget::widget([
                               'attr' =>[
                                    'category_id' => $model->category_id,
                               ],
                               'view' => 'hot_category',
                               'limit' =>12,
                               'title' => Yii::t('app', 'product_relation'),
                               'order' => 'ishot DESC, id DESC'
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="white-full">
            <h2 class="title-full">Bình luận</h2>
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
                'title' => Yii::t('app','item_reviews'),
                'data' => $model->attributes,
                'type' => common\models\rating\Rating::RATING_PRODUCT,
                'object_id' => $model->id
            ])
        ?>
    </div>
</div>

