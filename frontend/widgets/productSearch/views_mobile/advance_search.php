<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;
?>
<style type="text/css">
    @media (max-width: 767px) {
        body .width-80-mb{
            max-width: unset !important;
            width: 88% !important;
        }
    }
</style>
<div class="box-advanced-search">
    <div class="close-btn"></div>
    <div class="flex">
        <div class="item-advanced-search price-from width-80-mb">
            <?php
            $levels = common\models\shop\Shop::getType();
            ?>
            <label for="">Loại gian hàng</label>
            <select name="type" id="type-prs">
                <?php foreach ($levels as $k => $type) { ?>
                    <option <?= (isset($_GET['type']) && $_GET['type'] == $k) ? 'selected' : '' ?> value="<?= $k ?>"><?= $type ?></option>
                <?php } ?>
            </select>
        </div>
        <?php $optionsPrice = common\components\ClaProduct::optionsPrice() ?>
        <div class="item-advanced-search price-from">
            <label for="">Giá bán</label>
            <select name="price_min" id="price_min">
                <option value="">Từ</option>
                <?php foreach ($optionsPrice as $option_key => $option_value) { ?>
                    <option <?= (isset($_GET['price_min']) && $_GET['price_min'] == $option_key) ? 'selected' : '' ?> value="<?= $option_key ?>"><?= $option_value ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="item-advanced-search price-to">
            <label for="">Giá bán</label>
            <select name="price_max" id="price_max">
                <option value="">Đến</option>
                <?php
                unset($optionsPrice[0]);
                foreach ($optionsPrice as $option_key => $option_value) {
                    ?>
                    <option <?= (isset($_GET['price_max']) && $_GET['price_max'] == $option_key) ? 'selected' : '' ?> value="<?= $option_key ?>"><?= $option_value ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="submit-search btn-style-2">Tìm kiếm</button>
    </div>
    <div class="list-check awe-check">
        <div class="checkbox">
            <input type="checkbox" class="ais-checkbox not-doulble" <?= (isset($_GET['wholesale']) && $_GET['wholesale'] && !isset($_GET['retail'])) ? 'checked' : '' ?> name="wholesale" value="1">
            <label><span class="text-clip" title="checkbox">Hàng bán buôn</span></label>
        </div>
        <div class="checkbox">
            <input <?= (isset($_GET['retail']) && $_GET['retail'] && !isset($_GET['wholesale'])) ? 'checked' : '' ?> type="checkbox" class="ais-checkbox not-doulble" name="retail" value="1">
            <label><span class="text-clip" title="checkbox">Hàng bán lẻ</span></label>
        </div>
        <div class="checkbox">
            <input <?= (isset($_GET['rate']) && $_GET['rate']) ? 'checked' : '' ?> type="checkbox" class="ais-checkbox" name="rate" value="4">
            <label><span class="text-clip" title="checkbox">Sản phẩm được đánh giá cao</span></label>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.not-doulble').change(function () {
            if($(this).is(":checked")) {
                $('.not-doulble').prop('checked', false);
                $(this).prop('checked', true);
                $(this).checked;
            }
        });
    })
</script>