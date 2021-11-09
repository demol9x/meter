<?php
use yii\helpers\Url;
// use common\components\ClaLid;
// $latlngdf = ClaLid::getLatlngDefault();
// $FullTextlatlngdf = ClaLid::getFullTextLatlngDefault();
$listMap = $products;
    // $listid = [];
    // foreach ($products as $product) {
    //     if(!in_array($product['shop_id'] , $listid)) {
    //         $listMap[] = $product;
    //         $listid[] = $product['shop_id'];
    //     }
    // }
?>
<div class="search-width-googlemap">
    <div class="container">
        <div class="flex">
            <div class="col-map">
                <div class="show-mobile flex">
                        <button class="back-page">
                            <a href="<?= Yii::$app->homeUrl ?>">
                                <i style="color: #fff" class="fa fa-arrow-left" aria-hidden="true"></i>
                            </a>
                        </button>
                    <form class="ctn">
                        <div class="flex">
                            <div class="input-search-product">
                                <i class="fa fa-search"></i>
                                <input type="text" name="keyword" placeholder="<?= Yii::t('app', 'enter_text_search') ?>" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>"  data-load='2' autocomplete="off" id="searchInput" >
                            </div>
                            <button id="search-all" class="btn-search"><i class="fa fa-search"></i></button>
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
                            <a class="btn-self-location click" id="get-location">
                                <img src="images/icon-sefl-location.png" alt="">
                            </a>
                        </div>
                    </form>
                </div>
                <?=
                    \frontend\widgets\html\HtmlWidget::widget([
                        'view' => 'map-search',
                        'input' => [
                            'zoom' => 12,
                            'center' => $center,
                            'listMap' => $listMap,
                            'get_range' => $get_range
                        ]
                    ])
                ?>
            </div>
            <div class="btn-show-all-address">
                <i class="fa fa-angle-up"></i>
                <p>
                    <?= Yii::t('app', 'list_product') ?>
                    <span><?= count($products) ?> <?= Yii::t('app', 'location') ?></span>
                </p>
            </div>
            <div class="col-list-address">
                <div class="ds-addres" id="box-list-item-search">
                    <p id="view-all-search" class="click center"><?= Yii::t('app', 'view_all') ?></p>
                    <?php if($products) {
                        echo frontend\widgets\html\HtmlWidget::widget([
                                'input' => [
                                    'products' => $products,
                                ],
                                'view' => 'view_product_search'
                            ]);
                    } else { ?>
                        <p style="padding: 15px;"><?= Yii::t('app', 'product_not_found') ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".btn-show-all-address").click(function(){
           $(this).toggleClass('active');
           $('.col-list-address').toggleClass('active');
       });
 </script>
</div>
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
    function onGeoSuccess(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        // alert(lat+','+lng);
        jQuery.ajax({
            url: '<?= Url::to(['/site/set-location']) ?>',
            data:{lat : lat, lng: lng},
            beforeSend: function () {
            },
            success: function (res) {
                var tg = res.split('&');
                if(tg[0] && tg[1]) {
                    $('#pac-input').val(tg[1]);
                    $('#input-latlng').val(tg[0]);
                } else {
                    alert('<?= Yii::t('app','get_error_try_again') ?>')
                }
                
                console.log(tg);
            },
            error: function () {
            }
        });
    }
    function onGeoError(error) {
        let detailError;
        
        if(error.code === error.PERMISSION_DENIED) {
          detailError = '<?= Yii::t('app','permission_denined') ?>';
        } 
        else if(error.code === error.POSITION_UNAVAILABLE) {
          detailError = "Location information is unavailable.";
        } 
        else if(error.code === error.TIMEOUT) {
          detailError = "<?= Yii::t('app','request_timed_out') ?>"
        } 
        else if(error.code === error.UNKNOWN_ERROR) {
          detailError = "An unknown error occurred."
        }
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
                geolocation.getCurrentPosition(onGeoSuccess, onGeoError, options);
            }
        });
        $('#pac-input').change( function() {
            if(!$(this).val()) {
                $('#input-latlng').val('');
            }
            if($('#searchInput').val()) {
                search();
            }
        });
    });
</script> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#search-all').click(function () {
            var keyword = $('#searchInput').val();
            if (keyword == '' || keyword.length < 2) {
                alert('<?= Yii::t('app', 'alert_search') ?>');
                return false;
            }
        });
        $('#type-search').change(function() {
            setTimeout( function() {
                var keyword = jQuery.trim($('#searchInput').val());
                if(keyword) {
                    search();
                }
            }, 100);
        });
        $('#searchInput').click(function () {
            var keyword = $('#searchInput').val();
            if (keyword.length > 1) {
                if($(this).attr('data-load') == '2') {
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
    jQuery(document).on('click', function (e) {
        if ($(e.target).closest("#searchForm").length === 0) {
            jQuery('#searchResults').fadeOut(200);
        }
    });
    jQuery('#searchInput').on('keyup', function () {
        var keyword = jQuery.trim(jQuery(this).val());
        if (keyword && keyword != keyWordTemp) {
            search();
        } else if (!keyword) {
            jQuery('#searchResults').fadeOut(200);
        }
    });
    //
    function search() {
        if($('#searchInput').attr('data-load') != '0') {
            var url = "<?= Url::to(['/search/search/search-ajax']); ?>";
            $('#searchInput').attr('data-load', 0);
            setTimeout( function() {
                $('#searchResults').fadeIn(200);
                keyword = jQuery.trim($('#searchInput').val());
                type = jQuery.trim($('#type-search').val());
                latlng = jQuery.trim($('#input-latlng').val());
                isAppend = false;
                if (keyword && keyword != keyWordTemp || typeTemp != type || latlngTemp != latlng) {
                    keyWordTemp = keyword;
                    typeTemp = typeTemp;
                    Templatlng = latlng;
                    loadAjax(url, {keyword : keyword, type : type, latlng: latlng}, $('#searchResults'));
                } else if (!keyword) {
                    jQuery('#searchResults').fadeOut(200);
                }
                $('#searchInput').attr('data-load', 1);
            }, 500);
        }
    }
</script>