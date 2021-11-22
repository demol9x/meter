<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 7/1/2021
 * Time: 11:54 AM
 */
?>
<style>
    .section-product-filter {
        margin-top: 130px;
    }
</style>
<?=
\frontend\widgets\searchHome\SearchHomeWidget::widget([
    'view' => 'view',
])
?>
<link rel="stylesheet" href="/css/style-news.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .toggle-view {
        margin: 0 15px;
        display: flex;
        justify-content: start;
        align-items: center;
    }

    .toggle-view .toggle-view-action {
        width: 25px;
        height: 25px;
        line-height: 25px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #dbbf6d;
        color: #dbbf6d;
        margin-right: 5px;
    }

    .toggle-view .toggle-view-action:hover,
    .toggle-view .toggle-view-action.active {
        color: #fff;
        background-color: #dbbf6d;
    }

    .toggle-view-display {
        position: relative;
    }

    .toggle-view-display:not(.active) {
        display: none;
        visibility: hidden;
        opacity: 0;
    }

    .toggle-view-display.vmap .map-clusters-menu {
        height: 500px;
        width: 100%;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .toggle-view-display.vmap .map-clusters-menu ul {
        list-style: none;
    }

    .toggle-view-display.vmap .map-clusters-menu ul > li {
        border-bottom: 1px solid #b6b6b6;
    }

    .toggle-view-display.vmap .map-clusters-menu ul > li > a {
        display: flex;
        justify-content: start;
        align-left: start;
        font-size: 16px;
        color: #666;
        padding: 0 10px;
    }

    .toggle-view-display.vmap .map-clusters-menu ul > li > a .body-container h4 {
        font-size: 16px;
        color: #666;
    }

    .toggle-view-display.vmap .map-clusters-menu ul > li > a .body-container .bc-description {
        font-size: 14px;
        line-height: 150%;
        display: block;
        margin-bottom: 10px;
    }

    .toggle-view-display.vmap .map-clusters-menu ul > li > a .img-container {
        width: 30%;
        margin-right: 15px;
        height: 0;
        position: relative;
        overflow: hidden;
        padding-top: 30%;
    }

    .toggle-view-display.vmap .map-clusters-menu ul > li > a .img-container img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: auto;
    }

    .toggle-view-display.vmap .map-clusters-menu ul > li > a .body-container {
        width: calc(70% - 15px);
    }

    .toggle-view-display.vmap .map-clusters-menu .view-tabs {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .toggle-view-display.vmap .map-clusters-menu .view-tabs a {
        width: 50%;
        text-align: center;
        padding: 10px;
        font-size: 16px;
        background-color: #D7E7FF;
        color: #333333;
        text-decoration: none;
    }

    .toggle-view-display.vmap .map-clusters-menu .view-tabs a.active {
        background-color: #165699;
        color: #fff;
    }

    /* width */
    .map-clusters-menu::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    .map-clusters-menu::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    .map-clusters-menu::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    .map-clusters-menu::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    #map .H_ib_content {
        margin: 0 !important;
    }
</style>
<div class="container tab-container" style="display: none">
    <div class="row">
        <div class="col-12">
            <div class="toggle-view">
                <div class="toggle-view-action " data-view="vlist">
                    <i class="fa fa-list" aria-hidden="true"></i>
                </div>
                <div class="toggle-view-action active" data-view="vmap">
                    <i class="fa fa-map" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="toggle-view-display vlist">
    <?=
    $this->render('list', [
            'products' => $products,
            'limit' => $limit,
            'page' => $page,
            'totalCount' => $totalCount
        ]
    );
    ?>
</div>
<div class="toggle-view-display vmap active">
    <?=
    $this->render('map', [
            'products' => $products,
            'limit' => $limit,
            'page' => $page,
            'lat' => $lat,
            'lng' => $lng,
        ]
    );
    ?>
</div>
<script>
    $(document).ready(function () {
        $('.toggle-view-action').click(function (e) {
            e.preventDefault();
            var view = $(this).data('view');
            if (view == 'vmap') {
                $('.container.tab-container').css('display', 'none');
            } else {
                $('.container.tab-container').css('display', 'block');
            }
            $('.toggle-view-display').removeClass('active');
            $('.toggle-view-action').removeClass('active');
            var viewSelector = '.toggle-view-display.' + view;
            $(this).addClass('active');
            $(viewSelector).addClass('active');
            var vm = '.view-tabs a.' + view;
            $(vm).trigger('click');
            return;
        });

        $('.view-tabs a').click(function (e) {
            e.preventDefault();
            var view = $(this).data('view');
            $('.view-tabs a').removeClass('active');
            $(this).addClass('active');
            var viewSelector = '.toggle-view-display.' + view;
            $('.toggle-view-display').removeClass('active');
            $(viewSelector).addClass('active');
            var tva = '.toggle-view-action[data-view="' + view + '"]';
            $(tva).trigger('click');
            if (view == 'vmap') {
                $('.container.tab-container').css('display', 'none');
            } else {
                $('.container.tab-container').css('display', 'block');
            }
            return;
        })
    });
</script>