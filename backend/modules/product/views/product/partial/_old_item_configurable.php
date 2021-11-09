<?php
if (count($configurables)) {
    foreach ($configurables as $config) {
        ?>
        <div class="item">
            <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                <input type="text" name="ProductConfigurableOld[<?= $config['id'] ?>][color]" value="<?= $config['color'] ?>" class="form-control">
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                <input type="text" name="ProductConfigurableOld[<?= $config['id'] ?>][size]" value="<?= $config['size'] ?>" class="form-control">
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                <select name="ProductConfigurableOld[<?= $config['id'] ?>][out_of_stock]" class="form-control">
                    <option <?= $config['out_of_stock'] == 0 ? 'selected' : '' ?> value="0">Còn hàng</option>
                    <option <?= $config['out_of_stock'] == 1 ? 'selected' : '' ?> value="1">Hết hàng</option>
                </select>
            </div>
        </div>
        <?php
    }
}
?>