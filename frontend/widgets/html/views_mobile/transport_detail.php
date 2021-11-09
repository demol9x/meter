<?php 
$location = \common\components\ClaLid::getLocaltionDefault();
$location_shop = \common\models\shop\ShopAddress::getByShop($shop->id);

?>
<style type="text/css">
    .title-detail-product em {
        font-weight: normal;
    }
    #cost-transport {
        color: red;
        font-weight: bold;
    }
    .item-option-product-detail label {
        font-weight: normal;
    }
    body .nice-select {
        border: 0px solid #e8e8e8; 
        padding-left: 0px;
        padding-right: 0px;
    }
    body .title-detail-product .nice-select {
        margin-bottom: 0px;
    }
    .location-form span {
        color: #17a349;
        font-weight: 500;
    }
    .location-form b{
        color: #232121;
        font-weight: normal;
        margin-right: 2px;
    }
    body .title-detail-product .nice-select.address-ship .current:after {
        content: "Đến:";
        font-weight: normal;
    }
    body .title-detail-product .nice-select.transport-method .current:after {
        content: "Vận chuyển:";
        font-weight: normal;
    }
    body .title-detail-product .nice-select.address-shop .current:after {
        content: "Giao hàng từ:";
        font-weight: normal;
        position: absolute;
        left: 0px;
        top: -1px;
        line-height: 20px;
        white-space: nowrap;
        color: #232121;
    }
    .open .box-select-province-shop {
        display: block;
    }
    .title-detail-product .nice-select.transport-method .current, .title-detail-product .nice-select.address-ship .current, .title-detail-product .nice-select.address-shop .current{
        padding-left: 87px;
    }
    .title-detail-product .nice-select.transport-method {
        margin-top: -9px;
        margin-bottom: -6px;
    }
}
</style>   
<div class="nice-select address-shop" tabindex="0">
    <span id="input-province-shop" data-shop-address-id="<?= ($item = \common\models\shop\ShopAddress::getDefautByShop($shop['id'])) ? $item['id'] : 0 ?>" data-provine-shop-name="<?= $shop->province_name ?>" data-provine-shop="<?= $shop->province_id ?>" data-district-shop-name="<?= $shop->district_name ?>" data-district-shop="<?= $shop->district_id ?>" class="current"><?= $shop->ward_name.'-'.$shop->district_name.' - '.$shop->province_name ?></span>
    <ul class="list box-select-province-shop">
        <?php 
            foreach ($location_shop as $item) { 
                ?>
                <li data-shop-address-id="<?= $item->id ?>" data-provine-shop-name="<?= $item->province_name ?>" data-provine-shop="<?= $item->province_id ?>" data-district-shop-name="<?= $item->district_name ?>" data-district-shop="<?= $item->district_id ?>"  class="option change-address-from"><?= $item->ward_name.'-'.$item->district_name.' - '.$item->province_name ?>
                </li>
            <?php 
        } ?>
    </ul>
