<?php
 $url= \yii\helpers\Url::to(['/package/package/index']);

 ?>

<div class="pro_select">
    <span>Sắp xếp:</span>
    <select id="select_pro_option_1">
        <option value=""  <?= isset($_GET['order']) && $_GET['order']=='' ? 'selected' : '' ?> >Tùy chọn</option>
        <option value="id ASC"  <?= isset($_GET['order']) && $_GET['order']=='id ASC' ? 'selected' : '' ?>>Thấp đến cao</option>
        <option value="id DESC"  <?= isset($_GET['order']) && $_GET['order']=='id DESC' ? 'selected' : '' ?>>Cao đến thấp</option>
        <option value="name ASC" <?= isset($_GET['order']) && $_GET['order']=='name ASC' ? 'selected' : '' ?>>A-Z</option>
        <option value="name DESC" <?= isset($_GET['order']) && $_GET['order']=='name DESC' ? 'selected' : '' ?>>Z-A</option>
    </select>
</div>

<script type="text/javascript">
    $(function () {
        $('#select_pro_option_1').change( function() {
            window.location.href= '/package/package/index?order='+jQuery(this).find('option:selected').val();
        });
    });
</script>