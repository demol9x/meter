<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 7/4/2021
 * Time: 11:27 AM
 */

use common\components\ClaBds;
use \yii\helpers\Url;
use \common\components\ClaHost;

?>
<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-clustering.js"></script>

<?php
if(isset($products) && $products) {
$clusters = array();
foreach ($products as $key => $product) {
    $clusters[$key] = array(
        "url" => Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]),
        "thumbnail" => $product['avatar_path'] && $product['avatar_path'] ? ClaHost::getImageHost() . $product['avatar_path'] . '/' . $product['avatar_name'] : '',
        "marker" => "",
        "width" => 120,
        "height" => 120,
        "title" => $product['name'],
        "author" => "VZoneLand",
        "license" => null,
        "latitude" => $product['lat'] ? doubleval($product['lat']) : 21.014176,
        "longitude" => $product['long'] ? doubleval($product['long']) : 105.789398,
        "pageid" => $product['id'],
        "fullurl" => $product['avatar_path'] && $product['avatar_path'] ? ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] : '',
        "price" => $product['price'] ? $product['price']." ".ClaBds::getBoDonVi($product['bo_donvi_tiente'])[$product['price_type']] : 'Liên hệ',
        "dien_tich" => $product['dien_tich']. ' m2',
        "dia_chi" => $product['address'].', '.$product['ward_name'].', '.$product['district_name'].', '.$product['province_name'],
        "created_at" => date('d/m/Y', $product['created_at'])
    );
}
?>

<style type="text/css">
    #map{
        width: 100%;
        height: 800px;
    }

    #map canvas {
        width: 100% !important;
        height: 100% !important;
    }
    .bubble {
        font-size: 11px;
        line-height: 15px;
        color: white;
    }
    .bubble-image {
        width: 300px;
        height: 100px;
        background-size: cover;
        background-position: center;
        display: block;
    }
    .bubble-logo {
        float: left;
        margin-right: 1em;
        margin-bottom: 4px;
    }
    .bubble-footer {
        display: table;
    }
    .bubble-desc {
        display: table-cell;
        vertical-align: middle;
    }
    .bubble a {
        text-decoration: none;
        color: white !important;
    }
    .bubble a:hover {
        text-decoration: underline;
    }

    .bubble hr {
        margin: 5px 0px;
    }
</style>

    <style>
        .main-view {
            margin-top: 20px;
            clear: both;
            width: 99%;
            z-index: 1;
            border-top: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }
        .list-view {
            width: 400px;
            background-color: #fff;
            vertical-align: top;
            border-right: 1px solid #ccc;
        }
    </style>

    <table class="main-view">
        <tbody>
        <tr>
            <td class="list-view">
                <div class="map-clusters-menu">
                    <div class="view-tabs">
                        <a href="javascript:void(0)" class="vmap active" data-view="vmap">
                            Xem trên bản đồ
                        </a>
                        <a href="javascript:void(0)" class="vlist" data-view="vlist">
                            Xem theo danh sách
                        </a>
                    </div>
                    <ul>

                    </ul>
                </div>
            </td>
            <td class="map-view">
                <div id="map" style="width: 100%; height: 500px;"></div>
            </td>
        </tr>
        </tbody>
    </table>


