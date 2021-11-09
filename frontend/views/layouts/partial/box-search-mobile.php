<?php

use yii\helpers\Url;
use common\components\ClaLid;

$app = \common\components\ClaSite::isActiceApp();
?>
<?php
$latlngdf = ClaLid::getLatlngDefault();
$FullTextlatlngdf = ClaLid::getFullTextLatlngDefault();
?>
<style type="text/css">
    .pac-container {
        z-index: 99999999;
    }

    #box-search-mobile .nice-select {
        width: 40%;
        background: unset;
        border: unset;
        color: #fff;
        height: 29px;
        float: left;
        margin-top: -5px;
        padding-left: 26px;
    }

    #box-search-mobile .nice-select:after {
        border-bottom: 2px solid #fff;
        border-right: 2px solid #fff;
        height: 7px;
        width: 7px;
        margin-top: -1px;
    }
    #box-search-mobile #searchInput {
        width: 60%;
        border-left: 1px solid #ffffff1f;
    }
</style>
<div id="box-search-mobile">
    <div class="search-width-googlemap">
        <div class="container">
            <div class="flex">
                <div class="col-map">
                    <div class="show-mobile flex">
                        <button class="back-page">
                            <?php
                            \Yii::$app->session->open();
                            ?>
                            <a>
                                <i style="color: #fff" class="fa fa-arrow-left" aria-hidden="true"></i>
                            </a>
                        </button>
                        <form class="ctn" id="from-search-mobile" action="<?= Url::to(['/search/search/index']) ?>">
                            <div class="flex">
                                <div class="input-search-product">
                                    <i class="fa fa-search"></i>
                                    <input type="text" name="keyword" placeholder="<?= Yii::t('app', 'enter_text_search') ?>" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" data-load='2' autocomplete="off" id="searchInput">
                                    <select name="type" id="search-type">
                                        <option value="1">Sản phẩm</option>
                                        <option value="2">Gian hàng</option>
                                    </select>
                                </div>
                                <button id="search-all" class="button btn-search"><i class="fa fa-search"></i></button>
                                <div class="box-searchResults">
                                    <div id="searchResults" class="search-results">
                                    </div>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="input-self-location">
                                    <input type="hidden" id="input-latlng" value="<?= (isset($_GET['latlng']) && $_GET['latlng']) ? $_GET['latlng'] : '' ?>" name="latlng">
                                    <i class="fa fa-map-marker"></i>
                                    <input type="text" id="pac-input" placeholder="<?= Yii::t('app', 'enter_your_location') ?>" name='textlatlng' value="<?= (isset($_GET['textlatlng']) && $_GET['textlatlng']) ? $_GET['textlatlng'] : '' ?>">
                                </div>
                                <a class="button btn-self-location click" id="get-location" data-latlng="<?= $latlngdf ?>" data-text="<?= $FullTextlatlngdf ?>">
                                    <img src="<?= Yii::$app->homeUrl ?>images/icon-sefl-location.png" alt="">
                                </a>
                            </div>
                        </form>
                    </div>
                    <div id="box-load-search">
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $(".btn-show-all-address").click(function() {
                    $(this).toggleClass('active');
                    $('.col-list-address').toggleClass('active');
                });
                <?php if (!$app) {  ?>
                    $('#search-all').click(function() {
                        jQuery('#searchResults').fadeOut(100);
                        var keyword = $('#searchInput').val();
                        // if (keyword == '' || keyword.length < 2) {
                        //     alert('<?= Yii::t('app', 'alert_search') ?>');
                        //     return false;
                        // }
                        href = '<?= Url::to(['/search/search/index-ajax']) ?>';
                        loadAjax(href, $('#from-search-mobile').serialize(), $('#box-load-search'));
                        return false;
                    });
                <?php } ?>
            });
        </script>
    </div>
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
                    return false;
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $map_api_key ?>&callback=initMap2&libraries=places&sensor=false"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#type-search').change(function() {
            setTimeout(function() {
                var keyword = jQuery.trim($('#searchInput').val());
                if (keyword) {
                    search();
                }
            }, 100);
        });
        $('#searchInput').click(function() {
            var keyword = $('#searchInput').val();
            if (keyword.length > 1) {
                if ($(this).attr('data-load') == '2') {
                    search();
                } else {
                    setTimeout(function() {
                        $('#searchResults').fadeIn(500);
                    }, 200);

                }
            }
        });
    });

    var isAppend = false;
    var keyWordTemp = '';
    var typeTemp = '';
    var latlngTemp = '';
    jQuery(document).on('click', function(e) {
        if ($(e.target).closest("#searchForm").length === 0) {
            jQuery('#searchResults').fadeOut(200);
        }
    });
    jQuery('#searchInput').on('keyup', function() {
        var keyword = jQuery.trim(jQuery(this).val());
        if (keyword && keyword != keyWordTemp) {
            search();
        } else if (!keyword) {
            jQuery('#searchResults').fadeOut(200);
        }
    });
    //
    function search() {
        if ($('#searchInput').attr('data-load') != '0') {
            var url = "<?= Url::to(['/search/search/search-ajax']); ?>";
            $('#searchInput').attr('data-load', 0);
            setTimeout(function() {
                $('#searchResults').fadeIn(200);
                keyword = jQuery.trim($('#searchInput').val());
                type = jQuery.trim($('#type-search').val());
                latlng = jQuery.trim($('#input-latlng').val());
                isAppend = false;
                if (keyword && keyword != keyWordTemp || typeTemp != type || latlngTemp != latlng) {
                    keyWordTemp = keyword;
                    typeTemp = typeTemp;
                    Templatlng = latlng;
                    loadAjax(url, {
                        keyword: keyword,
                        type: type,
                        latlng: latlng
                    }, $('#searchResults'));
                } else if (!keyword) {
                    jQuery('#searchResults').fadeOut(200);
                }
                $('#searchInput').attr('data-load', 1);
            }, 500);
        }
    }
