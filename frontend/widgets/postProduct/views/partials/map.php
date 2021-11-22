<div class="ps-map">
    <div class="partial-head">Bản đồ</div>
    <div class="partial-content">
        <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
        <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
        <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
        <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
        <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>

        <input id="product-lat" type="hidden" name="Product[lat]">
        <input id="product-long" type="hidden" name="Product[long]">
        <small class="d-block mb-3">Để tăng độ tin cậy và tin rao được nhiều người quan tâm hơn, hãy sửa vị trí tin rao của bạn trên bản đồ bằng nhấp tới đúng vị trí của tin rao</small>
        <div style="width: 100%; height: 480px" id="map-container"></div>
        <?php
        $lat = 21.05;
        $lng = 105.79944;
        ?>
        <script>
            var igl = 0;
            var arrmarker = new Array();

            var platform = new H.service.Platform({
                'apikey': 'IXaetlCntXwtUCqEMmvbcaWYtsD8aSH1tfpSl-ElCS8' // Make sure to add your own API KEY
            });
            // configure an OMV service to use the `core` endpoint

            function switchMapLanguage(map, platform) {
                // Create default layers
                let defaultLayers = platform.createDefaultLayers({
                    lg: 'vi'
                });
                // Set the normal map variant of the vector map type
                map.setBaseLayer(defaultLayers.vector.normal.map);

                // Display default UI components on the map and change default
                // language to simplified Chinese.
                // Besides supported language codes you can also specify your custom translation
                // using H.ui.i18n.Localization.
                var ui = H.ui.UI.createDefault(map, defaultLayers);
                // Remove not needed settings control
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
                map.addEventListener('tap', function(evt) {
                    //get lat lng click
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

                // Create a marker icon from an image URL:
                var icon = new H.map.Icon(svgIcon, {
                    size: {
                        w: 20,
                        h: 25
                    }
                });
                // Create a marker using the previously instantiated icon:
                i = window.igl;
                arrmarker[i] = new H.map.Marker(LocationOfMarker, {
                    icon: icon,
                });
                map.addObject(arrmarker[i]);
                $('#latlng').val('' + lat + ',' + lng);
                // console.log(i);
                if (i - 1 >= 0) {
                    map.removeObject(arrmarker[i - 1]);
                }
                window.igl = i + 1;
            }
            // https://www.google.com/maps/dir/168 Ngọc Khánh, Ba Đình, Hà Nội, Việt Nam?hl=vi-VN
            // https://www.google.com/maps/dir//21.0250595,105.7484402?hl=vi-VN

            /**
             * Boilerplate map initialization code starts below:
             */

            var defaultLayers = platform.createDefaultLayers();
            var LocationOfMarker = {
                lat: <?= $lat ?>,
                lng: <?= $lng ?>
            };
            //Step 2: initialize a map - this map is centered over Europe
            var map = new H.Map(document.getElementById('map-container'),
                defaultLayers.vector.normal.map, {
                    center: LocationOfMarker,
                    zoom: 1,
                    type: 'base',
                    pixelRatio: window.devicePixelRatio || 1
                });

            // add a resize listener to make sure that the map occupies the whole container
            window.addEventListener('resize', () => map.getViewPort().resize());

            //Step 3: make the map interactive
            // MapEvents enables the event system
            // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
            var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

            // Create the default UI components
            var ui = H.ui.UI.createDefault(map, defaultLayers);

            // Now use the map as required...
            window.onload = function() {
                moveMapTo(map, '<?= $lat ?>', '<?= $lng ?>');
            }
            setUpClickListener(map);
            switchMapLanguage(map, platform);
        </script>
    </div>
</div>