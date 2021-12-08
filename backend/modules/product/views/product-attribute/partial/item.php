<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/28/2021
 * Time: 7:51 PM
 */


$options = $model->getData();
$last = 1;
?>
<style>
    .delete-cat {
        background: red;
        display: inline-block;
        text-align: center;
        color: #fff;
        font-size: 16px;
        padding: 5px 0px;
        cursor: pointer;
        width: 100%;
    }

    .field-medicalrecord-status-add {
        display: none;
    }

    .add-select-cat {
        margin-top: 10px;
        height: 32px;
        border: 1px dashed #CFCFCF;
        text-align: center;
        width: 100%;
        line-height: 32px;
        cursor: pointer;
        display: block;
        font-size: 16px;
        float: right;
        color: #000;
        background: #e5e5e5;
        margin-bottom: 15px;
    }
</style>

<div id="box-append-cat">
    <?php if ($options): ?>
        <?php foreach ($options as $key => $option): ?>
            <div id="index-<?= $last ?>">
                <div class="row prd-add">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="prd_attr[]" placeholder="Nhập giá trị" value="<?= $option ?>">
                    </div>
                    <div class="col-md-1">
                        <span class="delete-cat col-md-1">x</span>
                    </div>
                </div>
                <div class="help-block"></div>
            </div>
        <?php $last++; endforeach; ?>
    <?php endif; ?>
</div>

<a class="add-select-cat">+</a>


<script>
    $(document).ready(function () {
        var index = parseInt('<?= count($options) ?>');
        $('.add-select-cat').click(function () {
            index += 1;
            var html = '<div class="row prd-add">\n' +
                '        <div class="col-md-6">\n' +
                '            <input type="text" class="form-control" name="prd_attr[]" placeholder="Nhập giá trị">\n' +
                '        </div>\n' +
                '        <div class="col-md-1">\n' +
                '            <span class="delete-cat col-md-1">x</span>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class="help-block"></div>';
            $('#box-append-cat').append('<div id="index-' + index + '">' + html + '</div>');
        });

        $(document).on('click', '.delete-cat', function () {
            if (confirm("Xác nhận xóa mục?")) {
                $(this).parents('.prd-add').parent().remove();
            }
        });
    });
</script>