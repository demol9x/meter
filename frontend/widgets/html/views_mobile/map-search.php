<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;
use common\components\ClaSearch;

$center = explode(',', $center);
$lats =  $center[0];
$lngs =  $center[1];
$province = \common\models\Province::optionsProvince();
$promotion_all = \common\models\promotion\Promotions::getPromotionNowAll();
?>
<script type="text/javascript">
    var geocoder;
    var map;
    var markerx = new Array();
    var contentString = new Array();
    var infowindows = new Array();
    var marker;
    var infowindow;
    var lastWindow = null;
</script>
<div class="map">
    <div class="pad-15">
        <div class="map">
            <div id="map-canvas" style="width: 100%; height: 82vh; background-color: #F1F1F1;"></div>
            <script>
                $(document).ready(function() {
                    function initMapSearch() {
                        var uluru = {
                            lat: <?= $lats ?>,
                            lng: <?= $lngs ?>
                        };
                        var markers;
                        var points;
                        var cityCircle;
                        var directionsService = new google.maps.DirectionsService;
                        var directionsDisplay = new google.maps.DirectionsRenderer;
                        var image = {
                            url: '<?= Yii::$app->homeUrl ?>images/ico-cart.png',
                            // Kích cỡ hình
                            size: new google.maps.Size(32, 32),
                            // Gốc cho hình là oo
                            origin: new google.maps.Point(0, 0),
                            // Neo cho hình là 0, 32
                            anchor: new google.maps.Point(20, 20)
                        };
                        map = new google.maps.Map(document.getElementById('map-canvas'), {
                            zoom: <?= (isset($zoom) && $zoom) ? $zoom : 10 ?>,
                            center: uluru
                        });
                        directionsDisplay.setMap(map);
                        //
                        var input = document.getElementById('pac-input');
                        var searchBox = new google.maps.places.SearchBox(input);
                        // more details for that place.
                        searchBox.addListener('places_changed', function() {
                            var places = searchBox.getPlaces();
                            if (places.length == 0) {
                                return;
                            }
                            places.forEach(function(place) {
                                if (!place.geometry) {
                                    console.log("Returned place contains no geometry");
                                    return;
                                }
                                loadSearch(place.geometry.location.toString(), $('#pac-input').val());
                                return false;
                            });
                        });
                        <?php if ($get_range) { ?>
                            //
                            markerc = new google.maps.Marker({
                                position: uluru,
                                draggable: false,
                                map: map,
                                // icon: image,
                                title: '<?= Yii::t('app', 'your_location') ?>',
                            });
                            geocoder = new google.maps.Geocoder();
                            //
                            //
                            // cityCircle = new google.maps.Circle({
                            //     strokeColor: '#17a349',
                            //     strokeOpacity: 0.8,
                            //     strokeWeight: 2,
                            //     fillColor: '#17a349',
                            //     fillOpacity: 0.2,
                            //     map: map,
                            //     center: uluru,
                            //     radius: <?= ClaSearch::LOCATION_RANGE_DEFAULT ?>
                            // });
                            //
                        <?php } ?>
                        //
                        var dv = '<?= Yii::t('app', 'm') ?>'
                        <?php if ($listMap) foreach ($listMap as $product) {
                            $i = $product['id'];
                            $tg = explode(',', $product['latlng']);
                            if (count($tg) > 1) {
                                $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]);
                                $text_price = $product['price'] ? number_format($product['price'], 0, ',', '.') . ' ' . Yii::t('app', 'currency') : Yii::t('app', 'contact');
                                $text_star = '';
                                if ($product['price_range']) {
                                    $price_range = explode(',', $product['price_range']);
                                    $price_max = number_format($price_range[0], 0, ',', '.');
                                    $price_min = number_format($price_range[count($price_range) - 1], 0, ',', '.');
                                    $text_price = $price_max != $price_min ? $price_min . ' - ' . $price_max : $price_min;
                                    $text_price .= ' ' . Yii::t('app', 'currency');
                                }
                                if (isset($promotion_all[$product['id']]) && $promotion_all[$product['id']]) {
                                    $promotion_item = $promotion_all[$product['id']];
                                    $price = intval($promotion_item['price']);
                                    $text_price = number_format($promotion_item['price'], 0, ',', '.') . ' ' . Yii::t('app', 'currency');
                                }
                                for ($j = 1; $j < 6; $j++) {
                                    $text_star .= '<span class="fa fa-star' . (($product['rate'] >= $j) ? '' : '-o') . ' yellow"></span>';
                                }
                                $product['name'] = addcslashes($product['name'], "'");
                        ?>
                                contentString[<?= $i ?>] = '<div class="item-address info-map"><div class="img"> <a href="<?= $url ?>"> <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's100_100/', $product['avatar_name'] ?>" alt="<?= $product['name'] ?>"> </a> </div> <div class="title"> <h2> <a href="<?= $url ?>"><?= $product['name'] ?></a> </h2> <div class="review"> <span class="clear"><?= $text_price ?></span><div class="starss"><?= $text_star ?> <span><?= $product['rate_count'] ? '(' . $product['rate_count'] . ')' : '' ?></span> </div> </div> <div class="location"> <i class="fa fa-map-marker"></i> <?= $province[$product['province_id']] ?> <div class="distance"> <?= isset($product['distance']) ? number_format($product['distance'], 0, ',', '.') . "'+dv+'" : '' ?></div></div> </div> </div>';

                                infowindows[<?= $i ?>] = new google.maps.InfoWindow({
                                    content: contentString[<?= $i ?>]
                                });

                                markerx[<?= $i ?>] = new google.maps.Marker({
                                    position: {
                                        lat: <?= $tg[0] ?>,
                                        lng: <?= $tg[1] ?>
                                    },
                                    draggable: false,
                                    map: map,
                                    icon: image,
                                    title: '<?= $product['name'] ?>',
                                    code: '<?= $product['shop_id'] ?>'
                                });
                                markerx[<?= $i ?>].addListener('click', function() {
                                    if (lastWindow) lastWindow.close();
                                    map.setCenter({
                                        lat: <?= $tg[0] ?>,
                                        lng: <?= $tg[1] ?>
                                    });
                                    infowindows[<?= $i ?>].open(map, this);
                                    clickMarker(this.code);
                                    lastWindow = infowindows[<?= $i ?>];
                                });
                                $('#open-item-' + '<?= $i ?>').on('mouseenter', function() {
                                    if (lastWindow) lastWindow.close();
                                    map.setCenter({
                                        lat: <?= $tg[0] ?>,
                                        lng: <?= $tg[1] ?>
                                    });
                                    infowindows[<?= $i ?>].open(map, markerx[<?= $i ?>]);
                                    lastWindow = infowindows[<?= $i ?>];
                                });
                                $('#chiduong-' + '<?= $i ?>').on('click', function() {
                                    directionsService.route({
                                        origin: uluru,
                                        destination: {
                                            lat: <?= $tg[0] ?>,
                                            lng: <?= $tg[1] ?>
                                        },
                                        travelMode: 'DRIVING'
                                    }, function(response, status) {
                                        if (status === 'OK') {
                                            directionsDisplay.setDirections(response);
                                        }
                                    });
                                });
                        <?php }
                        } ?>
                        //
                    }
                    initMapSearch();
                });
            </script>
        </div>
    </div>
</div>
<script type="text/javascript">
    function clickMarker(id) {
        $('.item-address').removeClass('active');
        $('.move-position-' + id).addClass('active');
        $('#box-list-item-search').addClass('box-search-active');
    }
    jQuery(document).on('click', '#view-all-search', function() {
        $('#box-list-item-search').removeClass('box-search-active');
    });
</script>
<?php
$map_api_key = \common\components\ClaLid::API_KEY;
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $map_api_key ?>&callback=initMap&libraries=places">
</script>