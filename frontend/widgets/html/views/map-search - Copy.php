<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;
use \common\models\Search;
$center = explode(',', $center);
$lats =  $center[0];
$lngs =  $center[1];
?>
<div class="map">
    <div class="pad-15">
        <div class="map">
            <div id="map-canvas" style="width: 100%; height: 803px; background-color: #F1F1F1;"></div>
            <script>
                var geocoder;
                var map;
                var markerx = new Array();
                var contentString = new Array();
                var infowindows = new Array();
                var marker;
                var infowindow;
                function initMap() {
                    var uluru = {
                        lat: <?= $lats ?>,
                        lng: <?= $lngs ?>
                    };
                    var markers;
                    var points;
                    var cityCircle;
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
                    //
                        var input = document.getElementById('pac-input');
                        var searchBox = new google.maps.places.SearchBox(input);
                        // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                        // Bias the SearchBox results towards current map's viewport.
                        map.addListener('bounds_changed', function() {
                          searchBox.setBounds(map.getBounds());
                        });
                        // Bias the SearchBox results towards current map's viewport.
                        map.addListener('bounds_changed', function() {
                          searchBox.setBounds(map.getBounds());
                        });

                        var markerbs = [];
                        // Listen for the event fired when the user selects a prediction and retrieve


                        // more details for that place.
                        searchBox.addListener('places_changed', function() {
                            var places = searchBox.getPlaces();
                            if (places.length == 0) {
                                return;
                            }
                            // Clear out the old markers.
                            // markerbs.forEach(function(marker) {
                            //     marker.setMap(null);
                            // });
                            // cityCircle.setMap(null);
                            // markerbs = [];
                            // For each place, get the icon, name and location.
                            // var bounds = new google.maps.LatLngBounds();
                            places.forEach(function(place) {
                                if (!place.geometry) {
                                  console.log("Returned place contains no geometry");
                                  return;
                                }
                                loadSearch(place.geometry.location.toString(), $('#pac-input').val());
                                return false;
                                // Create a marker for each place.
                                // markerbs.push(new google.maps.Marker({
                                //   map: map,
                                //   icon: image,
                                //   title: place.name,
                                //   position: place.geometry.location
                                // }));
                                // cityCircle = new google.maps.Circle({
                                //     strokeColor: '#17a349',
                                //     strokeOpacity: 0.8,
                                //     strokeWeight: 2,
                                //     fillColor: '#17a349',
                                //     fillOpacity: 0.2,
                                //     map: map,
                                //     center: place.geometry.location,
                                //     radius: <?= Search::LOCATION_RANGE_DEFAULT ?>
                                // });
                               
                                // if (place.geometry.viewport) {
                                //   bounds.union(place.geometry.viewport);
                                // } else {
                                //   bounds.extend(place.geometry.location);
                                // }
                                // return false;
                            });
                            map.fitBounds(bounds);
                        });
                    //
                        markerc = new google.maps.Marker({
                                    position: uluru,
                                    draggable: false,
                                    map: map,
                                    // icon: image,
                                    title: '<?= Yii::t('app', 'your_location') ?>',
                                });
                        // infowindow = new google.maps.InfoWindow({
                        //     content: '<?= Yii::t('app', 'your_location') ?>'
                        // });
                        // infowindow.open(map, markerc);
                    //
                    //
                        geocoder = new google.maps.Geocoder();
                    //
                        cityCircle = new google.maps.Circle({
                            strokeColor: '#17a349',
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: '#17a349',
                            fillOpacity: 0.2,
                            map: map,
                            center: uluru,
                            radius: <?= Search::LOCATION_RANGE_DEFAULT ?>
                        });
                    //
                    //
                        <?php $i = 0; if($listMap) foreach ($listMap as $add) {
                            $i++;
                            $tg = explode(',', $add['latlng']);
                            if(count($tg) > 1) {
                                $url = \yii\helpers\Url::to(['/product/product/detail', 'id' => $add['id'], 'alias' => $add['alias']]);
                                ?>
                                contentString[<?= $i ?>] = '<div class="item-address move-position-5"><div class="img"> <a href="<?= $url ?>"> <img src="<?= ClaHost::getImageHost(), $add['avatar_path'],'s100_100/', $add['avatar_name'] ?>" alt="<?= $add['name'] ?>"> </a> </div> <div class="title"> <h2> <a href="<?= $url ?>"><?= $add['name'] ?></a> </h2> <div class="review"> <span class="price"> <del>300.000</del>                                200.000 Đ </span> <div class="star"> <span class="fa fa-star-o yellow"></span> <span class="fa fa-star-o yellow"></span> <span class="fa fa-star-o yellow"></span> <span class="fa fa-star-o yellow"></span> <span class="fa fa-star-o yellow"></span> <span></span> </div> <div class="distance"> 200m </div> </div> <div class="location"> <i class="fa fa-map-marker"></i> Hà Nội </div> </div> </div>';

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
                                    title: '<?= addcslashes($add['name'], "'") ?>',
                                    code: '<?= $add['shop_id'] ?>'

                                });
                                markerx[<?= $i ?>].addListener('click', function() {
                                  infowindows[<?= $i ?>].open(map, this);
                                  clickMarker(this.code);
                                });
                                // google.maps.event.addListener(markerx[<?= $i ?>], 'click', function() {
                                //         clickMarker(this.code);
                                //     });
                            <?php } 
                        } ?>
                    //
                }
                
            </script>
            <?php
                $map_api_key = \common\components\ClaLid::API_KEY;
            ?>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=<?= $map_api_key ?>&callback=initMap&libraries=places&sensor=false">
            </script>
           
        </div>
    </div>
</div>
<script type="text/javascript">
    function clickMarker(id) {
        $('.item-address').removeClass('active');
        $('.move-position-'+id).addClass('active');
    }
    <?php 
        if(isset($_GET['latlng'])) {
            unset($_GET['latlng']);
        }
        if(isset($_GET['textlatlng'])) {
            unset($_GET['textlatlng']);
        }
    ?>
    function loadSearch(latlng, textlatlng) {
        latlng = latlng.replace("(", '');
        latlng = latlng.replace(" ", '');
        latlng = latlng.replace(")", '');
        window.location.href ='<?= $_GET ? Url::to(array_merge(['/search/search/index'], $_GET)).'&' : Url::to(array_merge(['/search/search/index'], $_GET)) ?>'+'latlng='+latlng+'&textlatlng='+textlatlng;
    }
</script> 
