<?php

use yii\bootstrap\Html;
use common\components\ClaHost;
?>
<?=
$form->field($model, 'name', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
])->label($model->getAttributeLabel('name'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
<?=
$form->field($model, 'code', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
])->label($model->getAttributeLabel('code'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'attribute_set_id', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList(common\models\product\ProductAttributeSet::optionsAttributeSet(), [
    'class' => 'form-control',
    'prompt' => '--- Chọn nhóm thuộc tính ---'
])->label($model->getAttributeLabel('attribute_set_id'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
<?=
$form->field($model, 'frontend_input', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList(common\models\product\ProductAttribute::$_dataFrontendInput, [
    'class' => 'form-control',
    'prompt' => '--- Chọn loại thuộc tính ---'
])->label($model->getAttributeLabel('frontend_input'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'type_option', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList(common\models\product\ProductAttribute::$_dataTypeOption, [
    'class' => 'form-control',
    'prompt' => '--- Chọn loại thuộc tính ---'
])->label($model->getAttributeLabel('type_option'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<?=
$form->field($model, 'sort_order', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
])->label($model->getAttributeLabel('sort_order'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
<?=
$form->field($model, 'default_value', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
])->label($model->getAttributeLabel('default_value'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<div class="form-group">
    <?= Html::activeLabel($model, 'avatar', ['class' => 'control-label col-md-2 col-sm-2 col-xs-12']) ?>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <?= Html::activeHiddenInput($model, 'avatar') ?>
        <div id="attributeavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top;">  
            <?php if ($model->avatar_path && $model->avatar_name) { ?>
                <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
            <?php } ?>
        </div>
        <div id="attributeavatar_form" style="display: inline-block;">
            <?= Html::button('Chọn ảnh đại diện', ['class' => 'btn']); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        jQuery('#attributeavatar_form').ajaxUpload({
            url: '<?= yii\helpers\Url::to(['/product/product-attribute/uploadfile']); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#productattribute-avatar').val(obj.data.avatar);
                        if (jQuery('#attributeavatar_img img').attr('src')) {
                            jQuery('#attributeavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#attributeavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#attributeavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>

<?=
$form->field($model, 'is_configurable', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
])->label($model->getAttributeLabel('is_configurable'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'is_filterable', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
])->label($model->getAttributeLabel('is_filterable'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'is_system', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
])->label($model->getAttributeLabel('is_system'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'is_children_option', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
])->label($model->getAttributeLabel('is_children_option'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'is_change_price', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
])->label($model->getAttributeLabel('is_change_price'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
