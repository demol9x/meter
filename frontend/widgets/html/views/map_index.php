<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;

$tg = ClaLid::getLocaltionDefault();
$center = $tg['latlng'] ? $tg['latlng'] : "21.03139,105.8525";
$center = explode(',', $center);
$lats =  isset($center[0]) ? $center[0] : '21.03139';
$lngs =  isset($center[1]) ? $center[1] : '105.8525';
?>
<div class="map">
    <div class="container">
        <div class="pad-15">
            <div class="count-shop">
                <p class="center">
                    <?= Yii::t('app', 'shop_in_gca_map_3') ?>
                </p>
            </div>
            <div class="map">
                <div id="map-canvas" style="width: 100%; height: 550px; background-color: #F1F1F1;"></div>
                <script>
                    $(document).ready(function() {
                        var geocoder;
                        var map;
                        var marker;
                        var infowindow;

                        function initMapindex() {
                            var uluru = {
                                lat: <?= $lats ?>,
                                lng: <?= $lngs ?>
                            };
                            var markers;
                            var points;
                            map = new google.maps.Map(document.getElementById('map-canvas'), {
                                zoom: <?= (isset($zoom) && $zoom) ? $zoom : 10 ?>,
                                center: uluru
                            });
                            marker = new google.maps.Marker({
                                position: uluru,
                                draggable: false,
                                map: map,
                                icon: '/',
                            });
                            geocoder = new google.maps.Geocoder();
                            infoWindow = new google.maps.InfoWindow(); //Cửa sổ chi tiết

                            downloadUrl(baseUrl + "ajax/gen-shop-xml.html", function(data) {
                                //Thiết lập menu
                                var xml = data.responseXML;
                                var markers = xml.documentElement.getElementsByTagName("shop");
                                var menu = '';
                                // console.log(markers);
                                for (var i = 0; i < markers.length; i++) {
                                    var title = markers[i].getAttribute("title");
                                    var lat = markers[i].getAttribute("lat");
                                    var lng = markers[i].getAttribute("lng");
                                    var url = markers[i].getAttribute("url");
                                    var point = new google.maps.LatLng(
                                        parseFloat(lat),
                                        parseFloat(lng)
                                    );
                                    //Gắn sơ đồ nếu có mã tương ứng
                                    var marker = new google.maps.Marker({
                                        map: map,
                                        position: point,
                                        draggable: false,
                                        title: title,
                                        url: url,
                                        icon: '<?= __SERVER_NAME ?>/images/logo mo.png',
                                    });
                                    //Hiển thị thông tin chi tiết
                                    google.maps.event.addListener(marker, 'click', function() {
                                        window.location.href = this.url;
                                    });
                                }
                            });
                        }

                        function downloadUrl(url, callback) {
                            var request = window.ActiveXObject ?
                                new ActiveXObject('Microsoft.XMLHTTP') :
                                new XMLHttpRequest;

                            request.onreadystatechange = function() {
                                if (request.readyState == 4) {
                                    request.onreadystatechange = doNothing;
                                    callback(request, request.status);
                                }
                            };

                            request.open('GET', url, true);
                            request.send(null);
                        }

                        function doNothing() {}
                        initMapindex();
                    });
                </script>
            </div>
        </div>
    </div>
</div>