<?php

use common\models\product\Brand;

?>
<style type="text/css">
    .price-range-box {
        width: 80%;
        float: right;
        margin-right: 40px;
        margin-bottom: 15px;
    }

    .price-range-box input {
        height: 34px;
        width: 100%;
        padding-left: 10px;
        border: 1px solid #ccc;
    }

    .btn-add-price {
        padding-left: 20%;
        height: 40px;
        margin: 19px -33px;
    }

    .btn-add-price a {
        width: 45px;
        height: 100%;
        text-align: center;
        font-size: 18px;
        color: #fff;
        background: #dbbf6d;
        border-radius: 4px;
        border: none;
        display: inline-block;
        padding: 10px;
        float: left;
        margin-right: 20px;
    }

    .box-banbuon label {
        margin-left: 85px;
    }
</style>

<?=

$form->field($model, 'name', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('name')
])->label($model->getAttributeLabel('name'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<?php $option = (new common\models\product\ProductCategory())->optionsCategory(); ?>

<?=
$form->field($model, 'category_id', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList($option, [
    'class' => 'form-control',
])->label($model->getAttributeLabel('category_id'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=

$form->field($model, 'brand', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList(Brand::getListBrand(), [
    'class' => 'form-control',
    'prompt' => 'Chọn thương hiệu'
])->label($model->getAttributeLabel('brand'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12',
])
?>


<?=

$form->field($model, 'price_market', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('price_market')
])->label($model->getAttributeLabel('price_market'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=

$form->field($model, 'price', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => 'Nhập giá'
])->label($model->getAttributeLabel('price'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>



<?=

$form->field($model, 'status', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label($model->getAttributeLabel('status'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=

$form->field($model, 'ishot', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label($model->getAttributeLabel('ishot'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=

$form->field($model, 'isnew', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label($model->getAttributeLabel('isnew'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<?=

$form->field($model, 'fee_ship', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label($model->getAttributeLabel('fee_ship'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'short_description', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textArea([
    'class' => 'form-control',
    'rows' => 4
])->label($model->getAttributeLabel('short_description'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'note', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textArea([
    'class' => 'form-control ckedit',
    'rows' => 4
])->label($model->getAttributeLabel('note'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'description', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textArea([
    'class' => 'form-control ckedit',
    'rows' => 4
])->label($model->getAttributeLabel('description'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<?=
$form->field($model, 'specifications', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textArea([
    'class' => 'form-control ckedit',
    'rows' => 4
])->label($model->getAttributeLabel('specifications'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<div class="form-group field-product-note_fee_ship">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-note_fee_ship">Video</label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <p>Nhập đường dẫn link nhúng video(Giới hạn 5 link)</p>
        <div class="full-input" id="add-videos">
            <?php
            $videos = null;
            if ($model->videos) {
                $videos = $model->videos;
                foreach ($videos as $video) if ($video) { ?>
                    <input type="text" placeholder="https://www.youtube.com/embed/0wr6-kZe9kc"
                           class="form-control videos" value="<?= $video ?>" name="Product[videos][]">
                <?php }
            } ?>
            <?php if (count($videos) < 5) { ?>
                <input type="text" class="form-control videos" placeholder="https://www.youtube.com/embed/0wr6-kZe9kc"
                       value="" name="Product[videos][]">
            <?php } ?>
        </div>
    </div>
</div>
<?=

$form->field($model, 'order', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('order')
])->label($model->getAttributeLabel('order'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
<script type="text/javascript">
    jQuery(document).on('click', '.videos:nth-last-child(1)', function () {
        if ($('.videos').length == 1 || ($('.videos:nth-last-child(2)').val() && $('.videos').length < 5)) {
            $('#add-videos').append('<input type="text" class="form-control videos" name="Product[videos][]">');
        }
    });
</script>
<style type="text/css">
    #add-videos input {
        margin-bottom: 10px;
    }
</style>