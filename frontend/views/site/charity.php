<style>
    .table thead tr {
        background: #dbbf6d;
        color: #fff;
        text-transform: uppercase;
    }

    .table thead tr:hover {
        background: #dbbf6d;
        color: #fff;
        text-transform: uppercase;
    }
</style>
<?php
$shops = (new \common\models\shop\Shop())->optionsCache();
?>
<div class="page-contact bg-whites page-contact-us" style="">
    <div class="boxsss">
        <h2 class="title-content"><?= $this->title ?></h2>
        <hr />
        <p>Số tiền trong quỹ: <b><?= formatMoney(\common\models\gcacoin\Gcacoin::getMoneyToCoin($sum)) . ' ' . Yii::t('app', 'currency') ?></b> được đóng góp bởi:</p>
        <div style="padding: 10px 0px" class="instroduce content-standard-ck">
            <table class="table">
                <thead>
                    <tr>
                        <th>Số tiền</th>
                        <th>ID - Thành viên</th>
                        <th>Sản phẩm đã mua</th>
                        <th>Doanh Nghiệp cung cấp</th>
                        <th>% cho Quỹ Từ thiện</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders) foreach ($orders as $item) {  ?>
                        <tr>
                            <td><?= formatMoney(\common\models\gcacoin\Gcacoin::getMoneyToCoin($item['sale_charity'])) ?></td>
                            <td><?= $item['user_id'] ?> - <?= $item['name'] ?></td>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= isset($shops[$item['shop_id']]) ? $shops[$item['shop_id']] : 'Doanh nghiệp đã không có trong hệ thống'  ?></td>
                            <td>
                                <?php
                                $money = \common\models\gcacoin\Gcacoin::getMoneyToCoin($item['sale_charity']) * 100;
                                $sale = \common\models\gcacoin\Gcacoin::getMoneyToCoin($item['sale']);
                                echo formatMoney($money / ($item['price'] * $item['quantity'] + $sale)) . '%';
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="paginate">
                <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => new yii\data\Pagination([
                            'defaultPageSize' => $limit,
                            'totalCount' => $totalitem
                        ])
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>