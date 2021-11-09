<?php

use yii\helpers\Html;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .error {
        color: red;
    }
    .col-50 {
        width: 50%;
        float: left;
    }
    .img-form {
        min-height: 200px;
    }
    .box-imgs {
        padding-right: 91px;
        margin-left: -15px;
    }
    .form-create-store select {
        display: block !important;
    }
    .form-create-store .nice-select {
        display: none !important;
    }
    #add-phone {
        background: #ebebeb;
        display: inline-block;
        padding: 3px 14px;
        font-size: 24px;
        margin-top: -20px;
    }
    #remove-phone {
        background: #ebebeb;
        display: inline-block;
        padding: 3px 11px;
        font-size: 24px;
        margin-top: -20px;
        margin-left: 20px;
        color: red;
    }
    #box-add-phone {
        margin-top: -30px;
    }
    .phone_add {
        margin-top: -10px !important;
    }
</style>
<?php $form = ActiveFormC::begin(); ?>

    <?= $form->fields($model, 'name_contact')->textInput(['maxlength' => true]) ?>

    <?= $form->fields($model, 'phone')->textInput(['maxlength' => true]) ?>
    <div id="box-add-phone">
        <?php if($model->phone_add) {
            $phone_adds = explode(',', $model->phone_add);
            for ($i=0; $i < count($phone_adds); $i++) { 
                if($phone_adds[$i]) {
                    ?>
                    <div class="item-input-form class-add-phone">    
                        <label class="" for="shopaddress-phone"></label>    
                        <div class="group-input">        
                            <div class="full-input">             
                                <input type="text" class="phone_add" name="ShopAddress[phone_add][]" value="<?= $phone_adds[$i] ?>" maxlength="13">        
                            </div>    
                        </div>
                    </div>
                <?php }
            }
        } ?>
    </div>
    <div class="item-input-form">
        <label class="" for="shopaddress-phone"></label>    
        <div class="group-input">        
            <div class="full-input">                     
                <span class="click" id="add-phone">+</span>
                <span class="click" id="remove-phone"><i class="fa fa-trash" aria-hidden="true"></i></span>
            </div>    
        </div>
    </div>
    <script type="text/javascript">
        function isAlphaNum(_this) {
            var txt = _this.val().replace( /^\D+/g, '');
            var numb = txt.match(/\d/g);
            if(numb) {
                numb = numb.join("");
            }
            return numb;
        }
        $(document).ready(function () {
            $('#add-phone').click(function () {
                html ='<div class="item-input-form class-add-phone">';
                html +='    <label class="" for="shopaddress-phone"></label>';
                html +='    <div class="group-input">';
                html +='        <div class="full-input">';
                html +='             <input type="text" class="phone_add" class="form-control" name="ShopAddress[phone_add][]" value="" maxlength="13">';
                html +='        </div>';
                html +='    </div>';
                html +='</div>';
                $('#box-add-phone').append(html);
            });
            $('#remove-phone').click(function () {
                if(confirm('<?= Yii::t('app', 'delete_sure') ?>')) {
                    $('.class-add-phone').last().remove();
                }
            });
        });
        jQuery(document).on('change', '.phone_add', function () {
            $(this).val(isAlphaNum($(this)));
            if($(this).val().length < 9) {
                $(this).addClass('error');
            } else {
                $(this).removeClass('error');
            }
        });
    </script>

    <?= $form->fields($model, 'province_id', ['arrSelect' => $list_province])->textSelect(['class' => 'select-province-id']) ?>

    <?= $form->fields($model, 'district_id', ['arrSelect' => $list_district])->textSelect(['class' => 'select-district-id']) ?>

    <?= $form->fields($model, 'ward_id', ['arrSelect' => $list_ward])->textSelect(['class' => 'select-ward-id']) ?>

    <?= $form->fields($model, 'address')->textInput(['maxlength' => true, 'id'=>'pac-input-sadd']) ?>
    <div class="form-group field-shop-name required has-success">
        <div class="item-input-form">
            <label class="" for="shop-name">
            </label>
            <div class="group-input">
                <div class="full-input">
                    <div class="box-map">
                        <?php $latlng = $model->latlng ? $model->latlng : '21.03139,105.8525' ?>
                        <input type="hidden" name="ShopAddress[latlng]" id="latlng" value="<?=  $model->latlng ?>">    
                        <div id="map-canvas" style="width: 100%; margin-left: 10px;height: 550px; background-color: #F1F1F1;" class="span10 col-sm-12"></div>

                        <!-- start map -->
                            <script type="text/javascript">
                                function generateAddress() {
                                    var province_id = $('#province_id').val();
                                    var district_id = $('#district_id').val();
                                    var ward_id = $('#ward_id').val();
                                    var street_id = $('#pac-input-sadd').val();
                                    var street_name = $('#pac-input-sadd').val();
                                    var street_prefix = '';
                                    var province_name = province_id ? $("#province_id option:selected").text() : '';
                                    var district_name = district_id ? $("#district_id option:selected").text() : '';
                                    var ward_name = ward_id ? $("#ward_id option:selected").text() : '';
                                    var ward_prefix = ward_id ? $("#ward_id option:selected").attr('wardprefix') : '';
                                    var address = '';
                                    var addressmap = '';
                                    if (street_id && ward_id && district_id) {
                                        address = street_prefix + ' ' + street_name + ', ' + district_name + ', ' + province_name;
                                        // console.log(address);
                                        addressmap = street_name + ', ' + district_name + ', ' + province_name + ', Việt Nam';
                                        codeAddress(addressmap);
                                    } else if (ward_id && district_id) {
                                        address = ward_prefix + ' ' + ward_name + ', ' + district_name + ', ' + province_name;
                                        // console.log(address);
                                        addressmap = ward_name + ', ' + district_name + ', ' + province_name + ', Việt Nam';
                                        codeAddress(addressmap);
                                    } else if (district_id) {
                                         // console.log(address);
                                        address = district_name + ', ' + province_name;
                                        addressmap = district_name + ', ' + province_name + ', Việt Nam';
                                        codeAddress(addressmap);
                                    }
                                    $('#realestate-address-demo').val(address);
                                    $('#realestate-address').val(address);
                                    if (address != '') {
                                        $('.demo-address-preview').text(address);
                                    } else {
                                        $('.demo-address-preview').text('N/A');
                                    }
                                }
                                $(document).ready(function () {
                                    jQuery(document).on('change', '#province_id', function () {
                                        $('#pac-input-sadd').val('');
                                        jQuery.ajax({
                                            url: '<?php //echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                                            data: 'pid=' + jQuery('#province_id').val(),
                                            dataType: 'JSON',
                                            beforeSend: function () {
                                            },
                                            success: function (res) {
                                                if (res.code == 200) {
                                                    jQuery('#district_id').html(res.html);
                                                }
                                                getWard();
                                            },
                                            error: function () {
                                            }
                                        });
                                    });
                                    jQuery(document).on('change', '#district_id', function () {
                                        $('#pac-input-sadd').val('');
                                        getWard();
                                    });
                                    function getWard() {
                                        jQuery.ajax({
                                            url: '<?php //echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
                                            data: 'did=' + jQuery('#district_id').val(),
                                            dataType: 'JSON',
                                            beforeSend: function () {
                                            },
                                            success: function (res) {
                                                if (res.code == 200) {
                                                    jQuery('#ward_id').html(res.html);
                                                }
                                            },
                                            error: function () {
                                            }
                                        });
                                    }
                                    // Chọn phường/xã
                                    $('#ward_id').change(function () {
                                        $('#pac-input-sadd').val('');
                                        generateAddress();
                                    });
                                    // Chọn đường phố
                                    $('#pac-input-sadd').change(function () {
                                        generateAddress();
                                    });
                                });
                            </script>
                            <?php 
                                $latlng= explode(',', $latlng); 
                                $lats = $latlng[0];
                                $lngs = $latlng[1];
                            ?>
                            <script>
                                var geocoder;
                                var map;
                                var marker;
                                var infowindow;
                                function initMap() {
                                    var uluru = {
                                        lat: <?= $lats>0 && $lats ? $lats : '21.03139' ?>,
                                        lng: <?= $lngs>0 && $lngs ? $lngs : '105.8525' ?>
                                    };
                                    map = new google.maps.Map(document.getElementById('map-canvas'), {
                                        zoom: 15,
                                        center: uluru
                                    });
                                    marker = new google.maps.Marker({
                                        position: uluru,
                                        draggable: true,
                                        map: map
                                    });
                                    var contentString = '<?= $model->address ? $model->address : 'Hà Nội' ?>';
                                    //
                                    infowindow = new google.maps.InfoWindow({
                                        content: contentString
                                    });
                                    //
                                    infowindow.open(map, marker);
                                    geocoder = new google.maps.Geocoder();
                                    //
                                    google.maps.event.addListener(marker, 'dragend', function () {
                                        geocoder.geocode({
                                            latLng: marker.getPosition()
                                        }, function (responses) {
                                            if (responses && responses.length > 0) {
                                                infowindow.setContent(responses[0].formatted_address);
                                            }
                                        });
                                    });
                                }

                                function codeAddress(address) {
                                    geocoder.geocode({'address': address}, function (results, status) {
                                        if (status == 'OK') {
                                            map.setCenter(results[0].geometry.location);
                                            marker.setPosition(results[0].geometry.location);
                                            infowindow.setContent(address);
                                            addLatlng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                                        }
                                    });
                                }

                                function addLatlng(lat, lng) {
                                    var latlng = lat + ',' + lng;
                                    $('#latlng').val(latlng);
                                }
                            </script>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $('.select-province-id').change(function () {
                                        var province_id = $(this).val();
                                        $.getJSON(
                                                "<?= \yii\helpers\Url::to(['/suggest/getdistrict']) ?>",
                                                {province_id: province_id, label: 'Quận/huyện'}
                                        ).done(function (data) {
                                            $('.select-district-id').html(data.html);
                                            $('.select-ward-id').html('<option>Phường/xã</option>');
                                        }).fail(function (jqxhr, textStatus, error) {
                                            var err = textStatus + ", " + error;
                                            console.log("Request Failed: " + err);
                                        });
                                    });

                                    $('.select-district-id').change(function () {
                                        var district_id = $(this).val();
                                        $.getJSON(
                                                "<?= \yii\helpers\Url::to(['/suggest/getward']) ?>",
                                                {district_id: district_id, label: 'Phường/xã'}
                                        ).done(function (data) {
                                            $('.select-ward-id').html(data.html);
                                        }).fail(function (jqxhr, textStatus, error) {
                                            var err = textStatus + ", " + error;
                                            console.log("Request Failed: " + err);
                                        });
                                    });
                                });
                            </script>
                        <!-- end map -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $model->isdefault ? '' : $form->fields($model, 'isdefault', ['arrSelect' => ['0' => Yii::t('app', 'not_select'), '1' => Yii::t('app', 'default')]])->textSelect(['class' => 'select-default-id']) ?>

    <div class="btn-submit-form">
        <input type="submit" id="shop-form" value="<?= ($model->isNewRecord) ?  Yii::t('app','create_shop') :  Yii::t('app','update_shop') ?>">
    </div>
<?php ActiveFormC::end(); ?>
