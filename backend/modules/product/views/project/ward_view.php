<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 6/28/2021
 * Time: 5:08 PM
 */

?>
<select data-placeholder="Chọn phường/ xã" class="ward-select" name="Project[ward_id]" tabindex="5">
    <option value=""></option>
    <?php foreach ($data as $key => $value): ?>
        <option value="<?= $key ?>"><?= $value ?></option>
    <?php endforeach; ?>
</select>
