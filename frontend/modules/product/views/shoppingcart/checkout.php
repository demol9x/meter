<?php
\Yii::$app->session->open();

use common\models\ActiveFormC;
use yii\helpers\Url;
use common\components\ClaHost;
use common\components\HtmlFormat;
use yii\bootstrap\ActiveForm;

?>

<div class="site51_cart_col9_giohang">
    <div class="container_fix mall">
        <div class="item_product_giohang">
            <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>
            <?php if (isset($data) && $data) { ?>
            <div class="item-list-sp-cart">
                <div class="title-list-cart">
                    <div class="item-tensp">
                        <h5 class="content_16">Tên sản phẩm</h5>
                    </div>
                    <div class="item-soluong">
                        <h5 class="content_16">Số lượng</h5>
                    </div>
                    <div class="item-gia">
                        <h5 class="content_16">Giá</h5>
                    </div>
                </div>

                <div class="list-cart-sp">
                    <?php
                    $totals = 0;
                    $count = 0;
                    foreach ($data as $key => $item) {
                    $url = Url::to([
                        '/product/product/detail',
                        'id' => $item['id'],
                        'alias' => HtmlFormat::parseToAlias($item['name'])
                    ]);
                    $total = $item['price'] * $item['quantity'];
                    $totals += $total;
                    $count = $count + $item['quantity']
                    ?>
                    <div class="item-sp-cart wow fadeInLeft" data-wow-delay="0.3s">
                        <div class="cart-sp">
                            <div class="left">
                                <div class="image">
                                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'] . $item['avatar_name'] ?>"
                                         alt="<?= $item['name'] ?>">
                                </div>
                                <div class="item-close"><span class="close">&times;</span></div>
                            </div>

                            <div class="right">
                                <a href="<?= $url ?>" title="" class="content_16"><?= $item['name'] ?></a>
                                <div class="custom custom-btn-numbers ">
                                    <button data-id="<?= $item['id'] ?>"
                                            class="btn-minus btn-cts items-count reduced" type="button">-
                                    </button>
                                    <div class="input">
                                        <input data-id="<?= $item['id'] ?>" type="text"
                                               class="qty input-text quantity-<?= $item['id'] ?> qtyItem number-sidebar"
                                               id="qty" name="quantity" size="4"
                                               value="<?= $item['quantity'] ?>" maxlength="10">
                                    </div>
                                    <button data-id="<?= $item['id'] ?>"
                                            class="btn-plus btn-cts items-count increase" type="button">+
                                    </button>
                                </div>
                                <div class="giaban">
                                    <p class="content_14 normal"><?= number_format($item['price_market'], 0, ',', '.') ?><?= Yii::t('app', 'currency') ?></p>
                                    <p class="title_18 sale"><?= number_format($item['price'], 0, ',', '.') ?><?= Yii::t('app', 'currency') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <script>
                    function updateShoppingcart(id, quantity, text) {
                        $.ajax({
                            url: "<?= Url::to(['/product/shoppingcart/update']) ?>",
                            data: {id: id, 'quantity': quantity},
                            success: function (result) {
                                var re_arr = JSON.parse(result);
                                console.log(re_arr);
                                $('.price-' + re_arr['id']).html(formatMoney(re_arr['price'], 0, ',', '.') + ' ' + text);
                                $('.price-sum-' + re_arr['id']).html(formatMoney(re_arr['order'], 0, ',', '.'));
                                $('.quantity-' + re_arr['id']).first().val(re_arr['quantity']);
                            }
                        });
                    }

                    $('.reduced').click(function () {
                        var id = $(this).attr('data-id');
                        var value = parseInt($('.quantity-' + id).first().val());
                        var result = $('.quantity-' + id);
                        if (value > 1)
                            result.val(value - 1);
                        return false;
                    });

                    $('.increase').click(function () {
                        var id = $(this).attr('data-id');
                        var value = parseInt($('.quantity-' + id).first().val());
                        var result = $('.quantity-' + id);
                        result.val(value + 1);
                        return false;
                    });

                    $('.items-count').click(function () {
                        var text = ' <?= Yii::t('app', 'currency') ?>';
                        var id = $(this).attr('data-id');
                        var quantity = parseInt($('.quantity-' + id).val());
                        updateShoppingcart(id, quantity, text);
                        location.reload();
                    });

                    $('.number-sidebar').change(function () {
                        var text = ' <?= Yii::t('app', 'currency') ?>';
                        var id = $(this).attr('data-id');
                        var quantity = parseInt($('.quantity-' + id).val());
                        updateShoppingcart(id, quantity, text);
                        location.reload();
                    });
                </script>
                <?php } ?>
                <div class="item_provisional">
                    <h5 class="title_18">Tạm tính (<?= $count ?> sản phẩm):</h5>
                    <p class="title_24 price-sum-<?= $item['id'] ?>"><?= number_format($totals, 0, ',', '.') ?><?= Yii::t('app', 'currency') ?></p>
                </div>
                <div class="Buy-more-sp">
                    <a href="<?= Url::to(['/product/product/index']) ?>" title="">
                        <div class="item-more"><span class="more">&times;</span></div>
                        <p class="content_16">Mua thêm sản phẩm</p>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
        <style>
            .item_product_information {
                float: left;
                width: 100%;
            }

            .site51_cart_col9_giohang .item_t .content_16 {
                width: 48%;
                float: left;
                margin-bottom: 30px;
            }

            .site51_cart_col9_giohang .item_t .content_16:nth-child(2n) {
                float: right;
            }

            .site51_cart_col9_giohang .item_customer_information .item_product_information input {
                height: 55px;
                padding-left: 57px;
                outline: 0;
                border: 0;
                background: #FFFFFF;
                border: 1px solid #E0E0E0;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                border-radius: 5px;
            }

            .site51_cart_col9_giohang .item_customer_information .item_to_receive_goods .Choose-address .form select {
                height: 55px;
                width: 100%;
                padding-left: 15px;
                outline: 0;
                cursor: pointer;
                color: #828282;
                border: 1px solid #F2F2F2;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                border-radius: 5px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background: url(<?=Yii::$app->homeUrl?>images/site41/arrow_sl.png);
                background-repeat: no-repeat;
                background-position: 93%;
                background-color: #FFFFFF;
                margin-bottom: 0;
            }

            .help-block {
                margin: 0;
            }

            .site51_cart_col9_giohang .item_customer_information .item_to_receive_goods .Choose-address .form {
                position: relative;
                background: #FAFAFA;
                border-radius: 5px;
                padding: 17px 12px;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                -webkit-box-pack: justify;
                -ms-flex-pack: justify;
                justify-content: space-between;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                margin-bottom: 30px;
            }

            .site51_cart_col9_giohang .item_customer_information .item_to_receive_goods .Choose-address .appointment-schedule {
                width: 100%;
                padding: 20px 15px;
                padding-bottom: 0;
                background: #FFFFFF;
                border-radius: 5px;
                border: 1px solid #F2F2F2;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                margin-bottom: 20px;
            }

            .m-t-30 {
                margin-top: 30px;
            }
        </style>
        <div class="item_customer_information">
            <?php
            $form = ActiveFormC::begin([
                'id' => 'form-signup',
                'options' => [
                    'class' => 'form-horizontal'
                ]
            ]);
            ?>
            <h3 class="title_21">Thông tin khách hàng</h3>
            <div class="item_product_information wow fadeInDown item_t" data-wow-delay="0.3s">
                <div class="sex">

                    <label>
                        <input class="Dashboard" name="Order[sex]" checked="checked" type="radio" aria-required="true"
                               aria-invalid="true" value="1">
                        <p class="content_16">Anh</p>
                    </label>
                    <label>
                        <input class="Dashboard" name="Order[sex]" type="radio" aria-required="true"
                               aria-invalid="true" value="0">
                        <p class="content_16">Chị</p>
                    </label>

                </div>

                <div class="content_16">
                    <?=
                    $form->field($model, 'name', [
                        'template' => '{label}{input}{hint}{error}'
                    ])->textInput([
                        'placeholder' => Yii::t('app', 'full_name')
                    ])->label(false)
                    ?>
                </div>
                <div class="content_16">
                    <?=
                    $form->field($model, 'phone', [
                        'template' => '{label}{input}{hint}{error}'
                    ])->textInput([
                        'placeholder' => Yii::t('app', 'phone')
                    ])->label(false)
                    ?>
                </div>
            </div>

            <h3 class="title_21">Chọn cách thức nhận hàng</h3>
            <div class="item_to_receive_goods wow fadeInDown" data-wow-delay="0.3s">
                <div class="to-receive item_t">
                    <label>
                        <input class="Dashboard" checked="checked" type="radio" name="Order[shipping_method]" value="0">
                        <p class="">Giao tận nơi</p>
                    </label>
                    <label>
                        <input class="Dashboard" type="radio" name="Order[shipping_method]" value="1">
                        <p class="">Nhận tại siêu thị</p>
                    </label>
                </div>
                <div class="Choose-address item_t">
                    <p class="content_16">Chọn địa chỉ để biết thời gian nhận hàng và phí vận chuyển (nếu có)</p>
                    <div class="form">
                        <div class="content_16">
                            <?=
                            $form->field($model, 'province_id', [
                                'template' => '{label}{input}{hint}{error}'
                            ])->dropDownList($listProvince, [
                                'class' => ' select-province-id',
                            ])->label(false)
                            ?>
                        </div>
                        <div class="content_16">
                            <?=
                            $form->field($model, 'district_id', [
                                'template' => '{label}{input}{hint}{error}'
                            ])->dropDownList($listDistrict, [
                                'class' => ' select-district-id',
                                'prompt' => 'Chọn Quận/Huyện'
                            ])->label(false)
                            ?>
                        </div>
                        <div class="content_16">
                            <?=
                            $form->field($model, 'ward_id', [
                                'template' => '{label}{input}{hint}{error}'
                            ])->dropDownList($listWard, [
                                'class' => ' select-ward-id',
                                'prompt' => 'Chọn Phường/Xã'
                            ])->label(false)
                            ?>
                        </div>
                        <div class="content_16">
                            <?=
                            $form->field($model, 'address', [
                                'template' => '{label}{input}{hint}{error}'
                            ])->textInput([
                                'class' => '',
                                'placeholder' => 'Thôn/Xóm/Số nhà'
                            ])->label(false)
                            ?>
                        </div>
                        <div class="appointment-schedule">
                            <div class="top-schedule">
                                <p class="content_16">Giao trước 17h hôm nay (<?= date('d/m', time()) ?>)</p>
                                <a href="" title="" class="content_16">Chọn ngày giờ khác</a>
                                <input class="hidden">
                            </div>
                            <div class="all-sp-schedule">
                                <?php
                                $totals = 0;
                                $count = 0;
                                foreach ($data as $key => $item) {
                                    $url = Url::to([
                                        '/product/product/detail',
                                        'id' => $item['id'],
                                        'alias' => HtmlFormat::parseToAlias($item['name'])
                                    ]);
                                    $total = $item['price'] * $item['quantity'];
                                    $totals += $total;
                                    $count = $count + $item['quantity']
                                    ?>
                                    <a href="<?= $url ?>" title="<?= $item['name'] ?>">
                                        <div class="sp-schedule">
                                            <div class="image">
                                                <img src="<?= ClaHost::getImageHost(), $item['avatar_path'] . $item['avatar_name'] ?>"
                                                     alt="<?= $item['name'] ?>">
                                            </div>
                                            <div class="tt-title-sp">
                                                <h5 class="content_16"><?= $item['name'] ?></h5>
                                                <p class="content_14">Số lượng: <?= $item['quantity'] ?></p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <a href="" title="" class="content_16">Miễn phí giao hàng</a>
                    </div>
                </div>

                <h4 class="title_18">Chọn hình thức thanh toán</h4>
                <input type="hidden" name="Orders['payment_method']" value="1">
                <div class="item-payments">
                    <button class="button-pay content_16">
                        Thanh toán tiền mặt khi nhận hàng
                    </button>
                    <button class="button-pay content_16">
                        Chuyển khoản ngân hàng
                    </button>
                    <button class="button-pay content_16">
                        Thanh toán thẻ ATM (Có internet Banking)
                    </button>
                    <button class="button-pay content_16">
                        Thanh toán thẻ
                        <img src="<?= Yii::$app->homeUrl ?>images/tnh.png">
                    </button>
                </div>
                <?=
                $form->field($model, 'note', [
                    'template' => '{label}{input}{hint}{error}'
                ])->textInput([
                    'class' => 'content_16',
                    'placeholder' => 'Yêu cầu khác (Không bắt buộc)'
                ])->label(false)
                ?>
                <ul class="m-t-30">
                    <li>
                        <label>
                            <input class="Dashboard" name="" type="checkbox" value="1">
                            <p class="content_16">Gọi ngưới khác nhận hàng (nếu có)</p>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input class="Dashboard" name="" type="checkbox" value="2">
                            <p class="content_16">Hướng dẫn sử dụng, giải đáp thắc mắc sản phẩm (nếu có)</p>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input class="Dashboard" name="" type="checkbox" value="3">
                            <p class="content_16">Xuất hóa đơn công ty</p>
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        <div class="item-total-amount">
            <div class="item-total-top wow fadeInDown" data-wow-delay="0.3s">
                <div class="deal-item content_16">Dùng mã giảm giá</div>
                <div class="form">
                    <div class="item-deal-input">
                        <input class="content_16" type="text" name="" id="" placeholder="Nhập mã giảm giá">
                        <button class="content_16">Áp dụng</button>
                    </div>
                </div>
            </div>
            <div class="item-total-bott wow fadeInDown" data-wow-delay="0.3s">
                <div class="total">
                    <h5 class="title_21">Tổng tiền:</h5>
                    <p class="title_24"><?= number_format($totals, 0, ',', '.') ?><?= Yii::t('app', 'currency') ?></p>
                </div>
                <div class="item-btn-order">
                    <a href="javascript:void(0)" onclick="$('.form-horizontal').submit()" class="title_18 butt">Đặt
                        hàng</a>
                    <p class="content_16">Có thể lựa chọn hình thức thanh toán sau khi đặt hàng</p>
                </div>
            </div>
        </div>
        <?php ActiveFormC::end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.select-province-id').change(function () {
            var province_id = $(this).val();
            $.getJSON(
                "<?= \yii\helpers\Url::to(['/suggest/getdistrict']) ?>",
                {province_id: province_id, label: '<?= Yii::t('app', 'district') ?>'}
            ).done(function (data) {
                $('.select-district-id').html(data.html);
                $('.select-ward-id').html('<option value="0">Phường/xã</option>');
                $('select').niceSelect('update');
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        });

        $('.select-district-id').change(function () {
            var district_id = $(this).val();
            $.getJSON(
                "<?= \yii\helpers\Url::to(['/suggest/getward']) ?>",
                {district_id: district_id, label: '<?= Yii::t('app', 'ward') ?>'}
            ).done(function (data) {
                $('.select-ward-id').html(data.html);
                $('select').niceSelect('update');
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        });
    });
</script>