</div>
<?php
use yii\helpers\Url;
$list_province = \common\models\Province::optionsProvince();
$producttransports = \common\models\transport\ProductTransport::getByProduct($model->id);
    if($producttransports) { 
        $default = $producttransports[0];
        foreach ($producttransports as $value) {
            if($value['default']) {
                $default = $value;
            }
        }
        ?>
        <div class="nice-select address-ship nice-selects" tabindex="0">
            <span id="input-province" data-provine-name="<?= $location['province_name'] ?>" data-provine="<?= $location['province_id'] ?>" data-district-name="<?= $location['district_name'] ?>" data-district="<?= $location['district_id'] ?>" class="current"><?= $location['district_name'] ? $location['district_name'].' - '.$location['province_name'] : 'Chọn địa điểm' ?></span>
            <ul class="lists box-select-province">
                <?php 
                    unset($list_province['']);
                    foreach ($list_province as $key => $value) { 
                        ?>
                        <li data-value="<?= $value ?>" data-key="<?= $key ?>" class="option-1s" data-load="0"><?= $value ?>
                            <ul class="lists">
                            </ul>
                        </li>
                    <?php 
                } ?>
            </ul>
        </div>
        <div class="nice-select transport-method" tabindex="0">
            <span id="input-transport" data-id="<?= $default['transport_id'] ?>" data-name="<?= $default['name'] ?>" class="current"><?= $default['name'] ?></span>
            <ul class="list">
                <?php foreach ($producttransports as $default) { ?>
                    <li data-value="<?=  $default['name'] ?>" data-key="<?=  $default['transport_id'] ?>" class="option change-transport"><?=  $default['name'] ?></li>
                <?php } ?>
            </ul>
        </div>
        
        <em id="fee-ship" data-price="0"><?= Yii::t('app', 'transport_fee') ?> : <span id="cost-transport">0</span></em>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.option-1s').click(function() {
                    $('.nice-selects').addClass('open2');
                    var _this = $(this);
                    if(_this.hasClass('active')) {
                        _this.removeClass('active');
                    } else {
                        _this.addClass('active');
                        var id =  _this.attr('data-key');
                        if(_this.attr('data-load') == '0') {
                             _this.find('.lists').html('<li class=""> >> <?= Yii::t('app', 'loading_district') ?></li>');
                            jQuery.ajax({
                                url: '<?= Url::to(['/suggest/get-district1']) ?>',
                                data:{province_id : id},
                                beforeSend: function () {
                                },
                                success: function (res) {
                                    _this.find('.lists').html(res);
                                    _this.attr('data-load', '1');
                                },
                                error: function () {
                                }
                            });
                        }
                    }
                });
                $('.change-transport').click(function() {
                    $('#input-transport').attr('data-id', $(this).attr('data-key'));
                    $('#input-transport').attr('data-name', $(this).attr('data-value'));
                    getCostTransport();
                });
            });

            function getCostTransport() {
                var f_district =  $('#input-province-shop').attr('data-district-shop-name');
                var f_province =  $('#input-province-shop').attr('data-provine-shop-name');
                var t_province =   $('#input-province').attr('data-provine-name');
                var t_district =   $('#input-province').attr('data-district-name');
                var method = $('#input-transport').attr('data-id');
                var weight = <?= $model->weight ? $model->weight : 1 ?>*$('#qty').val();
                var length = <?= $model->length ? $model->length : 110 ?>;
                var height = <?= $model->height ? $model->height : 10 ?>;
                var width = <?= $model->width ? $model->width : 10 ?>*$('#qty').val();
                var href= '<?= Url::to(['/transport/get-cost-transport']) ?>';
                var data = {
                            f_district : f_district, 
                            f_province : f_province, 
                            t_province : t_province, 
                            t_district : t_district, 
                            method : method, 
                            weight : weight,
                            length : length,
                            height : height,
                            width : width
                        };
                createCookie('<?= \common\components\ClaCookie::getNameCookieShopTransport($shop['id']) ?>', method);
                loadAjaxPost(href, data, $('#cost-transport'));
                $('#fee-ship').css('display', 'block');
            }
            setTimeout(function(){ getCostTransport(); }, 2000);
        </script>
    <?php 
} ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.change-address-from').click(function() {
            $('#input-province-shop').attr('data-provine-shop-name', $(this).attr('data-provine-shop-name'));
            $('#input-province-shop').attr('data-provine-shop', $(this).attr('data-provine-shop'));
            $('#input-province-shop').attr('data-district-shop-name', $(this).attr('data-district-shop-name'));
            $('#input-province-shop').attr('data-district-shop', $(this).attr('data-district-shop'));
            $('#input-province-shop').attr('data-shop-address-id', $(this).attr('data-shop-address-id'));
            createCookie('<?= \common\components\ClaCookie::getNameCookieShopAddress($shop['id']) ?>', $(this).attr('data-shop-address-id'));
            <?php if($producttransports) {  ?>
                getCostTransport();
            <?php } ?>
        });
    });
</script>