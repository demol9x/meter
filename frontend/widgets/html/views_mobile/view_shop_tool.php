<?php

use yii\helpers\Url;

$href = $_GET;
if (isset($href['order'])) unset($href['order']);
?>
<div class="filter-az-store">
    <select id="select-order">
        <option value=""><?= Yii::t('app', 'order_by') ?></option>
        <option <?= (isset($_GET['order']) && $_GET['order'] == 'name') ? 'selected' : '' ?> value="name">Từ A - Z</option>
        <option <?= (isset($_GET['order']) && $_GET['order'] == 'name DESC') ? 'selected' : '' ?> value="name DESC">Từ Z - A</option>
        <option <?= (isset($_GET['order']) && $_GET['order'] == 'price DESC') ? 'selected' : '' ?> value="price DESC">Giá từ cao - thấp</option>
        <option <?= (isset($_GET['order']) && $_GET['order'] == 'price') ? 'selected' : '' ?> value="price">Giá từ thấp - cao</option>
    </select>
</div>
<div class="search-in-store">
    <form action="" id="form-search-shop">
        <input type="text" name="key" value="<?= (isset($_GET['key'])) ? $_GET['key'] : '' ?>" placeholder="Tìm kiếm trong gian hàng">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#select-order').change(function() {
                var order = $(this).val();
                document.location.href = '<?= Url::to(array_merge(['/shop/shop/detail'], $href, ['order' => ''])) ?>' + order;
            });
        });
    </script>
</div>