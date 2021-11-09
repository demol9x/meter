<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;
use common\components\ClaSearch;

$center = explode(',', $center);
$lats =  $center[0];
$lngs =  $center[1];
$province = \common\models\Province::optionsProvince();
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
                    function initMapIndexShopAjax() {
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
                        <?php } ?>
                        //
                        var dv = '<?= Yii::t('app', 'm') ?>'
                        <?php if ($listMap) foreach ($listMap as $shop) {
                            $i = $shop['id'];
                            $tg = explode(',', $shop['latlng']);
                            if (count($tg) > 1) {
                                $url = \yii\helpers\Url::to(['/shop/shop/detail', 'id' => $shop['id'], 'alias' => $shop['alias']]);
                                $src = $shop['avatar_path'] ? ClaHost::getImageHost() . $shop['avatar_path'] . 's100_100/' . $shop['avatar_name'] : ClaHost::getImageHost() . '/imgs/shop_default.png';
                                $shop['name'] = addcslashes($shop['name'], "'");
                                $text_star = '';
                                for ($j = 1; $j < 6; $j++) {
                                    $text_star .= '<span class="fa fa-star' . (($shop['rate'] >= $j) ? '' : '-o') . ' yellow"></span>';
                                }
                        ?>
                                contentString[<?= $i ?>] = '<div class="item-address info-map"><div class="img"> <a href="<?= $url ?>"> <img src="<?= $src ?>" alt="<?= $shop['name'] ?>"> </a> </div> <div class="title"> <h2> <a href="<?= $url ?>"><?= $shop['name'] ?></a> </h2> <div class="review"><div class="starss"><?= $text_star ?> <span><?= $shop['rate_count'] ? '(' . $shop['rate_count'] . ')' : '' ?></span> </div> </div> <div class="location"> <i class="fa fa-map-marker"></i> <?= $province[$shop['province_id']] ?> <div class="distance"> <?= isset($product['distance']) ? number_format($shop['distance'], 0, ',', '.') . "'+dv+'" : '' ?></div></div> </div> </div>';

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
                                    title: '<?= $shop['name'] ?>',
                                    code: '<?= $shop['id'] ?>'
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
                    initMapIndexShopAjax();
                });
            </script>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".btn-show-all-address").click(function() {
        $(this).toggleClass('active');
        $('.col-list-address').toggleClass('active');
    });

    function clickMarker(id) {
        $('.item-address').removeClass('active');
        $('.move-position-' + id).addClass('active');
        $('#box-list-item-search').addClass('box-search-active');
    }
    jQuery(document).on('click', '#view-all-search', function() {
        $('#box-list-item-search').removeClass('box-search-active');
    });
    initMap();
</script>