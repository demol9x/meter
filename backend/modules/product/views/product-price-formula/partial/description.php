<?php
$attributes = common\components\ClaProduct::arrAttrPriceFormula();
$attrs = array_chunk($attributes, 5, true);
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Mã</th>
            <th>Mô tả</th>
            <th>Mã</th>
            <th>Mô tả</th>
            <th>Mã</th>
            <th>Mô tả</th>
            <th>Mã</th>
            <th>Mô tả</th>
            <th>Mã</th>
            <th>Mô tả</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attrs as $attr) { ?>
            <tr>
                <?php foreach ($attr as $key => $name) { ?>
                    <th scope="row"><?= $key ?></th>
                    <td><?= $name ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>