<?php if (count($attribute['options'])) { ?>
    <div class="item-filter">
        <select class="chosen-select" data-placeholder="<?php echo $attribute['att']['name'] ?>">
            <option value="empty=fi_<?= $key ?>"></option>
            <?php
            foreach ($attribute['options'] as $att) {
                ?>
                <option <?= $att['checked'] ? 'selected' : '' ?> value="fi_<?= $key ?>=<?= $att['index_key'] ?>"><?php echo $att['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>

<?php } ?>