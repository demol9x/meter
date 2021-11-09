<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;

$listMap = \common\models\shop\Shop::find()->where(['status' => 1])->all();
$tg = ClaLid::getLocaltionDefault();
$center = $tg['latlng'] ? $tg['latlng'] : "21.03139,105.8525";
$center = explode(',', $center);
$lats =  isset($center[0]) ? $center[0] : '21.03139';
$lngs =  isset($center[1]) ? $center[1] : '105.8525';
?>
<?php
if (isset($listMap) && $listMap) {
?>
    <div class="map">
        <div class="container">
            <div class="pad-15">
                <div class="count-shop">
                    <p class="center">
                        <!-- <?= Yii::t('app', 'shop_in_gca_1') . ' ' . count($listMap) . ' ' . Yii::t('app', 'shop_in_gca_2') ?>  -->
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

                            function initMapHome() {
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
                                    if (count($tg) > 1) {
                                ?>
                                        marker[<?= $i ?>] = new google.maps.Marker({
                                            position: {
                                                lat: <?= $tg[0] ?>,
                                                lng: <?= $tg[1] ?>
                                            },
                                            draggable: false,
                                            map: map,
                                            title: '<?= addcslashes($add['name'], "'") ?>',
                                            url: '<?= Url::to(['/shop/shop/detail', 'id' => $add['id'], 'alias' => $add['alias']]) ?>'

                                        });
                                        google.maps.event.addListener(marker[<?= $i ?>], 'click', function() {
                                            window.location.href = this.url;
                                        });
                                <?php }
                                } ?>

                            }
                            initMapHome();
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>