<?php
use yii\helpers\Url;
$href1 = $_GET;
$href2 = $_GET;
if(isset($href1['price_min'])) unset($href1['price_min']);
if(isset($href1['price_max'])) unset($href1['price_max']);
if(isset($href2['province_id'])) unset($href2['province_id']);
$url_price = Url::to(array_merge(['/product/product/category'],$href1));
$url_province = Url::to(array_merge(['/product/product/category'],$href2));
$price_range = \common\models\product\Product::getPriceRange();
$provinces = \common\models\Province::optionsProvince();
?>
<div class="option-filter awe-check">
    <div class="categories-menu">
        <h2>
            <?= Yii::t('app', 'price_product') ?>
        </h2>
        <div class="group-check-box active">
            <div class="radio">
                <input type="radio" class="select-price" <?= (isset($_GET['price_min']) && $_GET['price_min'] == '') ? 'checked' : '' ?> data-min ="" data-max="" name="radiobox" value="">
                <label><span class="text-clip" title="radio"> <?= Yii::t('app', 'all') ?> </span></label>
            </div>
            <?php if($price_range) {
                foreach ($price_range as $price) {
                    ?>
                    <div class="radio">
                        <input type="radio" class="select-price" <?= (isset($_GET['price_max']) && $_GET['price_max'] == $price['max']) ? 'checked' : '' ?> data-min ="<?= $price['min'] ?>" data-max="<?= $price['max'] ?>" name="radiobox" value="">
                        <label><span class="text-clip" title="radio"> <?= number_format($price['min'], 0, ',', '.') ?> - <?= number_format($price['max'], 0, ',', '.') ?></span></label>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</div>
<div class="option-filter awe-check">
    <div class="categories-menu max-height-change">
        <h2>
            <?= Yii::t('app', 'province_sales') ?>
        </h2>
        <div class="group-check-box active">
            <div class="checkbox">
                <input type="checkbox" <?= (isset($_GET['province_id']) && $_GET['province_id'] == '') ? 'checked' : '' ?> class="select-province" data="" class="ais-checkbox" value="checkbox">
                <label><span class="text-clip" title="checkbox"><?= Yii::t('app', 'all') ?></span></label>
            </div>
            <?php 
            unset($provinces['']);            
            foreach ($provinces as $key => $value) { 
                    ?>
                <div class="checkbox">
                    <input type="checkbox" <?= (isset($_GET['province_id']) && $_GET['province_id'] == $key) ? 'checked' : '' ?> class="select-province" data="<?= $key ?>" class="ais-checkbox" value="checkbox">
                    <label><span class="text-clip" title="checkbox"><?= $value ?></span></label>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="view-add">
        <span><?= Yii::t('app', 'view_add') ?></span>
    </div>
    <div class="view-litte">
        <span><?= Yii::t('app', 'view_litte') ?></span>
    </div>
</div>


<style type="text/css">
    .select-price, .select-province, .view-add, .view-litte {
        cursor: pointer;
    }
    .max-height-change {
        max-height: 215px;
        overflow: hidden;
    }
    .view-litte {
        display: none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select-price').click(function() {
            var min = $(this).attr('data-min');
            var max = $(this).attr('data-max');
            document.location.href = '<?= $url_price ?>'+ '<?= isset($href1['province_id']) ? '&' : '?' ?>price_min='+min+'&price_max='+max;
        });

        $('.select-province').click(function() {
            var province = $(this).attr('data');
            document.location.href = '<?= $url_province ?>'+ '<?= isset($href2['price_max']) ? '&' : '?' ?>province_id='+province;
        });

        $('.view-add').click(function() {
            $(this).parent().find('.max-height-change').css('max-height', 'unset');
            $(this).parent().find('.view-litte').css('display', 'block');
            $(this).css('display', 'none');
        });

        $('.view-litte').click(function() {
            $(this).parent().find('.max-height-change').css('max-height', '215px');
            $(this).parent().find('.view-add').css('display', 'block');
            $(this).css('display', 'none');
        });
    });
</script>