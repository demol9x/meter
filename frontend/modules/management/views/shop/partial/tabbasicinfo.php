<?php

use yii\helpers\Html;
use common\components\ClaHost;

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
</style>

<?= $form->fields($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->fields($model, 'type', ['arrSelect' => \common\models\shop\Shop::getType()])->textSelectMultiple() ?>

<?= $form->fields($model, 'time_limit_type_term', ['arrSelect' => \common\models\shop\Shop::getLimitType()])->textSelect() ?>

<?= $form->fields($model, 'name_contact')->textInput(['maxlength' => true]) ?>

<?= $form->fields($model, 'cmt')->textInput(['maxlength' => true]) ?>

<?= $form->fields($model, 'phone')->textInput(['maxlength' => true]) ?>

<?php if ($user->email) {
	$model->email = time() . 'randomemail@gmail.com';
	echo $form->field($model, 'email')->textInput(['type' => 'hidden'])->label(false);
} else {
	echo $form->fields($model, 'email')->textInput(['maxlength' => true]);
}
?>

<?= $form->fields($model, 'scale', ['arrSelect' => \common\models\shop\Shop::getScale()])->textSelect() ?>

<?= $form->fields($model, 'shop_acount_type', ['arrSelect' => \common\models\shop\Shop::getOptionsTypeAcount()])->textSelect() ?>

<?= $form->fields($model, 'province_id', ['arrSelect' => $list_province])->textSelect(['class' => 'select-province-id']) ?>

<?= $form->fields($model, 'district_id', ['arrSelect' => $list_district])->textSelect(['class' => 'select-district-id']) ?>

<?= $form->fields($model, 'ward_id', ['arrSelect' => $list_ward])->textSelect(['class' => 'select-ward-id']) ?>

<?= $form->fields($model, 'address')->textInput(['maxlength' => true, 'id' => 'pac-input-shop']) ?>

<div class="form-group field-shop-name">
	<div class="item-input-form">
		<label class="" for="shop-name">
		</label>
		<div class="group-input">
			<div class="full-input">
				<div class="box-map">
					<?php $latlng = $model->latlng ? $model->latlng : '21.03139,105.8525' ?>
					<input type="hidden" name="Shop[latlng]" id="latlng" value="<?= $model->latlng ?>">
					<div id="map-canvas" style="width: 100%;height: 550px; background-color: #F1F1F1;" class="span10 col-sm-12"></div>

					<!-- start map -->
					<script type="text/javascript">
						function generateAddress() {
							var province_id = $('#province_id').val();
							var district_id = $('#district_id').val();
							var ward_id = $('#ward_id').val();
							var street_id = $('#pac-input-shop').val();
							var street_name = $('#pac-input-shop').val();
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
						$(document).ready(function() {
							jQuery(document).on('change', '#province_id', function() {
								$('#pac-input-shop').val('');
								jQuery.ajax({
									url: '<?php //echo Yii::app()->createUrl('/suggest/suggest/getdistrict') 
											?>',
									data: 'pid=' + jQuery('#province_id').val(),
									dataType: 'JSON',
									beforeSend: function() {},
									success: function(res) {
										if (res.code == 200) {
											jQuery('#district_id').html(res.html);
										}
										getWard();
									},
									error: function() {}
								});
							});
							jQuery(document).on('change', '#district_id', function() {
								$('#pac-input-shop').val('');
								getWard();
							});

							function getWard() {
								jQuery.ajax({
									url: '<?php //echo Yii::app()->createUrl('/suggest/suggest/getward') 
											?>',
									data: 'did=' + jQuery('#district_id').val(),
									dataType: 'JSON',
									beforeSend: function() {},
									success: function(res) {
										if (res.code == 200) {
											jQuery('#ward_id').html(res.html);
										}
									},
									error: function() {}
								});
							}
							// Chọn phường/xã
							$('#ward_id').change(function() {
								$('#pac-input-shop').val('');
								generateAddress();
							});
							// Chọn đường phố
							$('#pac-input-shop').change(function() {
								generateAddress();
							});
						});
					</script>
					<?php
					$latlng = explode(',', $latlng);
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
								lat: <?= $lats > 0 && $lats ? $lats : '21.03139' ?>,
								lng: <?= $lngs > 0 && $lngs ? $lngs : '105.8525' ?>
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
							google.maps.event.addListener(marker, 'dragend', function() {
								geocoder.geocode({
									latLng: marker.getPosition()
								}, function(responses) {
									if (responses && responses.length > 0) {
										infowindow.setContent(responses[0].formatted_address);
									}
								});
							});
						}

						function codeAddress(address) {
							geocoder.geocode({
								'address': address
							}, function(results, status) {
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
					<?php
					$map_api_key = \common\components\ClaLid::API_KEY;
					// 'AIzaSyASKkUwPAv8gLNxUu6Gle-_lddGWzUHdaE';
					?>
					<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $map_api_key ?>&callback=initMap">
					</script>
					<script type="text/javascript">
						$(document).ready(function() {
							$('.select-province-id').change(function() {
								var province_id = $(this).val();
								$.getJSON(
									"<?= \yii\helpers\Url::to(['/suggest/getdistrict']) ?>", {
										province_id: province_id,
										label: 'Quận/huyện'
									}
								).done(function(data) {
									$('.select-district-id').html(data.html);
									$('.select-ward-id').html('<option>Phường/xã</option>');
								}).fail(function(jqxhr, textStatus, error) {
									var err = textStatus + ", " + error;
									console.log("Request Failed: " + err);
								});
							});

							$('.select-district-id').change(function() {
								var district_id = $(this).val();
								$.getJSON(
									"<?= \yii\helpers\Url::to(['/suggest/getward']) ?>", {
										district_id: district_id,
										label: 'Phường/xã'
									}
								).done(function(data) {
									$('.select-ward-id').html(data.html);
								}).fail(function(jqxhr, textStatus, error) {
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

<?= $form->fields($model, 'description')->textArea() ?>

<div class="hidden" id="download"></div>