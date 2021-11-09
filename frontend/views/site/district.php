<option value=""><?= Yii::t('app','select_district') ?></option>
<?php
if($data) foreach ($data as $key => $value) {
    ?>
    <option value="<?= $key ?>" <?= ($key == $select_id) ? "selected" : '' ?> ><?= $value ?></option>
<?php } ?>
