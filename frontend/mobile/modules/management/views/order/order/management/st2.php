<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
use common\models\Province;
use common\models\District;
?>
<?php if($shop_orders) foreach ($shop_orders as $shop_order) { 
    $s_url = Url::to(['/shop/shop/detail', 'id' => $shop_order['shop_id'], 'alias' =>$shop_order['s_alias']]);
    ?>
    <div class="item-info-donhang" id="box-b2-<?= $shop_order['id'] ?>">
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
                <a class="open-popup-link open-popup-link-b2" data-id="<?= $shop_order['id'] ?>" href="#donhang-chuanbi2"><?= Yii::t('app', 'send_order') ?></a>
            </div>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.open-popup-link').magnificPopup({
            type:'inline',
            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        });
        $('.open-popup-link-b2').click(function() {
            href = '<?= Url::to(['/management/order/get-detail']) ?>';
            var shop_order = $(this).attr('data-id');
            loadAjax(href , {id : shop_order, status_get: 2} , $('#box-detail2'));
        });
    });
</script>