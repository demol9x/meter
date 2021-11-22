<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl ?>css/chosen.css"/>
<script src="<?php echo Yii::$app->homeUrl ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo Yii::$app->homeUrl ?>js/chosen.jquery.js"></script>

<?=
$form->field($model, 'name', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => 'Nhập tên dự án'
])->label($model->getAttributeLabel('name'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<div class="form-group required">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="project-province_id">Tỉnh/ thành phố</label>
    <div class="col-md-10">
        <select data-placeholder="Chọn tỉnh/ thành phố" class="province-select" name="Project[province_id]" tabindex="5">
            <option value=""></option>
            <?php foreach ($provinces as $key => $province): ?>
                <option value="<?= $key ?>" <?= $key == $model->province_id ? 'selected' : '' ?> ><?= $province ?></option>
            <?php endforeach; ?>
        </select>
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group required">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="project-district_id">Quận/ huyện</label>
    <div class="col-md-10 district_select">
        <select data-placeholder="Chọn quận/ huyện" class="chosen-select" tabindex="5">
        </select>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="project-ward_id">Phường/ xã</label>
    <div class="col-md-10 ward_select">
        <select data-placeholder="Chọn phường/ xã" class="chosen-select" tabindex="5">
        </select>
    </div>
</div>

<?=
$form->field($model, 'address', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => 'Địa chỉ'
])->label($model->getAttributeLabel('address'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<style>
    .chosen-container {
        width: 100% !important;
    }
</style>

<script>
    jQuery('.chosen-select').chosen();
    jQuery('.chosen-select').chosen();
    jQuery('.province-select').chosen().change(function(){
        var id = $(this).val();
        jQuery.ajax({
            url: '<?= \yii\helpers\Url::to(['get-district']) ?>',
            type: 'GET',
            data: {
                province_id: id,
            },
            success: function (result) {
                jQuery('.ward_select').empty();
                jQuery('.ward_select').append('<select data-placeholder="Chọn phường/ xã" class="ward-select" name="Project[ward_id]" tabindex="5"><option value=""></option></select>');
                jQuery('.ward-select').chosen();
                jQuery('.district_select').empty();
                jQuery('.district_select').append(result);
                jQuery('.district-select').chosen().change(function(){
                    var district_id = $(this).val();
                    jQuery.ajax({
                        url: '<?= \yii\helpers\Url::to(['get-ward']) ?>',
                        type: 'GET',
                        data: {
                            district_id: district_id,
                        },
                        success: function (result) {
                            jQuery('.ward_select').empty();
                            jQuery('.ward_select').append(result);
                            jQuery('.ward-select').chosen();
                        }
                    });
                });

            }
        });
    });

</script>

