<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;

$lat = (isset($center['latlng']) && count(explode(',', $center['latlng'])) > 1) ? explode(',', $center['latlng'])[0] : 21.03139;
$lng = (isset($center['latlng']) && count(explode(',', $center['latlng'])) > 1) ? explode(',', $center['latlng'])[1] : 105.8525;
?>
<?php
if (isset($listMap) && $listMap) {
?>
    <div id="map-canvas" style="width: 100%; height: 365px; background-color: #F1F1F1;"></div>
    <script>
        $(document).ready(function() {
            var geocoder;
            var map;
            var marker;
            var infowindow;

            function initMapMap() {
                var uluru = {
                    lat: <?= $lat ?>,
                    lng: <?= $lng ?>
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
                    icon: '<?= __SERVER_NAME ?>/images/logo mo.png',
                });

                // var contentString = '';
                //
                // infowindow = new google.maps.InfoWindow({
                //     content: contentString
                // });
                //
                // infowindow.open(map, marker);
                geocoder = new google.maps.Geocoder();
                //
                //
                <?php $i = 0;
                if ($listMap) foreach ($listMap as $add) {
                    $i++;
                    $tg = explode(',', $add['latlng']);
                    if (count($tg) > 1) { ?>
                        marker[<?= $i ?>] = new google.maps.Marker({
                            position: {
                                lat: <?= $tg[0] ?>,
                                lng: <?= $tg[1] ?>
                            },
                            draggable: false,
                            map: map,
                            title: '<?= addcslashes($center['name'], "'") ?>',
                            url: '<?= $add['iframe'] ? $add['iframe'] : 'https://www.google.com/maps/@' . $tg[0] . ',' . $tg[1] . ',15z'; ?>',
                            icon: '<?= __SERVER_NAME ?>/images/logo mo.png',
                        });
                    <?php } ?>
                    google.maps.event.addListener(marker[<?= $i ?>], 'click', function() {
                        window.location.href = this.url;
                    });
                <?php } ?>

            }
            initMapMap();
        });
    </script>
<?php
}
?>