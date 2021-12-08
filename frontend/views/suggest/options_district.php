<?php
if ($label != '') {
    echo '<option value="0">' . $label . '</option>';
}
if (isset($options) && $options) {
    foreach ($options as $option_value => $option_name) {
        ?>
        <option value="<?= $option_value ?>"><?= $option_name ?></option>
        <?php
    }
}
?>

