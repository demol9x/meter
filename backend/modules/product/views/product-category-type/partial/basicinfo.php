
<?=
$form->field($model, 'name', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => 'Nhập tên hình thức'
])->label($model->getAttributeLabel('name'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'bo_donvi_tiente', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList(\common\components\ClaBds::bodonvitiente(), [
    'class' => 'form-control'
])->label($model->getAttributeLabel('bo_donvi_tiente'), [
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