</script>
<script type="text/javascript">
    $(document).on('keyup keypress', '#pac-input', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            return false;
        }
    });
    jQuery(document).on('click', '.result-item>a', function() {
        $('#searchInput').val($(this).html());
        $('#search-all').click();
        return false;
    });
</script>
<script type="text/javascript">
    var count_search = 0;

    function loadSearch(latlng, textlatlng) {
        latlng = latlng.replace("(", '');
        latlng = latlng.replace(" ", '');
        latlng = latlng.replace(")", '');
        $('#input-latlng').val(latlng);
    }

    function onGeoSuccessMB(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        // alert(lat+','+lng);
        jQuery.ajax({
            url: '<?= Url::to(['/site/set-location']) ?>',
            data: {
                lat: lat,
                lng: lng
            },
            beforeSend: function() {},
            success: function(res) {
                var tg = res.split('&');
                if (tg[0] && tg[1]) {
                    $('#pac-input').val(tg[1]);
                    console.log(tg);
                    $('#input-latlng').val(tg[0]);
                } else {
                    // alert('Vui lòng thử lại!');
                    let geolocation = navigator.geolocation;
                    if (geolocation) {
                        let options = {
                            enableHighAccuracy: true,
                            timeout: 5000,
                            maximumAge: 0
                        };
                        if (count_search < 30) {
                            geolocation.getCurrentPosition(onGeoSuccessMB, onGeoErrorMB, options);
                            count_search = count_search + 1;
                        }
                    }
                }
            },
            error: function() {}
        });
    }

    function onGeoErrorMB(error) {
        let detailError;

        if (error.code === error.PERMISSION_DENIED) {
            detailError = "<?= Yii::t('app', 'permission_denined') ?>";
        } else if (error.code === error.POSITION_UNAVAILABLE) {
            detailError = "Location information is unavailable.";
        } else if (error.code === error.TIMEOUT) {
            detailError = "<?= Yii::t('app', 'request_timed_out') ?>"
        } else if (error.code === error.UNKNOWN_ERROR) {
            detailError = "An unknown error occurred."
        }
        jQuery.ajax({
            url: '<?= Url::to(['/site/set-location']) ?>',
            data: {
                lat: 0,
                lng: 0
            },
            beforeSend: function() {},
            success: function(res) {
                console.log(tg);
            },
            error: function() {}
        });
        alert(detailError);
    }
    $(document).ready(function() {
        $('#get-location').click(function() {
            let geolocation = navigator.geolocation;
            if (geolocation) {
                let options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                geolocation.getCurrentPosition(onGeoSuccessMB, onGeoErrorMB, options);
            }
        });
        $('#pac-input').change(function() {
            if (!$(this).val()) {
                $('#input-latlng').val('');
            }
            // $('#searchInput').attr('data-load',2);
        });
    });
</script>
<script type="text/javascript">
    function showAndroidToast(toast) {
        <?php
        $detect = new \common\components\ClaMobileDetect();
        if ($detect->is('AndroidOS')) { ?>
            Android.showSearchBar();
        <?php } ?>
    }
    $(document).on('click', '.back-page', function() {
        $('#box-search-mobile').removeClass('open');
        $('body').css('overflow', 'auto');
        showAndroidToast('Hello Android!');
    });
</script>