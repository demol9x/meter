<h2>
    <i class="fa fa-truck" aria-hidden="true"></i>
    <b><?= Yii::t('app', 'order_history') ?></b>
</h2>
<p>
    <?= \common\models\transport\Transport::getName($data['transport_type']) ?> | <?= Yii::t('app', 'order_id') ?> <?= $data['transport_id'] ?>
</p>
<?php 
    $historys = \common\models\order\OrderShopHistory::getHistory($data['id']);
?>
<div class="infor-nguoigiao">
   <!--  <p>Người giao hàng: Nguyễn Việt Hưng</p>
    <p>841284067479</p>
    <p>
        Bưu điện Phước Sơn huyện Tuy Phước tỉnh Bình Định, Xã Phước Sơn, Huyện Tuy Phước, Bình Định
    </p> -->
    <ul>
        <?php if($historys) {
            foreach ($historys as $history) { ?>
                <li class="active">
                    <p>
                        <span><?= date('h:i:s d-m-Y', $history['time']) ?></span> <?= $history['status'] ?>
                    </p>
                </li>
            <?php }
        } ?>
    </ul>
    <?php 
        // $info = [];
        // if($data['transport_type']) {
        //     $claShipping = new ClaShipping();
        //     $claShipping->loadVendor(['method' => $data['transport_type']]);
        //     $options['data']['OrderCode'] = $data['transport_id'];
        //     $info = $claShipping->getInfoOrder($options);
        // }
        
    ?>
    <!-- <pre>
        <?php 
            // print_r($info); 
            // \common\models\order\OrderShop::updateStatus($data['id']);
        ?>
    </pre> -->
</div>