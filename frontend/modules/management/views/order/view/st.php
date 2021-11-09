<?php
use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<?php if($orders) foreach ($orders as $order) { 
    $s_url = Url::to(['/shop/shop/detail', 'id' => $order['shop_id'], 'alias' =>$order['s_alias']]);
    ?>
    <div class="item-info-donhang" id="box-b0-<?= $order['id'] ?>">
        <div class="title">
            <div class="img">
                <a href="<?= $s_url ?>">
                    <img src="<?= ClaHost::getImageHost(), $order['s_avatar_path'], $order['s_avatar_name'] ?>" alt="<?= $order['s_name'] ?>">
                    <?= $order['s_name'] ?>
                </a>
            </div>
            <div class="btn-view-shop">
                <a href="<?=$s_url ?>"><i class="fa fa-home"></i><?= Yii::t('app', 'view_shop') ?></a>
            </div>
        </div>
        <?php if(isset($products[$order['id']]) && $products[$order['id']]) foreach ($products[$order['id']] as $product) {
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
            <p class="code-item"><?= Yii::t('app', 'orders') ?>: <b>OR<?= $order['id'] ?></b></p>
            <div class="btn-view-shop">
                <p>
                    <?= Yii::t('app', 'transport_fee') ?>:  <?= number_format($order['shipfee'], 0, ',', '.').' '.Yii::t('app', 'currency')  ?>
                </p>
                <p>
                    <?= Yii::t('app', 'sum') ?>: <?= number_format($order['order_total'], 0, ',', '.').' '.Yii::t('app', 'currency')  ?>
                </p>
                
            </div>
            <div class="code-donhang">
                <a class="open-popup-link open-popup-link-b" data-id="<?= $order['id'] ?>" href="#donhang-chuanbi"><?= Yii::t('app', 'order_detail') ?></a>
            </div>
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.open-popup-link').magnificPopup({
            type:'inline',
            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        });
        $('.view-detail<?= $status ?>').click(function() {
            id = $(this).attr('data-id');
            $.ajax({
                url: "<?= Url::to(['/management/order/detail']) ?>",
                data:{id: id},
                success: function(result){
                   $('#donhang-detail1').html(result);
                }
            });
        });
        $('.rate-product<?= $status ?>').click(function () {
            $('#rv-a-img').attr('href', $(this).attr('data-url'));
            $('#rv-img').attr('src', $(this).attr('data-src'));
            $('#rv-a-name').attr('href', $(this).attr('data-url'));
            $('#rv-a-name').html($(this).attr('data-name'));
            $('#rv-price').html($(this).attr('data-price'));
            $('#rv-id').val($(this).attr('data-id'));
            $('#rv-pid').val($(this).attr('data-pid'));
        });
    });
</script>