<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/29/2021
 * Time: 11:09 AM
 */
$prd = new \common\models\product\Product();
?>
<?php if ($product_variable):
    ?>
    <table class="table">
        <thead>
        <tr>
            <?php foreach ($product_variable as $key => $variable): ?>
                <th><?= $product_attribute[$key]['name'] ?></th>
            <?php endforeach; ?>
            <th>Tên biến thế</th>
            <th>Giá biến thế</th>
            <th style="width: 7% !important;">Tồn kho</th>
            <th>Ảnh</th>
            <th>Mặc định</th>
            <th>Ẩn</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($variables as $key => $variable):
            ?>
            <tr>
                <?php foreach ($key_variables[$key] as $item):
                    $it = explode('~',$item);
                    ?>
                    <th><?= \common\models\product\ProductAttributeItem::findOne($it[1])->value ?></th>
                <?php endforeach; ?>
                <td>
                    <input type="text" name="AttributePrice2[<?= $key ?>][name]" value="<?= $variable['name'] ?>" placeholder="Nhập tên biến thể">
                </td>
                <td>
                    <input type="text" name="AttributePrice2[<?= $key ?>][price]" value="<?= $variable['price'] ?>" placeholder="Nhập giá biến thể">
                </td>
                <td>
                    <input type="text" name="AttributePrice2[<?= $key ?>][quantity]" value="<?= $variable['quantity'] ?>"
                           placeholder="Nhập số lượng tồn kho">
                </td>
                <td>
                    <div class="control-group form-group">
                        <div class="controls">
                            <input type="hidden" id="formimg0input" name="AttributePrice2[<?= $key ?>][avatar]">
                            <input type="hidden" id="formimg0input" name="AttributePrice2[<?= $key ?>][key]" value='<?php print $variable['key'] ?>'>
                            <div style="clear: both;"></div>
                            <div id="formimg0" style="display: block; margin-top: 10px;">
                                <div id="formimg0_img"
                                     style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; ">
                                    <img src="<?= $variable['avatar_path'] ? \common\components\ClaHost::getImageHost().$variable['avatar_path'].$variable['avatar_name'] : '' ?>"
                                         style="width: 100%;">
                                </div>
                                <div id="formimg0_form" style="display: inline-block; position: relative;">
                                    <input class="btn  btn-sm" name="yt0" type="button" value="Chọn ảnh đại diện">
                                    <form style="margin: 0px !important; padding: 0px !important; position: absolute; top: 0px; left: 0px; height: 100%; width: 100%;" method="POST" enctype="multipart/form-data"
                                          action="/quantri/content/news/uploadfile">
                                        <input name="file" type="file"
                                               style="display: block; overflow: hidden; width: 100%; height: 100%; text-align: right; opacity: 0; z-index: 999999; cursor: pointer;">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <input type="radio" name="AttributePrice2[default]" value="<?= $key ?>" <?= isset($variable['default']) && $variable['default'] ? 'checked' : '' ?>>
                </td>
                <td>
                    <input type="checkbox" name="AttributePrice2[<?= $key ?>][status]" <?= isset($variable['status']) && $variable['status'] ? 'checked' : '' ?>>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>