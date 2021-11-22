<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;
$location = ClaLid::getLocaltionDefault();
// if(isset($_GET['province_id'])) {
//     $province_id = $_GET['province_id'];
// } else {
//     $province_id = ClaLid::getProvinceDefault();
// }
?>
<div class="flex-col flex-right search-engine hidden-xs">
    <div class="advanced-fix">
        <div class="close-btn-news"></div>
        <div class="search-new-area">
            <div class="choice-type">
                <?php
                    $typeSearch = common\components\ClaSearch::optionType();
                ?>
                <select name="type_search" id="type-search">
                    <?php foreach ($typeSearch as $k => $type) { ?>
                        <option <?= (isset($_GET['type_search']) && $_GET['type_search'] == $k) ? 'selected' : '' ?> value="<?= $k ?>"><?= $type ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-type">
                <input type="text" name="keyword" placeholder="<?= Yii::t('app', 'enter_text_search') ?>" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>"  data-load='2' autocomplete="off" id="searchInput" >
                <i class="fa fa-search"></i>
                <div class="box-searchResults">
                    <div id="searchResults" class="search-results">
                    </div>
                </div>
            </div>
            <div class="choice-location">
                <input type="hidden" id="input-latlng" value="<?= (isset($_GET['latlng']) && $_GET['latlng']) ? $_GET['latlng'] : '' ?>" name="latlng">
                <input type="text" id="pac-input" placeholder="<?= Yii::t('app', 'enter_your_location') ?>" name='textlatlng' value="<?= (isset($_GET['textlatlng']) && $_GET['textlatlng']) ? $_GET['textlatlng'] : '' ?>">
                <i class="fa fa-map-marker"></i>
                <div id="get-location" title="<?= Yii::t('app', 'get_your_location') ?>" class="check-location-desk click"><img src="<?= Yii::$app->homeUrl ?>images/icon-sefl-location-hascolor.png" alt=""></div>
            </div>
            <button id="search-all" type="submit" class="btn-submit-search"><?= Yii::t('app', 'search') ?></button>
        </div>
        <div title="<?= Yii::t('app', 'search_advance') ?>" class="btn-adv-search-news btn-show-search click"><i class="fa fa-search"></i></div>
    </div>
    <div class="hidden-lg hidden-md btn-search-new">
        <i class="fa fa-search"></i>
    </div>
    <script>
        $(document).ready(function(){
            $(".btn-search-new").click(function(){
                $(".advanced-fix").toggleClass("active");
            });
            $(".close-btn-news").click(function(){
                $(".advanced-fix").removeClass("active");
            });
        });
    </script>
</div>
<?= frontend\widgets\shoppingcart\Shoppingcart::widget() ?>

<div id="map-canvaseach" class="hidden">
</div>
<script>
    function initMap2() {
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
        //
    }
</script>
<?php
    $map_api_key = \common\components\ClaLid::API_KEY;
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $map_api_key ?>&callback=initMap2&libraries=places"></script>
<!-- hiển thị chỉnh kết quả gợi ý tìm kiếm theo vị trí, lấy vị trí -->
<script type="text/javascript">
    <?php 
        $data = $_GET;
        if(isset($data['latlng'])) {
            unset($data['latlng']);
        }
        if(isset($data['textlatlng'])) {
            unset($data['textlatlng']);
        }
    ?>
    function loadSearch(latlng, textlatlng) {
        latlng = latlng.replace("(", '');
        latlng = latlng.replace(" ", '');
        latlng = latlng.replace(")", '');
        $('#input-latlng').val(latlng);
    }
    $(document).ready(function() {
        $('#pac-input').change( function() {
            if(!$(this).val()) {
                $('#input-latlng').val('');
            }
            if($('#searchInput').val()) {
                searchAll()
;
            }
        });
    });
    count_search = 0;
    function onGeoSuccessDT(position) {
        var lat = position.coords['latitude'];
        var lng = position.coords['longitude'];
        // alert(lat+','+lng);
        // console.log(position.coords.longitude);
        if(lat && lng) {
            jQuery.ajax({
                url: '<?= Url::to(['/site/set-location']) ?>',
                data:{lat : lat, lng: lng},
                beforeSend: function () {
                },
                success: function (res) {
                    var tg = res.split('&');
                    console.log(res);
                    if(tg[0] && tg[1]) {
                        $('#pac-input').val(tg[1]);
                        $('#input-latlng').val(tg[0]);
                    } 
                },
                error: function () {
                }
            });
        } else {
            geolocation = navigator.geolocation;
            if (geolocation) {
                options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                if(count_search < 10) {
                    count_search = count_search + 1;
                    geolocation.getCurrentPosition(onGeoSuccessDT, onGeoErrorDT, options);
                }
            }
        }
        
    }
    function onGeoErrorDT(error) {
        let detailError;
        
        if(error.code === error.PERMISSION_DENIED) {
          detailError = "<?= Yii::t('app', 'permission_denined') ?>";
        } 
        else if(error.code === error.POSITION_UNAVAILABLE) {
          detailError = "Location information is unavailable.";
        } 
        else if(error.code === error.TIMEOUT) {
          detailError = "<?= Yii::t('app', 'request_timed_out') ?>"
        } 
        else if(error.code === error.UNKNOWN_ERROR) {
          detailError = "An unknown error occurred."
        }
        jQuery.ajax({
            url: '<?= Url::to(['/site/set-location']) ?>',
            data:{lat : 0, lng: 0},
            beforeSend: function () {
            },
            success: function (res) {
                console.log(res);
            },
            error: function () {
            }
        });
        alert(detailError);
    }
    $(document).ready(function() {
        $('#get-location').click(function () {
            let geolocation = navigator.geolocation;
            if (geolocation) {
                let options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                geolocation.getCurrentPosition(onGeoSuccessDT, onGeoErrorDT, options);
            }
        });
        $('#pac-input').change( function() {
            if(!$(this).val()) {
                $('#input-latlng').val('');
            }
            // $('#searchInput').attr('data-load',2);
        });

        //
        <?php 
            \Yii::$app->session->open();
            if(!isset($_SESSION['got_location'])) { ?>
            // let geolocation = navigator.geolocation;
            // if (geolocation) {
            //     let options = {
            //         enableHighAccuracy: true,
            //         timeout: 5000,
            //         maximumAge: 0
            //     };
            //     geolocation.getCurrentPosition(onGeoSuccess, onGeoError, options);
            // }
        <?php } ?>
    });
</script> 
<!-- hiển thị chỉnh kết quả gợi ý tìm kiếm -->
<script type="text/javascript">
    $(document).ready(function () {
        // $('#search-all').click(function () {
        //     var keyword = $('#searchInput').val();
        //     if (keyword == '' || keyword.length < 2) {
        //         alert('<?= Yii::t('app', 'alert_search') ?>');
        //         return false;
        //     }
        // });
        $('#type-search').change(function() {
            setTimeout( function() {
                searchAll()
;
                // var keyword = jQuery.trim($('#searchInput').val());
                // if(keyword) {
                //     searchAll()
;
                // }
            }, 100);
        });
        $('#searchInput').click(function () {
            var keyword = $('#searchInput').val();
            // if (keyword.length > 1) {
                if($(this).attr('data-load') == '2') {
                    searchAll()
;
                } else {
                    setTimeout(function() {
                        $('#searchResults').fadeIn(500); 
                    }, 200);
                    
                }
            // }
        });
    });

    var isAppend = false;
    var keyWordTemp = '-1';
    var typeTemp = '';
    var latlngTemp = '';
    jQuery(document).on('click', function (e) {
        if ($(e.target).closest("#searchForm").length === 0) {
            jQuery('#searchResults').fadeOut(200);
        }
    });
    jQuery('#searchInput').on('keyup', function () {
        var keyword = jQuery.trim(jQuery(this).val());
        if (keyword && keyword != keyWordTemp) {
            searchAll()
;
        } 
        // else if (!keyword) {
        //     jQuery('#searchResults').fadeOut(200);
        // }
    });
    //
    function searchAll()
 {
        if($('#searchInput').attr('data-load') != '0') {
            var url = "<?= Url::to(['/search/search/search-ajax']); ?>";
            $('#searchInput').attr('data-load', 0);
            setTimeout( function() {
                $('#searchResults').fadeIn(200);
                keyword = jQuery.trim($('#searchInput').val());
                type = jQuery.trim($('#type-search').val());
                latlng = jQuery.trim($('#input-latlng').val());
                isAppend = false;
                if (keyword != keyWordTemp || typeTemp != type || latlngTemp != latlng) {
                    keyWordTemp = keyword;
                    typeTemp = typeTemp;
                    Templatlng = latlng;
                    loadAjax(url, {keyword : keyword, type : type, latlng: latlng}, $('#searchResults'));
                }
                $('#searchInput').attr('data-load', 1);
            }, 500);
        }
    }
</script>
<!-- chỉnh kết quả gợi ý tìm kiếm -->
<script type="text/javascript">
    $(document).on('keyup keypress', '#form-top #pac-input', function(e) {
      if(e.which == 13) {
        e.preventDefault();
        return false;
      }
    });
    // jQuery(document).on('click', '.result-item>a', function () {
    //     $('#searchInput').val($(this).html());
    //     $('#form-top').submit();
    //     return false;
    // });
</script>