<script>
    var clusters = <?php print_r(json_encode($clusters)) ?>;
    const apikey = 'IXaetlCntXwtUCqEMmvbcaWYtsD8aSH1tfpSl-ElCS8';
    var svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
        viewBox="0 0 82.93 125" enable-background="new 0 0 82.93 100" xml:space="preserve" fill="#165699">
        <path
            d="M-333.946,11.294c-16.482-16.481-43.113-16.348-59.594,0.134c-16.482,16.481-16.599,43.171-0.118,57.963L-363.879,99  l29.842-29.843C-317.555,54.364-317.465,27.776-333.946,11.294z M-363.766,66.342c-14.022,0-25.39-11.368-25.39-25.39  s11.368-25.39,25.39-25.39s25.39,11.368,25.39,25.39S-349.743,66.342-363.766,66.342z" />
        <path
            d="M-202.331,12.09c-16.208-16.208-42.397-16.077-58.605,0.131c-16.208,16.208-16.323,42.454-0.115,58.663L-231.767,100  l29.347-29.347C-186.213,54.445-186.124,28.298-202.331,12.09z M-231.656,66.224c-13.79,0-24.968-11.179-24.968-24.968  c0-13.79,11.179-24.969,24.968-24.969s24.968,11.179,24.968,24.969C-206.688,55.045-217.866,66.224-231.656,66.224z" />
        <path
            d="M-60.182,13.09c-16.208-16.208-42.397-16.077-58.605,0.131c-16.208,16.208-16.323,42.454-0.116,58.663L-89.618,101  l29.347-29.347C-44.063,55.445-43.974,29.298-60.182,13.09z M-89.507,67.224c-13.789,0-24.968-11.179-24.968-24.968  c0-13.79,11.179-24.969,24.968-24.969c13.79,0,24.969,11.179,24.969,24.969C-64.538,56.045-75.717,67.224-89.507,67.224z" />
        <path
            d="M70.818,12.09C54.61-4.117,28.422-3.986,12.214,12.222C-3.994,28.429-4.109,54.676,12.098,70.884L41.382,100l29.347-29.347  C86.937,54.445,87.026,28.298,70.818,12.09z M41.493,66.224c-13.789,0-24.968-11.179-24.968-24.968  c0-13.79,11.179-24.969,24.968-24.969c13.79,0,24.969,11.179,24.969,24.969C66.462,55.045,55.283,66.224,41.493,66.224z" />
        <path
            d="M-362.478-135.934c0,2.354-0.972,4.288-2.914,5.8c-1.943,1.513-2.915,2.83-2.915,3.951v40.646h-4.763v-40.646  c0-1.121-0.972-2.438-2.914-3.951c-1.943-1.513-2.915-3.446-2.915-5.8c0-6.389,1.42-12.534,4.259-18.438v15.804h2.522v-15.804h2.801  v15.804h2.578v-15.804C-363.898-148.468-362.478-142.323-362.478-135.934z" />
        <path
            d="M-348.696-137.391c0.037,2.28-0.412,8.854-1.346,19.727h-1.4v32.128h-4.764v-32.128h-0.784v-36.708  c1.605,0.262,2.97,0.99,4.091,2.186C-350.135-149.346-348.734-144.415-348.696-137.391z" />
        <path
            d="M-328.432-166.671c-19.526-19.526-51.077-19.368-70.604,0.158c-19.526,19.526-19.666,51.146-0.139,68.672l35.28,35.078  l35.355-35.355C-309.013-115.645-308.906-147.145-328.432-166.671z M-363.76-101.454c-16.613,0-30.081-13.468-30.081-30.081  s13.468-30.081,30.081-30.081s30.081,13.468,30.081,30.081S-347.147-101.454-363.76-101.454z" />
        <path
            d="M-196.321-166.671c-19.526-19.526-51.077-19.368-70.604,0.158c-19.526,19.526-19.666,51.146-0.139,70.673l35.28,35.078  l35.355-35.355C-176.903-115.645-176.795-147.145-196.321-166.671z M-231.65-101.454c-16.613,0-30.081-13.468-30.081-30.081  s13.468-30.081,30.081-30.081s30.081,13.468,30.081,30.081S-215.037-101.454-231.65-101.454z" />
        <path
            d="M-53.172-166.671c-19.526-19.526-51.077-19.368-70.604,0.158c-19.526,19.526-19.666,51.146-0.14,70.673l35.28,35.078  l35.355-35.355C-33.753-115.645-33.646-147.145-53.172-166.671z M-88.501-101.454c-16.612,0-30.08-13.468-30.08-30.081  s13.468-30.081,30.08-30.081c16.613,0,30.081,13.468,30.081,30.081S-71.888-101.454-88.501-101.454z" />
        <path
            d="M76.828-166.671c-19.526-19.526-51.077-19.368-70.604,0.158c-19.526,19.526-19.665,51.146-0.14,70.673l35.28,35.078  l35.355-35.355C96.247-115.645,96.354-147.145,76.828-166.671z M41.499-101.454c-16.612,0-30.08-13.468-30.08-30.081  s13.468-30.081,30.08-30.081c16.613,0,30.081,13.468,30.081,30.081S58.112-101.454,41.499-101.454z" />
        <g>
            <path
                d="M-235.426-131.428l-17.677-2.486l1.676-5.109l18.92-1.405l3.379-10.352c0.757-2.325,1.91-3.487,3.459-3.487   c0.901,0,1.676,0.266,2.325,0.797c0.648,0.532,0.973,1.239,0.973,2.122c0,0.667-0.171,1.532-0.514,2.595l-3.325,10.271   l14.677,12.406l-1.676,5.108l-15.947-8.487l-3.487,10.677l3.676,7.676l-1.244,3.838l-6.838-8.622l-10.623,2.946l1.243-3.838   l7.568-4.082L-235.426-131.428z" />
        </g>
        <g>
            <path
                d="M-89.087-136.497l6.922-6.922c-0.169-0.638-0.253-1.285-0.253-1.941c0-1.97,0.675-3.63,2.025-4.98   c1.352-1.351,2.992-2.026,4.925-2.026c0.675,0,1.341,0.094,1.998,0.281l-5.347,5.346l5.233,5.262l5.347-5.347   c0.188,0.657,0.281,1.313,0.281,1.97c0,1.932-0.676,3.574-2.026,4.924s-2.991,2.026-4.924,2.026c-0.713,0-1.416-0.103-2.11-0.31   l-6.781,6.781l-5.487,5.459l-6.443,6.472c0.206,0.694,0.31,1.388,0.31,2.083c0,1.951-0.671,3.602-2.012,4.952   c-1.342,1.351-2.987,2.026-4.938,2.026c-0.656,0-1.312-0.094-1.97-0.281l5.347-5.346l-5.262-5.262l-5.347,5.347   c-0.188-0.657-0.281-1.313-0.281-1.97c0-1.932,0.676-3.574,2.026-4.924s3.001-2.026,4.952-2.026c0.656,0,1.312,0.084,1.97,0.253   l6.612-6.584L-89.087-136.497z" />
        </g>
        <polygon
            points="62.499,-132.769 40.799,-154.468 19.552,-133.221 27.14,-133.141 27.14,-115.367 55.14,-115.367 55.14,-132.846 " />
        <path
            d="M-346.661,26.943l-0.555-0.555c0.006-0.009,0.013-0.017,0.019-0.026c-0.042-0.029-0.084-0.053-0.126-0.082l-0.128-0.128  c-0.005,0.011-0.013,0.021-0.019,0.033c-2.124-1.468-4.326-2.504-6.611-3.083c-2.833,1.275-5.585,2.862-8.254,4.762  c-2.669,1.9-5.261,4.108-7.776,6.624c-2.428,2.428-4.578,4.962-6.451,7.604c-1.872,2.641-3.462,5.395-4.77,8.261  c0.675,2.436,1.725,4.667,3.131,6.703c-0.015,0.008-0.028,0.016-0.043,0.024l0.708,0.708c1.12,1.12,2.097,1.665,2.933,1.631  c0.834-0.033,1.854-0.654,3.062-1.861c1.68-1.681,2.603-3.2,2.768-4.562c0.164-1.361-0.413-2.701-1.73-4.02l-0.608-0.607  c0,0,0,0,0,0l-0.346-0.346c-1.625-1.625,0.109-4.984,5.205-10.08c4.93-4.93,8.208-6.583,9.833-4.958l0.24,0.24  c-0.011,0.003-0.022,0.008-0.033,0.011l0.74,0.741c1.208,1.208,2.501,1.705,3.879,1.491c1.378-0.214,2.891-1.145,4.537-2.792  c1.175-1.175,1.79-2.169,1.846-2.982C-345.157,28.881-345.639,27.964-346.661,26.943z" />
        <path
            d="M-219.671,26.276c-2.784-1.916-6.605-2.873-11.334-2.873c-4.759,0-8.46,0.958-11.244,2.873  c-2.454,1.677-3.612,3.697-3.612,6.061v23.296h4v3h3v-3h16v3h3v-3h4V32.337C-215.86,29.973-217.217,27.953-219.671,26.276z   M-242.652,53.797c-1.287,0-1.931-0.644-1.931-1.931c0-1.257,0.644-1.885,1.931-1.885c1.286,0,1.93,0.628,1.93,1.885  C-240.722,53.154-241.366,53.797-242.652,53.797z M-231.86,42.633h-12v-10h12V42.633z M-219.532,53.797  c-1.257,0-1.885-0.644-1.885-1.931c0-1.257,0.628-1.885,1.885-1.885c1.287,0,1.93,0.628,1.93,1.885  C-217.602,53.154-218.245,53.797-219.532,53.797z M-217.86,42.633h-12v-10h12V42.633z" />
        <path
            d="M-282.27,300.102c-2.246-1.818-6.417-4.812-6.417-8.021c0-5.775,1.925-12.62,6.631-16.257  c9.839-7.701,31.016-12.192,43.422-12.192c12.299,0,35.294,4.706,44.492,13.262c4.385,4.064,5.455,9.412,5.455,16.792  c0,1.604-3.958,4.598-6.312,6.416l-22.246-10.802c0-1.069,0.108-2.459,0.108-3.851c0-4.063-0.642-8.663-5.455-8.663h-32.085  c-4.813,0-5.455,4.6-5.455,8.663c0,1.392,0.107,2.781,0.107,3.851L-282.27,300.102z" />
        <path
            d="M-238.694,281.261c-8.45,0-15.722,7.273-15.722,15.722c0,8.771,7.272,16.257,15.935,16.257  c8.77,0,16.043-6.951,16.043-15.828C-222.438,288.427-229.925,281.261-238.694,281.261z M-238.275,305.304  c-4.34,0-7.857-3.519-7.857-7.856c0-4.339,3.517-7.857,7.857-7.857c4.339,0,7.857,3.519,7.857,7.857  C-230.418,301.785-233.936,305.304-238.275,305.304z" />
        <path
            d="M-206.86,312.829l-7.174-12.196h-3.636c-0.749,8-10.481,18.073-19.786,18.073c-10.802,0-20.534-7.073-21.925-18.073h-3.851  l-8.628,12.196v22.804h6.491c-0.013,0-0.034,0.336-0.034,0.434c0,1.416,1.35,2.639,3.015,2.639s3.015-1.261,3.015-2.676  c0-0.099-0.021-0.396-0.034-0.396h41.036c-0.013,0-0.034,0.336-0.034,0.434c0,1.416,1.35,2.639,3.015,2.639  c1.665,0,3.015-1.261,3.015-2.676c0-0.099-0.021-0.396-0.034-0.396h5.55V312.829z" />
        <g>
            <path
                d="M-87.708,27.564v11.941h11.449v5.15h-11.449v12.051h-5.368V44.655h-11.449v-5.15h11.449V27.564H-87.708z" />
        </g>
        <path
            d="M-322.196,303.846c0-9.768-9.665-17.734-18.665-18.088v-4.125h-67v49.792c0,3.585,3.321,6.208,6.906,6.208h53.011  c3.585,0,7.083-2.623,7.083-6.208v-9.491C-331.86,321.582-322.196,313.615-322.196,303.846z M-340.86,313.28v-18.867  c5,0.322,10.01,4.424,10.01,9.433S-335.86,312.956-340.86,313.28z" />
        <path
            d="M-371.34,277.936c-2.96-1.436-5.746-3.141-8.506-4.912c-2.738-1.806-5.391-3.729-7.918-5.987  c-0.626-0.573-1.249-1.167-1.859-1.824c-0.609-0.671-1.2-1.359-1.768-2.364c-0.262-0.535-0.604-1.1-0.647-2.25  c-0.015-0.561,0.156-1.367,0.626-2.003c0.463-0.635,1.05-0.989,1.497-1.182c0.915-0.376,1.542-0.398,2.113-0.435  c0.571-0.021,1.071,0.006,1.551,0.05c0.873,0.081,1.485,0.131,2.248,0.153c0.729,0.023,1.456,0.012,2.178-0.036  c1.443-0.081,2.873-0.282,4.232-0.644c1.355-0.338,2.667-0.835,3.733-1.479c0.532-0.31,0.999-0.667,1.301-0.99  c0.321-0.32,0.342-0.567,0.351-0.391c0.013,0.074,0.068,0.175,0.078,0.155c0.009-0.011-0.044-0.109-0.188-0.228  c-0.137-0.121-0.346-0.251-0.583-0.386c-0.114-0.059-0.251-0.131-0.456-0.222l-0.537-0.247c-1.455-0.657-2.936-1.329-4.411-2.029  c-2.947-1.415-5.899-2.909-8.679-4.817c-1.36-0.991-2.753-2.001-3.839-3.464c-0.505-0.716-1.029-1.697-0.754-2.733  c0.331-0.997,1.156-1.451,1.895-1.755c-0.591,0.547-1.138,1.238-1.088,1.884c0.022,0.619,0.494,1.143,1.052,1.591  c1.149,0.889,2.575,1.564,4.02,2.153c2.899,1.198,5.932,2.188,8.978,3.193c1.526,0.506,3.057,1.003,4.606,1.552l0.586,0.207  c0.169,0.059,0.405,0.147,0.661,0.25c0.496,0.205,0.997,0.472,1.51,0.83c0.509,0.359,1.041,0.838,1.487,1.506  c0.446,0.657,0.769,1.557,0.792,2.438c0.04,0.888-0.182,1.691-0.479,2.335c-0.298,0.647-0.666,1.176-1.048,1.625  c-0.767,0.895-1.595,1.534-2.434,2.077c-1.69,1.057-3.441,1.713-5.208,2.184c-1.775,0.439-3.568,0.679-5.353,0.733  c-0.895,0.021-1.785,0-2.67-0.062c-0.853-0.056-1.849-0.173-2.58-0.302c-0.321-0.054-0.628-0.086-0.868-0.096  c-0.234-0.021-0.425,0.034-0.262-0.035c0.07-0.04,0.313-0.16,0.532-0.47c0.229-0.308,0.292-0.706,0.277-0.863  c-0.046-0.337-0.067-0.128,0.026,0.057c0.175,0.435,0.573,1.036,0.995,1.608c0.425,0.585,0.907,1.173,1.413,1.754  c2.022,2.344,4.303,4.618,6.562,6.912C-375.921,273.291-373.59,275.543-371.34,277.936z" />
        <path
            d="M296.894-171.212c-0.912-0.912-2.477-1.155-4.933-1.155h-36.264c-2.386,0-3.869-0.397-4.446-0.767  c-0.58-0.366-1.114-1.571-1.606-3.395l-0.578-2.317c-0.491-1.824-1.184-3.119-2.08-3.629c-0.894-0.508-2.692-0.892-5.394-0.892  h-20.211c-3.263,0-5.315,0.348-6.158,0.839c-0.842,0.491-1.562,1.894-2.157,4.104l-0.526,2.131c-0.352,1.368-0.843,2.515-1.474,2.99  c-0.632,0.473-1.702,0.936-3.211,0.936h-3c-4.315,0-6.716,1.749-6.716,6.1v60.9h100v-60.953  C298.14-168.812,297.806-170.299,296.894-171.212z M238.263-154.655c2.425,0,4.39,1.965,4.39,4.39s-1.965,4.39-4.39,4.39  s-4.39-1.965-4.39-4.39S235.838-154.655,238.263-154.655z M222.368-118.004l-14.739,0.09l23.562-23.562l7.324,7.324l15.949,15.951  L222.368-118.004z M259.465-118.202l-15.949-15.951l15.728-15.728l31.624,31.626L259.465-118.202z" />
        <g>
            <polygon points="246.14,-34.047 254.241,-42.148 246.14,-50.249  " />
            <path
                d="M296.907-74.337c-0.912-0.912-2.462-1.03-4.917-1.03h-36.264c-2.387,0-3.869-0.522-4.447-0.892   c-0.58-0.366-1.113-1.633-1.605-3.458l-0.578-2.348c-0.492-1.824-1.184-3.01-2.08-3.52c-0.895-0.508-2.693-0.783-5.395-0.783   H221.41c-3.262,0-5.314,0.223-6.158,0.714c-0.842,0.491-1.561,1.832-2.156,4.042l-0.527,2.1c-0.352,1.368-0.842,2.625-1.473,3.099   c-0.633,0.473-1.703,1.045-3.211,1.045h-3c-4.316,0-6.745,1.499-6.745,5.85v61.15h100V-69.57   C298.14-72.062,297.819-73.424,296.907-74.337z M273.14-31.471c0,2.266-1.837,4.104-4.103,4.104h-39.795   c-2.266,0-4.103-1.837-4.103-4.104v-19.793c0-2.266,1.837-4.104,4.103-4.104h39.795c2.266,0,4.103,1.837,4.103,4.104V-31.471z" />
        </g>
        <g>
            <path
                d="M244.425,41.704l0.094,3.45c0,0,11.595-5.27,18.397-3.641l-0.288-1.822C262.628,39.691,255.442,37.583,244.425,41.704z" />
            <path
                d="M296.89,23.65c-0.912-0.912-2.479-1.018-4.936-1.018H255.69c-2.386,0-3.869-0.534-4.446-0.904   c-0.58-0.366-1.114-1.639-1.606-3.463l-0.578-2.352c-0.491-1.824-1.184-2.999-2.08-3.509c-0.894-0.508-2.692-0.772-5.394-0.772   h-20.211c-3.263,0-5.315,0.211-6.158,0.702c-0.842,0.491-1.562,1.825-2.157,4.035l-0.526,2.097   c-0.352,1.368-0.843,2.635-1.474,3.11c-0.632,0.473-1.702,1.056-3.211,1.056h-3c-4.315,0-6.709,1.475-6.709,5.825v61.175h100   V28.405C298.14,25.914,297.802,24.563,296.89,23.65z M266.14,65.26c0,2.521-2.502,4.945-5.68,5.719   c-3.639,0.882-7.275-0.735-7.975-3.616c-0.703-2.882,1.527-5.932,5.169-6.816c1.658-0.403,3.485-0.287,4.485,0.231V46.81   c-10,0.681-17,3.4-17,3.4v18.781c0,2.728-2.316,5.487-5.748,6.323c-3.641,0.883-7.33-0.735-8.029-3.615   c-0.699-2.881,1.603-5.933,5.241-6.817c1.69-0.41,3.309-0.283,4.678,0.262l0.219-25.139c0,0,10.64-4.953,24.64-4.506   C266.14,40.598,266.14,65.232,266.14,65.26z" />
        </g>
        <path
            d="M296.483,120.459c-0.912-0.912-2.887-0.826-5.343-0.826h-36.264c-2.386,0-3.869-0.725-4.446-1.096  c-0.58-0.365-1.114-1.734-1.606-3.559l-0.578-2.399c-0.491-1.824-1.184-2.831-2.08-3.341c-0.894-0.508-2.692-0.605-5.394-0.605  h-20.211c-3.263,0-5.315,0.02-6.158,0.512c-0.842,0.49-1.562,1.729-2.157,3.938l-0.526,2.05c-0.352,1.368-0.843,2.803-1.474,3.277  c-0.632,0.473-1.702,1.223-3.211,1.223h-3c-4.315,0-5.896,1.093-5.896,5.443v61.557h100v-61.609  C298.14,122.532,297.396,121.373,296.483,120.459z M257.14,173.633h-25v-34h25V173.633z M263.14,167.633h-3v-31h-22v-3h25V167.633z" />
        <g>
            <path
                d="M376.762,289.827v-61c0-4.351,2.158-6.526,6.474-6.526h3c1.509,0,2.579-0.237,3.211-0.71   c0.631-0.475,1.122-1.396,1.474-2.764l0.526-2.105c0.596-2.21,1.315-3.562,2.157-4.053c0.843-0.491,2.896-0.736,6.158-0.736h20.211   c2.701,0,4.5,0.255,5.394,0.763c0.896,0.51,1.589,1.676,2.08,3.5l0.578,2.264c0.492,1.824,1.026,2.922,1.606,3.288   c0.577,0.37,2.061,0.554,4.446,0.554h36.264c2.456,0,4.141,0.456,5.053,1.368c0.912,0.913,1.368,2.614,1.368,5.105v61.053H376.762z   " />
        </g>
        <path
            d="M302,223.835c-0.912-0.912-2.368-1.202-4.824-1.202h-36.264c-2.386,0-3.869-0.35-4.446-0.72  c-0.58-0.366-1.114-1.547-1.606-3.371l-0.578-2.306c-0.491-1.824-1.184-3.16-2.08-3.67c-0.894-0.508-2.692-0.934-5.394-0.934  h-20.211c-3.263,0-5.315,0.395-6.158,0.887c-0.842,0.49-1.562,1.917-2.157,4.127l-0.526,2.144c-0.352,1.368-0.843,2.474-1.474,2.948  c-0.632,0.473-1.702,0.895-3.211,0.895h-3c-4.315,0-6.931,1.844-6.931,6.194v60.806h100v-60.858  C303.14,226.283,302.912,224.748,302,223.835z M260.14,271.595c0,1.437-0.735,3.038-2.173,3.038h-25.946  c-1.438,0-2.881-1.602-2.881-3.038v-27.04c0-1.437,1.443-2.922,2.881-2.922h14.389l-3.162,3.965l-10.107,0.072v24.963h24v-11.146  l3-0.744V271.595z M263.14,260.483v-5.758c0,0-8.326-0.585-14.381,3.165c-4.023,2.491-6.363,4.982-8.354,8.352  c0,0,0.423-8.944,5.569-17.092c6.434-10.187,17.165-11.86,17.165-11.86v-5.538l14.365,14.335L263.14,260.483z" />
    </svg>`;

    const center = {
        lat: '<?= $lat ?>',
        lng: '<?= $lng ?>'
    };

    $(function() {
        clusters.map(function(item){
            $('.map-clusters-menu ul').append(`<li>
                <a href="javascript:void(0)" data-content='${JSON.stringify(item)}' data-latitude="${item.latitude}" data-longitude="${item.longitude}" onclick="moveToMarker(this)">
                    <div class="img-container">
                        <img src="${item.thumbnail}">
                    </div>
                    <div class="body-container">
                        <h4 class="bc-title">${item.title}</h4>
                        <div class="bc-description">
                        <strong>Giá:</strong> ${item.price}<br>
                        <strong>Diện tích:</strong> ${item.dien_tich}<br>
                        <strong>Địa chỉ:</strong>  ${item.dia_chi}
                        </div>
                    </div>
                </a>
            </li>`);
        })
    });

    function startClustering(map, ui, getBubbleContent, data) {
        var dataPoints = data.map(function(item) {
            return new H.clustering.DataPoint(item.latitude, item.longitude, null, item);
        });

        $('.map-clusters-menu ul li').click(onMarkerClick);

        var clusteredDataProvider = new H.clustering.Provider(dataPoints, {
            clusteringOptions: {
                eps: 64,
                minWeight: 3
            },
            theme: CUSTOM_THEME
        });

        clusteredDataProvider.addEventListener('tap', onMarkerClick);
        clusteredDataProvider.addEventListener('pointermove', onMarkerHoverIn);
        // clusteredDataProvider.addEventListener('pointermove', onMarkerHoverOut);

        var layer = new H.map.layer.ObjectLayer(clusteredDataProvider);

        map.addLayer(layer);
    }

    var CUSTOM_THEME = {
        getClusterPresentation: function(cluster) {
            var randomDataPoint = getRandomDataPoint(cluster),
                data = randomDataPoint.getData();
            var clusterMarker = new H.map.Marker(cluster.getPosition(), {
                icon: new H.map.Icon(data.marker ? data.marker : svgIcon, {
                    size: {w: 25, h: 25},
                    anchor: {x: 15, y: 15}
                }),

                min: cluster.getMinZoom(),
                max: cluster.getMaxZoom()
            });

            clusterMarker.setData(data);

            return clusterMarker;
        },
        getNoisePresentation: function (noisePoint) {
            var data = noisePoint.getData(),
                noiseMarker = new H.map.Marker(noisePoint.getPosition(), {
                    min: noisePoint.getMinZoom(),
                    icon: new H.map.Icon(data.marker ? data.marker : svgIcon, {
                        size: {w: 25, h: 25},
                        anchor: {x: 15, y: 15}
                    })
                });

            noiseMarker.setData(data);

            return noiseMarker;
        }
    };

    function getRandomDataPoint(cluster) {
        var dataPoints = [];

        cluster.forEachDataPoint(dataPoints.push.bind(dataPoints));

        return dataPoints[Math.random() * dataPoints.length | 0];
    }

    function onMarkerClick(e) {
        var position = e?.target?.getGeometry(),
            data = e?.target?.getData(),
            bubbleContent = getBubbleContent(data),
            bubble = onMarkerClick.bubble;

        if (!bubble) {
            bubble = new H.ui.InfoBubble(position, {
                content: bubbleContent
            });
            ui.addBubble(bubble);
            onMarkerClick.bubble = bubble;
        } else {
            bubble.setPosition(position);
            bubble.setContent(bubbleContent);
            bubble.open();
        }
        map.setCenter(position, true);
    }

    function onMarkerHoverIn(e) {
        var position = e?.target?.getGeometry(),
            data = e?.target?.getData(),
            bubbleContent = getBubbleContent(data),
            bubble = onMarkerHoverIn.bubble;

        if (!bubble) {
            bubble = new H.ui.InfoBubble(position, {
                content: bubbleContent
            });
            ui.addBubble(bubble);
            onMarkerHoverIn.bubble = bubble;
        } else {
            bubble.setPosition(position);
            bubble.setContent(bubbleContent);
            bubble.open();
        }
    }

    var platform = new H.service.Platform({
        apikey: apikey
    });
    var defaultLayers = platform.createDefaultLayers();

    var map = new H.Map(document.getElementById('map'),
        defaultLayers.vector.normal.map, {
            center: center,
            zoom: 10,
            pixelRatio: window.devicePixelRatio || 1
        });
    window.addEventListener('resize', () => map.getViewPort().resize());

    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

    var ui = H.ui.UI.createDefault(map, defaultLayers);

    function getBubbleContent(data) {
        return `<div class="bubble">
            <a class="bubble-image" style="background-image: url(${data?.fullurl})" href="${data?.url}" target="_blank"></a>
            <div style="color: #0b0b0b; padding: 0 10px 10px">
                <hr/>
                <a class="bubble-footer" href="${data?.url}" target="_blank">
                    <img class="bubble-logo" src="${data?.thumbnail}" width="50" height="50" />
                    <div class="bubble-desc" style="color: #0b0b0b; padding-left: 10px">
                        <strong>${data?.title ?? ''}</strong>
                        <br/><strong>Giá:</strong> ${data?.price}
                        <br/><strong>Diện tích:</strong> ${data?.dien_tich}
                        <br/><strong>Địa chỉ:</strong> ${data?.dia_chi}
                        <p style="margin-bottom: 0; margin-top: 10px"><span style="display: inline-block; padding: 5px; background-color: #175699; color: #fff;">Xem chi tiết</span></p>
                    </div>
                </a>
            </div>
        </div>`;
    }

    startClustering(map, ui, getBubbleContent, clusters);

    function moveToMarker(el) {
        $('.map-clusters-menu ul li').removeClass('active')
        ui.getBubbles().forEach(function(item) {
            ui.removeBubble(item);
        })
        var lat = $(el).data('latitude'),
            lng = $(el).data('longitude'),
            content = $(el).data('content'),
            bubbleContent = getBubbleContent(content);
        map.setCenter({lat: lat, lng: lng});
        map.setZoom(16);
        bubble = new H.ui.InfoBubble(new H.geo.Point(lat, lng), {
            content: bubbleContent
        });
        ui.addBubble(bubble);
        bubble.open();
        $(el).parent('li').addClass('active')
    }
</script>
<?php }