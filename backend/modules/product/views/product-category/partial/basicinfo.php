<?php

use yii\bootstrap\Html;
use common\components\ClaHost;

?>
<?=
$form->field($model, 'name', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => 'Nhập tên danh mục'
])->label($model->getAttributeLabel('name'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<?=
$form->field($model, 'parent', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList($model->optionsCategory(0, 0, true), [
    'class' => 'form-control'
])->label($model->getAttributeLabel('parent'), [
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
<style type="text/css">
    .form-group {
        clear: both;
    }
</style>
<div class="box-imgs">
    <?=
    backend\widgets\form\FormWidget::widget([
        'view' => 'form-img',
        'input' => [
            'model' => $model,
            'id' => 'avatar',
            'images' => ($model->avatar_name) ? ClaHost::getImageHost() . $model['avatar_path'] . 's100_100/' . $model['avatar_name'] : null,
            'url' => yii\helpers\Url::to(['product-category/uploadfile']),
            // 'script' => '<script src="'.Yii::$app->homeUrl.'js/upload/ajaxupload.min.js"></script>'
        ]
    ]);
    ?>
    <?=
    backend\widgets\form\FormWidget::widget([
        'view' => 'form-img',
        'input' => [
            'model' => $model,
            'id' => 'avatar2',
            'images' => ($model->icon_name) ? ClaHost::getImageHost() . $model['icon_path'] . 's100_100/' . $model['icon_name'] : null,
            'url' => yii\helpers\Url::to(['product-category/uploadfile']),
        ]
    ]);
    ?>
</div>

<?=
backend\widgets\form\FormWidget::widget([
    'view' => 'form-img',
    'input' => [
        'model' => $model,
        'id' => 'avatar3',
        'images' => ($model->bgr_name) ? ClaHost::getImageHost() . $model['bgr_path'] . 's100_100/' . $model['bgr_name'] : null,
        'url' => yii\helpers\Url::to(['product-category/uploadfile']),
    ]
]);
?>

<?=
$form->field($model, 'description', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textarea([
    'class' => 'form-control',
])->label($model->getAttributeLabel('description'), [
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

$form->field($model, 'show_in_home', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label($model->getAttributeLabel('show_in_home'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=

$form->field($model, 'show_in_home_2', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label($model->getAttributeLabel('show_in_home_2'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=

$form->field($model, 'frontend_not_up', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
    'label' => NULL
])->label($model->getAttributeLabel('frontend_not_up'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'order', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => 'Nhập thứ tự'
])->label($model->getAttributeLabel('order'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'status', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList([1 => 'Hiển thị', 0 => 'Ẩn'], [
    'class' => 'form-control'
])->label($model->getAttributeLabel('status'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
<!-- SEO -->
<?=
$form->field($model, 'meta_keywords', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
])->label($model->getAttributeLabel('meta_keywords'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'meta_description', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
])->label($model->getAttributeLabel('meta_description'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'meta_title', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
])->label($model->getAttributeLabel('meta_title'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
