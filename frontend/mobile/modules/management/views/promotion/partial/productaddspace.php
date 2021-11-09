<style type="text/css">
    .price {
        font-size: 13px;
    }
</style>
<?php if($product_add) { ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?= Yii::t('app', 'product') ?></th>
                <th class="action-column">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product_add as $product) { 
                $price = $product['price'];
                $price_text = number_format($product['price'], 0, ',', '.');
                if ($product['price_range']) {
                    $price_range = explode(',', $product['price_range']);
                    $price = $price_range[0];
                    $price_max = number_format($price_range[0], 0, ',', '.');
                    $price_min = number_format($price_range[count($price_range) - 1], 0, ',', '.');
                    $price_text = $price_max != $price_min ? $price_min . ' - ' . $price_max : $price_min;
                }
                if($price) {
                ?>
                <tr data-key="8">
                    <td><?= $product['name'] ?>(<span class="price"><?= $price_text ?></span>)</td>
                    <td>
                        <a class="click add-promotion" title="<?= Yii::t('app', 'add') ?>" data-name="<?= $product['name'] ?>" data-id="<?= $product['id'] ?>" aria-label data-price="<?= $price ?>" data-price-text="<?= $price_text ?>"><i class="fa fa-angle-double-right"></i></a></td>
                </tr>
                <?php }
            } ?>
        </tbody>
    </table>
    <?php if(isset($count_page) && $count_page > 2) { ?>
        <ul class="pagination"><li class="prev disabled"><span>«</span></li>
            <?php for ($i=1; $i <= $count_page; $i++) { ?>
            <li class="lis <?= ($i ==$page) ? 'active' : ''?>"><a class="click product-page" data-page="<?= $i ?>"><?= $i ?></a></li>
            <?php } ?>
        </ul>
    <?php } ?>
<?php } else { ?>
    <p><?= Yii::t('app', 'not_result') ?></p>
<?php } ?>