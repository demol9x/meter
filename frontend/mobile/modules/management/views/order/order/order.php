<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
use common\models\Province;
use common\models\District;
?>
<style type="text/css">
    .bg-pop-white {
        min-height: 400px;
    }
    .bg-pop-white > img{
        margin-left: 47%;
    }
    .code-item {
        font-size: 16px;
    }
    .bottom-item-info-donhang .btn-view-shop {
        height: unset;
    }
    .bottom-item-info-donhang .code-donhang a {
        line-height: 36px;
        height: 35px;
        text-transform: uppercase;
        font-weight: 500;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        -webkit-border-radius: 12px;
        -moz-border-radius: 12px;
        border-radius: 3px;
        background-color: #17a349;
        -webkit-box-shadow: 2px 3px 6px rgba(0, 0, 0, 0.25);
        -moz-box-shadow: 2px 3px 6px rgba(0, 0, 0, 0.25);
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25);
        color: #fff !important;
        font-size: 13px;
        display: inline-block;
        padding: 0px 20px;
        white-space: nowrap;
        font-family: "Roboto", Arial, sans-serif;
        border: none;
        margin-bottom: 11px;
        border: 1px solid #17a349;
        transition: all 0.4s ease;
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        -ms-transition: all 0.4s ease;
        margin-left: 20px;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="images/ico-hoso.png" alt=""> <?= Yii::t('app', 'order_management') ?>
        </h2>
    </div>
    <div class="nav-donhang">
        <ul class="tab-menu">
            <li class="active"> <a id="1" href="javascript:void(0);"><?= Yii::t('app', 'new_order') ?></a> </li>
            <li>
                <a id="2" class="load-st-2 click" data="1"><?= Yii::t('app', 'order_waiting_add') ?></a>
            </li>
            <li>
                <a id="3" class="load-st-3 click" data="1"><?= Yii::t('app', 'order_waiting_transport') ?></a>
            </li>
            <li>
                <a id="4" class="load-st-4 click" data="1"><?= Yii::t('app', 'order_recived') ?></a>
            </li>
            <li>
                <a id="5" class="load-st-0 click" data="1"><?= Yii::t('app', 'order_canced') ?></a>
            </li>
        </ul>
    </div>
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-1" style="display: block;">
    <?php if($shop_orders) foreach ($shop_orders as $shop_order) { 
        $s_url = Url::to(['/shop/shop/detail', 'id' => $shop_order['shop_id'], 'alias' =>$shop_order['s_alias']]);
        ?>
        <div class="item-info-donhang" id="box-b1-<?= $shop_order['id'] ?>">
            <div class="title">
                <div class="img">
                    <a href="<?= $s_url ?>">
                        <img src="<?= ClaHost::getImageHost(), $shop_order['s_avatar_path'], $shop_order['s_avatar_name'] ?>" alt="<?= $shop_order['s_name'] ?>">
                        <?= $shop_order['s_name'] ?>
                    </a>
                </div>
                <div class="btn-view-shop">
                    <a href="<?=$s_url ?>"><i class="fa fa-home"></i><?= Yii::t('app', 'view_shop') ?></a>
                </div>
            </div>
            <?php if(isset($products[$shop_order['id']]) && $products[$shop_order['id']]) foreach ($products[$shop_order['id']] as $product) {
                $url = Url::to(['/product/product/detail', 'id' => $product['product_id'], 'alias' => $product['alias']]);
                 ?>
                <div class="table-donhang table-shop">
                    <table>
                        <tbody>
                            <tr>
                                <td width="100">
                                    <div class="img"><a href="<?= $url ?>"><img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>" alt="<?= $product['product_name'] ?>"></a></div>
                                </td>
                                <td class="vertical-top" width="250">
                                    <h2><a href="<?= $url ?>"><?= $product['product_name'] ?></a></h2>
                                    <span class="quantity">x<?= $product['quantity'] ?></span>
                                </td>
                                <td>
                                    <p class="price-donhang"><?= number_format($product['price'], 0, ',', '.').' '.Yii::t('app', 'currency') ?></p>
                                </td>
                                <td style="text-align: right;">
                                    <p class="price-donhang">
                                        <?= number_format($product['price']*$product['quantity'], 0, ',', '.').' '.Yii::t('app', 'currency')  ?>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            <div class="title bottom-item-info-donhang">
                <p class="code-item"><?= Yii::t('app', 'orders') ?>: <b>OR<?= $shop_order['order_id'] ?></b></p>
                <div class="btn-view-shop">
                    <p>
                        <?= Yii::t('app', 'transport_fee') ?>:  <?= number_format($shop_order['shipfee'], 0, ',', '.').' '.Yii::t('app', 'currency')  ?>
                    </p>
                    <p>
                        <?= Yii::t('app', 'sum') ?>: <?= number_format($shop_order['order_total'] + $shop_order['shipfee'], 0, ',', '.').' '.Yii::t('app', 'currency')  ?>
                    </p>
                    
                </div>
                <div class="code-donhang">
                    <a class="open-popup-link open-popup-link-b1" data-id="<?= $shop_order['id'] ?>" href="#donhang-chuanbi1"><?= Yii::t('app', 'ready_order') ?></a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-2" id="box-st-2" style="display: none;">
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-3" id="box-st-3" style="display: none;">
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-4" id="box-st-4" style="display: none;">
</div>
<div class="ctn-donhang tab-menu-read tab-menu-read-5" id="box-st-0" style="display: none;">
</div>
<div id="donhang-review4" class="white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup">
                <h2><?= Yii::t('app', 'view_rate_product') ?>: <b id="add-name-product"></b></h2>
            </div>
            <div class="ctn-review-popup" id="content-data-review">
            </div>
        </div>
    </div>
</div>
<div id="donhang-chuanbi4" class="donhang-chuanbi white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup">
                <h2><?= Yii::t('app', 'order_detail') ?></h2>
            </div>
            <div class="ctn-popup">
                <div class="box-detail-order"  id="box-detail4">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="donhang-chuanbi3" class="donhang-chuanbi white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup">
                <h2><?= Yii::t('app', 'order_detail') ?></h2>
            </div>
            <div class="ctn-popup">
                <div class="box-detail-order"  id="box-detail3">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="donhang-chuanbi2" class="donhang-chuanbi white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup">
                <h2><?= Yii::t('app', 'order_check_11') ?></h2>
            </div>
            <div class="ctn-popup">
                <div class="box-detail-order"  id="box-detail2">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="donhang-chuanbi1" class="donhang-chuanbi white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup" >
                <h2><?= Yii::t('app', 'order_check_7') ?></h2>
            </div>
            <div class="ctn-popup">
                <div class="box-detail-order" id="box-detail1">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="donhang-chuanbi0" class="donhang-chuanbi white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="title-popup" >
                <h2><?= Yii::t('app', 'order_detail') ?></h2>
            </div>
            <div class="ctn-popup">
                <div class="box-detail-order" id="box-detail0">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="load-like" id="load-like">
</div>
<script type="text/javascript">
    jQuery(document).on('click', '.load-review-4', function () {
        var _this = $(this);
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        $('#add-name-product').html(name);
        href = '<?= Url::to(['/management/order/load-review']) ?>';
        loadAjax(href , {order_item_id: id} , $('#content-data-review'));
    });
    $(document).ready(function () {
        $('.open-popup-link-b1').click(function() {
            href = '<?= Url::to(['/management/order/get-detail']) ?>';
            var shop_order = $(this).attr('data-id');
            loadAjax(href , {id : shop_order, status_get: 1} , $('#box-detail1'));
        });
        
        $('.load-st-0').click(function() {
            if($(this).attr('data') == '1') {
                $.ajax({
                    url: "<?= Url::to(['/management/order/load']) ?>",
                    data:{status: 0},
                    success: function(result){
                        $('#box-st-0').html(result);
                        $('.load-st-0').attr('data','0');
                    }
                });
            }
        });
        $('.load-st-2').click(function() {
            if($(this).attr('data') == '1') {
                $.ajax({
                    url: "<?= Url::to(['/management/order/load']) ?>",
                    data:{status: 2},
                    success: function(result){
                        $('#box-st-2').html(result);
                        $('.load-st-2').attr('data','0');
                    }
                });
            }
        });
        $('.load-st-3').click(function() {
            if($(this).attr('data') == '1') {
                $.ajax({
                    url: "<?= Url::to(['/management/order/load']) ?>",
                    data:{status: 3},
                    success: function(result){
                        $('#box-st-3').html(result);
                        $('.load-st-3').attr('data','0');
                    }
                });
            }
        });
        $('.load-st-4').click(function() {
            if($(this).attr('data') == '1') {
                $.ajax({
                    url: "<?= Url::to(['/management/order/load']) ?>",
                    data:{status: 4},
                    success: function(result){
                        $('#box-st-4').html(result);
                        $('.load-st-4').attr('data','0');
                    }
                });
            }
        });
    });

    function update12(id){
        if(confirm('<?= Yii::t('app', 'order_check_1') ?>')) {
            href = '<?= Url::to(['/management/order/update12']) ?>';
            loadAjax(href , {id : id} , $('#box-detail1'));
            $('#box-b1-'+id).css('display', 'none');
            $('.load-st-2').attr('data', 1);
        }
    }
    function update23(id){
        if(confirm('<?= Yii::t('app', 'order_check_1') ?>')) {
            href = '<?= Url::to(['/management/order/update23']) ?>';
            loadAjax(href , {id : id} , $('#box-detail2'));
            $('#box-b2-'+id).css('display', 'none');
            $('.load-st-3').attr('data', 1);
        }
    }
    function cancer(id, status){
        if(confirm('<?= Yii::t('app', 'order_check_0') ?>')) {
            href = '<?= Url::to(['/management/order/update0']) ?>';
            $('.mfp-close').click();
            $('#load-like').fadeIn(1000);
            $('#box-b'+status+'-'+id).css('display', 'none');
            $('#box-b'+status+'-'+id).addClass('new-remove-order');
            $('.load-st-0').attr('data', 1);
            loadAjax(href , {id : id} , $('#load-like'));
        }
    }

    function returnoder(id, status) {
        if(confirm('<?= Yii::t('app', 'order_check_100') ?>')) {
            href = '<?= Url::to(['/management/order/update40']) ?>';
            $('.mfp-close').click();
            $('#load-like').fadeIn(1000);
            $('#box-b'+status+'-'+id).css('display', 'none');
            $('#box-b'+status+'-'+id).addClass('new-remove-order');
            $('.load-st-0').attr('data', 1);
            loadAjax(href , {id : id} , $('#load-like'));
        }
    }

</script>