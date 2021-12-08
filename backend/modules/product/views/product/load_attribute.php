<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/29/2021
 * Time: 10:13 AM
 */
?>
<?php if ($product_attribute): ?>
    <?php foreach ($product_attribute as $attribute): ?>
        <div class="body-attribute-value">
            <label class="control-label"><?= $attribute['name'] ?></label>
            <select class="attribute-value" data-attribute_id="<?= $attribute['id'] ?>" name="product_attribute[<?= $attribute['id'] ?>][]" aria-required="true" multiple="multiple">
                <?php if (isset($attribute['items']) && $attribute['items']): ?>
                    <?php foreach ($attribute['items'] as $item): ?>
                        <option value="<?= $item['id'] ?>"><?= $item['value'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<script>
    jQuery(document).ready(function () {
        jQuery(".attribute-value").select2({
            placeholder: "Chọn giá trị cho bộ thuộc tính",
            allowClear: true,
        });
    });
</script>
