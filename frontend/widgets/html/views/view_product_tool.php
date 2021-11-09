<?php

use yii\helpers\Url;
use common\components\ClaHost;
$href = $_GET;
if(isset($href['order'])) unset($href['order']);
?>
<div class="search-filter">
    <form action="">
        <input type="text" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" placeholder="<?= Yii::t('app', 'search_product') ?>">
        <button><i class="fa fa-search"></i></button>
    </form>
    <select id="select-order">
        <option value=""><?= Yii::t('app', 'order_by') ?></option>
        <option <?= (isset($_GET['order']) && $_GET['order'] =='name') ? 'selected' : '' ?> value="name">Từ A - Z</option>
        <option <?= (isset($_GET['order']) && $_GET['order'] =='name DESC') ? 'selected' : '' ?> value="name DESC">Từ Z - A</option>
        <option <?= (isset($_GET['order']) && $_GET['order'] =='price DESC') ? 'selected' : '' ?> value="price DESC">Giá từ cao - thấp</option>
        <option <?= (isset($_GET['order']) && $_GET['order'] =='price') ? 'selected' : '' ?> value="price">Giá từ thấp - cao</option>
    </select>
</div> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#select-order').change(function (){
            var order = $(this).val();
            document.location.href = '<?= Url::to(array_merge(['/management/product/index'],$href, ['order'=>''])) ?>'+ order;
                });
    });
</script>