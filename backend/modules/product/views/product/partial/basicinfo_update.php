<?php
$errors = $model->getErrors();
if($errors){
    if(isset($errors['district_id']) && $errors['district_id']){
        $district_err = $errors['district_id'][0];
    }

    if(isset($errors['province_id']) && $errors['province_id']){
        $province_err = $errors['province_id'][0];
    }
}
?>
<style type="text/css">
    .chosen-container {
        width: 100% !important;
    }

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
<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl ?>css/chosen.css"/>
<script src="<?php echo Yii::$app->homeUrl ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo Yii::$app->homeUrl ?>js/chosen.jquery.js"></script>
<input type="hidden" id="product-bo_donvi_tiente" class="form-control" name="Product[bo_donvi_tiente]"
       aria-required="true" aria-invalid="true" value="<?= $model->bo_donvi_tiente ?>">
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


<?=

$form->field($model, 'category_type_id', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList(\common\models\product\ProductCategoryType::optionCategoryType(), [
    'class' => 'form-control',
])->label($model->getAttributeLabel('category_type_id'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=

$form->field($model, 'shop_id', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList(common\models\shop\Shop::optionShop(), [
    'class' => 'form-control',
])->label($model->getAttributeLabel('shop_id'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>gentelella/select2/dist/css/select2.min.css">
<script src="<?= Yii::$app->homeUrl ?>gentelella/select2/dist/js/select2.full.min.js"></script>
<script>
    jQuery(document).ready(function () {
        jQuery("#product-shop_id").select2({
            placeholder: "Ch???n gian h??ng",
            allowClear: true
        });
    });
</script>

<div class="form-group no-margin-left">
    <?=
    $form->field($model, 'category_id', [
        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
    ])->dropDownList((new common\models\product\ProductCategory())->optionsCategoryByType($model->category_type_id), [
        'class' => 'form-control',
        'prompt' => '--- Ch???n danh m???c ---',
    ])->label($model->getAttributeLabel('category_id'), [
        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
    ])
    ?>
</div>


<div class="form-group required">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="project-province_id">T???nh/ th??nh ph???</label>
    <div class="col-md-10">
        <select data-placeholder="Ch???n t???nh/ th??nh ph???" class="province-select" name="Product[province_id]"
                tabindex="5">
            <option value=""></option>
            <?php foreach ($provinces as $key => $province): ?>
                <option data-coordinate="<?php echo $province['latlng'] ?>"
                        value="<?= $province['id'] ?>" <?= $province['id'] == $model->province_id ? 'selected' : '' ?> ><?= $province['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <div class="help-block"><?= isset($province_err) && $province_err ? $province_err : '' ?></div>
    </div>
</div>

<div class="form-group required">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="project-district_id">Qu???n/ huy???n</label>
    <div class="col-md-10 district_select">
        <select data-placeholder="Ch???n qu???n/ huy???n" class="district-select" tabindex="5" name="Product[district_id]">
            <option value=""></option>
            <?php foreach ($district as $key => $value): ?>
                <option data-coordinate="<?php echo $value['latlng'] ?>"
                        value="<?= $value['id'] ?>" <?= $value['id'] == $model->district_id ? 'selected' : '' ?> ><?= $value['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <div class="help-block"><?= isset($district_err) && $district_err ? $district_err : '' ?></div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="project-ward_id">Ph?????ng/ x??</label>
    <div class="col-md-10 ward_select">
        <select data-placeholder="Ch???n ph?????ng/ x??" class="ward-chosen-select" tabindex="5" name="Product[ward_id]">
            <option value=""></option>
            <?php foreach ($wards as $key => $ward): ?>
                <option data-coordinate="<?php echo $ward['latlng'] ?>"
                        value="<?= $ward['id'] ?>" <?= $ward['id'] == $model->ward_id ? 'selected' : '' ?> ><?= $ward['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<?=

$form->field($model, 'project_id', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList((new common\models\product\Project())->optionsProjectByDistrict($model->district_id), [
    'class' => 'form-control',
    'prompt' => '--- Ch???n d??? ??n ---',
])->label($model->getAttributeLabel('project_id'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<div class="form-group field-product-dien_tich">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-dien_tich">Di???n t??ch (m2)</label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="text" id="product-dien_tich" class="form-control" name="Product[dien_tich]" placeholder=""
               value="<?= $model->dien_tich ?>">
        <div class="help-block"></div>
    </div>
</div>

<?=

$form->field($model, 'price', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => 'Nh???p gi??'
])->label($model->getAttributeLabel('price'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<?=

$form->field($model, 'price_type', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->dropDownList(\common\components\ClaBds::getBoDonVi($model->bo_donvi_tiente), [
    'class' => 'form-control',
])->label($model->getAttributeLabel('price_type'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=

$form->field($model, 'address', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('address')
])->label($model->getAttributeLabel('address'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>


<?=

$form->field($model, 'status', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'class' => 'js-switch',
    'label' => NULL,
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

$form->field($model, 'ckedit_desc', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 8px;">{input}{error}{hint}</div>'
])->checkbox([
    'label' => NULL
])->label($model->getAttributeLabel('ckedit_desc'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<?=
$form->field($model, 'description', [
    'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
])->textArea([
    'class' => 'form-control',
    'rows' => 4
])->label($model->getAttributeLabel('description'), [
    'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
])
?>

<div class="form-group field-product-note_fee_ship">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-note_fee_ship">Video</label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <p>Nh???p ???????ng d???n link nh??ng video(Gi???i h???n 5 link)</p>
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
<div class="attribute-custom">
    <?= $this->render('attribute_view', ['form' => $form, 'model' => $model, 'category_id' => $model->category_id]); ?>
</div>

<style type="text/css">
    #add-videos input {
        margin-bottom: 10px;
    }
</style>

<div class="form-group field-product-coordinate">
    <label class="control-label col-md-2 col-sm-2 col-xs-12">V??? tr??</label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <input type="hidden" id="product-lat" class="form-control" name="Product[lat]" value="<?php $model->lat ?>">
        <input type="hidden" id="product-long" class="form-control" name="Product[long]"
               placeholder="<?php $model->long ?>">
        <div style="width: 800px; height: 400px;" id="map-canvas"></div>
        <div class="help-block"></div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css"/>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<?php
$lat = $model->lat ? $model->lat : 21.05;
$lng = $model->long ? $model->long : 105.79944;
?>
<script>
    var igl = 0;
    var arrmarker = new Array();
    jQuery('#product-lat').val(<?= $lat ?>);
    jQuery('#product-long').val(<?= $lng ?>);

    var platform = new H.service.Platform({
        'apikey': 'IXaetlCntXwtUCqEMmvbcaWYtsD8aSH1tfpSl-ElCS8' // Make sure to add your own API KEY
    });


    function switchMapLanguage(map, platform) {
        let defaultLayers = platform.createDefaultLayers({
            lg: 'vi'
        });
        map.setBaseLayer(defaultLayers.vector.normal.map);

        var ui = H.ui.UI.createDefault(map, defaultLayers);
        ui.removeControl('mapsettings');
    }

    function moveMapTo(map, lat, lng) {
        map.setCenter({
            lat: lat,
            lng: lng
        });
        map.setZoom(15);
        makeMarker(map, lat, lng);
    }

    function setUpClickListener(map) {
        map.addEventListener('tap', function (evt) {
            var coord = map.screenToGeo(evt.currentPointer.viewportX,
                evt.currentPointer.viewportY);
            var LocationOfMarker = {
                lat: Math.abs(coord.lat.toFixed(4)),
                lng: Math.abs(coord.lng.toFixed(4))
            };
            makeMarker(map, coord.lat.toFixed(4), coord.lng.toFixed(4));
            jQuery('#product-lat').val(Math.abs(coord.lat.toFixed(4)));
            jQuery('#product-long').val(Math.abs(coord.lng.toFixed(4)));
        });
    }

    function makeMarker(map, lat, lng) {
        var LocationOfMarker = {
            lat: lat,
            lng: lng
        };
        var svgIcon = '<svg width="24" height="24" ' +
            'xmlns="http://www.w3.org/2000/svg">' +
            '<rect stroke="white" fill="#1b468d" x="1" y="1" width="22" ' +
            'height="22" /><text x="12" y="18" font-size="12pt" ' +
            'font-family="Arial" font-weight="bold" text-anchor="middle" ' +
            'fill="white">N</text></svg>';

        var icon = new H.map.Icon(svgIcon, {
            size: {
                w: 20,
                h: 25
            }
        });
        i = window.igl;
        arrmarker[i] = new H.map.Marker(LocationOfMarker, {
            icon: icon,
        });
        map.addObject(arrmarker[i]);
        $('#latlng').val('' + lat + ',' + lng);
        if (i - 1 >= 0) {
            map.removeObject(arrmarker[i - 1]);
        }
        window.igl = i + 1;
    }

    var defaultLayers = platform.createDefaultLayers();
    var LocationOfMarker = {
        lat: <?= $lat ?>,
        lng: <?= $lng ?>
    };
    var map = new H.Map(document.getElementById('map-canvas'),
        defaultLayers.vector.normal.map, {
            center: LocationOfMarker,
            zoom: 1,
            type: 'base',
            pixelRatio: window.devicePixelRatio || 1
        });

    window.addEventListener('resize', () => map.getViewPort().resize());

    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

    var ui = H.ui.UI.createDefault(map, defaultLayers);

    window.onload = function () {
        moveMapTo(map, '<?= $lat ?>', '<?= $lng ?>');
    }
    setUpClickListener(map);
    switchMapLanguage(map, platform);
</script>
<script type="text/javascript">
    jQuery(document).on('click', '.videos:nth-last-child(1)', function () {
        if ($('.videos').length == 1 || ($('.videos:nth-last-child(2)').val() && $('.videos').length < 5)) {
            $('#add-videos').append('<input type="text" class="form-control videos" name="Product[videos][]">');
        }
    });
</script>
<script>
    jQuery(document).ready(function () {
        //onChange H??nh th???c
        jQuery('#product-category_type_id').on('change', function () {
            jQuery('.attribute-custom').empty();
            var category_type_id = $(this).val();
            jQuery.ajax({
                url: '<?= \yii\helpers\Url::to(['product-category/get-category-by-type']) ?>',
                type: 'GET',
                data: {
                    category_type_id: category_type_id,
                },
                success: function (result) {
                    var response = JSON.parse(result);
                    jQuery('#product-bo_donvi_tiente').val(response['bo_donvi_tiente']);
                    changeCategory(response);
                    changeMoney(response);
                }
            });
        });

        //onChange Danh m???c
        jQuery('#product-category_id').on('change', function () {
            var category_id = $(this).val();
            jQuery.ajax({
                url: '<?= \yii\helpers\Url::to(['product-category/get-attribute']) ?>',
                type: 'GET',
                data: {
                    category_id: category_id,
                },
                success: function (result) {
                    jQuery('.attribute-custom').empty();
                    jQuery('.attribute-custom').append(result);
                }
            });
        });

    });
    jQuery('.chosen-select').chosen();
    jQuery('.district-select').chosen().change(function () {
        var district_id = $(this).val();
        jQuery.ajax({
            url: '<?= \yii\helpers\Url::to(['get-ward']) ?>',
            type: 'GET',
            data: {
                district_id: district_id,
            },
            success: function (result) {
                var response = JSON.parse(result);
                changeWard(response);
                changeProject(response);
            }
        });

        var latlng = jQuery(this).find(':selected').data('coordinate');
        jQuery('#product-lat').val(latlng.split(',')[0]);
        jQuery('#product-long').val(latlng.split(',')[1]);
        moveMapTo(window.map, latlng.split(',')[0], latlng.split(',')[1])
    });

    jQuery('.ward-chosen-select').chosen().change(function () {
        var latlng = jQuery(this).find(':selected').data('coordinate');
        jQuery('#product-lat').val(latlng.split(',')[0]);
        jQuery('#product-long').val(latlng.split(',')[1]);
        moveMapTo(window.map, latlng.split(',')[0], latlng.split(',')[1])
    });

    jQuery('.province-select').chosen().change(function () {
        var id = $(this).val();
        jQuery.ajax({
            url: '<?= \yii\helpers\Url::to(['get-district']) ?>',
            type: 'GET',
            data: {
                province_id: id,
            },
            success: function (result) {
                var response = JSON.parse(result);
                changeDistrict(response);
                changeProject(response);

            }
        });
        var latlng = jQuery(this).find(':selected').data('coordinate');
        moveMapTo(window.map, latlng.split(',')[0], latlng.split(',')[1])
    });

    function changeDistrict(data) {
        var html_district = '<select data-placeholder="Ch???n qu???n/ huy???n" class="district-select" name="Product[district_id]" tabindex="5"><option value=""></option>';
        for (const [key, value] of Object.entries(data['district'])) {
            html_district += '<option data-coordinate="' + value['latlng'] + '" value="' + value['id'] + '">' + value['name'] + '</option>';
        }
        html_district += '</select>';
        jQuery('.ward_select').empty();
        jQuery('.ward_select').append('<select data-placeholder="Ch???n ph?????ng/ x??" class="ward-select" name="Product[ward_id]" tabindex="5"><option value=""></option></select>');
        jQuery('.ward-select').chosen();
        jQuery('.district_select').empty();
        jQuery('.district_select').append(html_district);
        jQuery('.district-select').chosen().change(function () {
            var district_id = $(this).val();
            jQuery.ajax({
                url: '<?= \yii\helpers\Url::to(['get-ward']) ?>',
                type: 'GET',
                data: {
                    district_id: district_id,
                },
                success: function (result) {
                    var response = JSON.parse(result);
                    changeWard(response);
                    changeProject(response);
                }
            });
            var latlng = jQuery(this).find(':selected').data('coordinate');
            moveMapTo(window.map, latlng.split(',')[0], latlng.split(',')[1]);
            jQuery('#product-lat').val(latlng.split(',')[0]);
            jQuery('#product-long').val(latlng.split(',')[1]);
        });
    };

    function changeWard(data) {
        var html_district = '<select data-placeholder="Ch???n ph?????ng/ x??" class="ward-select" name="Product[ward_id]" tabindex="5"><option value=""></option>';
        for (const [key, value] of Object.entries(data['ward'])) {
            html_district += '<option data-coordinate="' + value['latlng'] + '" value="' + value['id'] + '">' + value['name'] + '</option>';
        }
        html_district += '</select>';
        jQuery('.ward_select').empty();
        jQuery('.ward_select').append(html_district);
        jQuery('.ward-select').chosen().change(function () {
            var latlng = jQuery(this).find(':selected').data('coordinate');
            moveMapTo(window.map, latlng.split(',')[0], latlng.split(',')[1])
            jQuery('#product-lat').val(latlng.split(',')[0]);
            jQuery('#product-long').val(latlng.split(',')[1]);
        });
    };

    function changeProject(data) {
        var html_district = '<option value="">--- Ch???n d??? ??n ---</option>';
        for (const [key, value] of Object.entries(data['project'])) {
            html_district += '<option value="' + key + '">' + value + '</option>';
        }
        jQuery('#product-project_id').empty();
        jQuery('#product-project_id').append(html_district);
    };

    function changeCategory(data) {
        var html_district = '<option value="">--- Ch???n danh m???c ---</option>';
        for (const [key, value] of Object.entries(data['category'])) {
            html_district += '<option value="' + key + '">' + value + '</option>';
        }
        jQuery('#product-category_id').empty();
        jQuery('#product-category_id').append(html_district);
    };

    function changeMoney(data) {
        var html_district = '';
        for (const [key, value] of Object.entries(data['money'])) {
            html_district += '<option value="' + key + '">' + value + '</option>';
        }
        jQuery('#product-price_type').empty();
        jQuery('#product-price_type').append(html_district);
    };
</script>