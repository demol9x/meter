<?php
 $url= \yii\helpers\Url::to(['/product/product/index']);

 ?>

<div class="pro_select">
    <span>Sắp xếp:</span>
    <select id="select_pro_option">
        <option value=""  <?= isset($_GET['']) && $_GET[''] ? 'selected' : '' ?> >Tùy chọn</option>
        <option value="id ASC"  <?= isset($_GET['order']) && $_GET['order'] ? 'selected' : '' ?>>Thấp đến cao</option>
        <option value="id DESC">Cao đến thấp</option>
        <option value="name ASC">A-Z</option>
        <option value="name DESC">Z-A</option>
    </select>
</div>

<script type="text/javascript">
    $(function () {
        $('#select_pro_option').change( function() {
            window.location.href= '/product/product/index?order='+jQuery(this).find('option:selected').val();
        });
    });
</script>