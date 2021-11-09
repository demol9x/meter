<?php 
use frontend\components\Transport;
use common\components\shipping\ClaShipping;
use common\models\Districts;
use yii\helpers\Url;
$location_shop = \common\models\shop\ShopAddress::getByShop($shop['id']);
$address_shop_defaut = $shop;
$id_defaut = common\components\ClaCookie::getValueCookieShopAddress($shop['id']);
$id_defaut_transport = common\components\ClaCookie::getValueCookieShopTransport($shop['id']);
if(!($id_defaut === false)) {
    foreach ($location_shop as $item) {
        if($id_defaut == $item['id']) {
            $address_shop_defaut = $item;
        }
    }
}
?>
<div class="title-user-shop">
    <div class="name-user-shop title-detail-product">
        <div class="nice-select address-shop" tabindex="0">
            <span id="input-province-shop-<?= $shop["id"] ?>" data-provine-shop-name="<?= $address_shop_defaut->province_name ?>" data-provine-shop="<?= $address_shop_defaut->province_id ?>" data-district-shop-name="<?= $address_shop_defaut->district_name ?>" data-district-shop="<?= $address_shop_defaut->district_id ?>" class="current"><?= $address_shop_defaut->ward_name.'-'.$address_shop_defaut->district_name.' - '.$address_shop_defaut->province_name ?></span>
            <ul class="list box-select-province-shop">
                <?php 
                    foreach ($location_shop as $item) { 
                        ?>
                        <li  data-shop-address-id="<?= $item->id ?>" data-provine-shop-name="<?= $item->province_name ?>" data-provine-shop="<?= $item->province_id ?>" data-district-shop-name="<?= $item->district_name ?>" data-district-shop="<?= $item->district_id ?>"  class="option change-address-from-<?= $shop["id"] ?>"><?= $item->ward_name.'-'.$item->district_name.' - '.$item->province_name ?>
                        </li>
                    <?php 
                } ?>
            </ul>
        </div>
        <?php if($transports) { ?> 
            <?php 
                $default = $transports[0];
                foreach ($transports as $value) {
                    if($id_defaut_transport !== false) {
                        if($value['transport_id'] == $id_defaut_transport) {
                            $default = $value;
                            break;
                        }
                    } else {
                        if($value['default']) {
                            $default = $value;
                            break;
                        }
                    }
                    
                }
            ?>
            <div class="nice-select transport-method" tabindex="0">
                <span id="input-transport-<?= $shop['id'] ?>" data-id="<?= $default['transport_id'] ?>" data-name="<?= $default['name'] ?>" class="current"><?= $default['name'] ?></span>
                <ul class="list" id="change-transport-<?= $shop['id'] ?>">
                    <?php foreach ($transports as $value) { ?>
                        <li data-value="<?=  $value['name'] ?>" data-key="<?=  $value['transport_id'] ?>" class="option change-transport-<?= $shop['id'] ?>"><?=  $value['name'] ?></li>
                    <?php } ?>
                </ul>
            </div>
            <?php
                $weight = \frontend\components\Shoppingcart::getWeight($shop['id']);
                $info3 = \frontend\components\Shoppingcart::getInfo3($shop['id']);
                $length = $info3['length'] ? $info3['length'] : 10;
                $width = $info3['width'] ? $info3['width'] : 110;
                $height = $info3['height'] ? $info3['height'] : 20;
                switch ($default['transport_id']) {
                    case ClaShipping::METHOD_GHTK:
                        $cost = Transport::getCost($shop['id'], $default['transport_id'], [
                            'data' => [
                                "pick_province" => $address_shop_defaut['province_name'],
                                "pick_district" => $address_shop_defaut['district_name'],
                                "pick_address" => $address_shop_defaut['address'].', '.$address_shop_defaut['ward_name'],
                                "province" => $address['province_name'],
                                "district" => $address['district_name'],
                                'address' => $address['address'].', '.$address['ward_name'],
                                "weight" => $weight,
                                "ServiceID" => '',
                                //không bắt buộc
                                "value" => 0,//price
                            ]
                        ]);
                        break;
                    case ClaShipping::METHOD_GHN:
                        $id_f = Districts::findGhnId(trim($address_shop_defaut['district_name']));
                        $id_t = Districts::findGhnId(trim($address['district_name']));
                        $cost = Transport::getCost($shop['id'], $default['transport_id'], [
                            'data' => [
                                "Weight" =>(int)$weight,
                                "Length" => $length,
                                "Width" => $width,
                                "Height" => $height,
                                "FromDistrictID" => (int)$id_f,
                                "ToDistrictID" => (int)$id_t,
                                "ServiceID" => '',
                                "OrderCosts" =>  [
                                ],
                                // "CouponCode"  => "COUPONTEST",//mã giam giá nếu có
                                "InsuranceFee"  =>  0 // giá trị gói
                            ]
                        ]);
                        break;
                    default:
                        $cost = Transport::getCost($shop['id'], 0, [
                            'data' => [
                               
                            ]
                        ]);
                        break;
                }
               
            ?>
            <p class="fee-ship">
                Phí vận chuyển: 
                <span id="cost-transport-<?= $shop['id'] ?>" data-price="<?= $cost ? $cost : 0 ?>" class="red">
                    <?php
                        if($cost) {
                            echo number_format($cost, 0, ',', '.').' '.Yii::t('app', 'currency');
                        } else {
                            echo Yii::t('app', 'not_price');
                        }
                    ?>
                </span>
            </p>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('.change-transport-<?= $shop["id"] ?>').click( function() {
                        $('#input-transport-<?= $shop['id'] ?>').attr('data-id', $(this).attr('data-key'));
                        $('#input-transport-<?= $shop['id'] ?>').attr('data-name', $(this).attr('data-value'));
                        getCostTransport<?= $shop["id"] ?>();
                    });
                })

                function getCostTransport<?= $shop["id"] ?>() {
                    var f_province = $('#input-province-shop-<?= $shop["id"] ?>').attr('data-provine-shop-name');
                    var f_district = $('#input-province-shop-<?= $shop["id"] ?>').attr('data-district-shop-name');
                    var f_address =  '';
                    var t_province =  '<?= $address['province_name'] ?>';
                    var t_district =  '<?= $address['district_name'] ?>';
                    var t_address =  '<?= $address['address'].', '.$address['ward_name'] ?>';
                    var method = $('#input-transport-<?= $shop['id'] ?>').attr('data-id');
                    var weight = '<?= $weight ?>';
                    var width = '<?= $width ?>';
                    var height = '<?= $height ?>';
                    var length = '<?= $length ?>';
                    var shop_id = '<?= $shop['id'] ?>';
                    $('#cost-transport-<?= $shop['id'] ?>').html('<img style="padding:5px 10px;" src="images/ajax-loader.gif" />');
                    $('#total-<?= $shop["id"] ?>').html('<img style="padding:5px 10px;" src="images/ajax-loader.gif" />');
                    jQuery.ajax({
                        url: '<?= Url::to(['/transport/get-cost-transport-shop']) ?>',
                        data:{f_district : f_district, f_province : f_province, t_province : t_province, t_district : t_district, method : method, weight : weight, width : width, height : height, length : length, shop_id :shop_id, f_address:f_address, t_address: t_address},
                        method: 'post',
                        beforeSend: function () {
                        },
                        success: function (res) {
                            var price = '<?= Yii::t('app', 'not_price') ?>';
                            var price2 = 0;
                            if(res && !isNaN(res)) {
                                price2 = res;
                                price = formatMoney(res,0, ',', '.')+' <?= Yii::t('app', 'currency') ?>';
                            } else if(res) {
                                price = res;
                            }
                            $('#cost-transport-<?= $shop['id'] ?>').html(price);
                            $('#cost-transport-<?= $shop['id'] ?>').attr('data-price',price2);
                            updatePrice(<?= $shop["id"] ?>);
                        },
                        error: function () {
                        }
                    });
                }
            </script>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // alert(getCookie('shop_123'));
        $('.change-address-from-<?= $shop["id"] ?>').click(function() {
            $('#input-province-shop-<?= $shop["id"] ?>').attr('data-provine-shop-name', $(this).attr('data-provine-shop-name'));
            $('#input-province-shop-<?= $shop["id"] ?>').attr('data-provine-shop', $(this).attr('data-provine-shop'));
            $('#input-province-shop-<?= $shop["id"] ?>').attr('data-district-shop-name', $(this).attr('data-district-shop-name'));
            $('#input-province-shop-<?= $shop["id"] ?>').attr('data-district-shop', $(this).attr('data-district-shop'));
            createCookie('<?= \common\components\ClaCookie::getNameCookieShopAddress($shop['id']) ?>', $(this).attr('data-shop-address-id'));
            <?php if($transports) {  ?>
                getCostTransport<?= $shop["id"] ?>();
            <?php } ?>
        });
    });
</script>