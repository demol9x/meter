<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 7/28/2021
 * Time: 3:27 PM
 */
?>
<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl ?>css/chosen.css"/>
<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl ?>css/homefilter.css"/>
<script src="<?php echo Yii::$app->homeUrl ?>js/chosen/chosen.jquery.js"></script>
<style>
    .chosen-container{
        width: 100% !important;
        font-family: 'Roboto';
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 19px;
        color: #828282;
        max-height: 51px;
    }
    .map-form .body .btnSearch {
        background-image: url(https://file4.batdongsan.com.vn/images/Product/Maps/btn-search.png);
        background-position: 7px 8px;
        background-repeat: no-repeat;
        background-color: #3c9e10;
        font-size: 14px;
        color: #fff;
        font-family: Arial;
        font-weight: bold;
        line-height: 17px;
        padding: 7px 12px 7px 30px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: -3px;
    }

    .tabcontent-view {
        margin-top: 130px;
        clear: both;
        width: 100%;
    }

    .tabcontent-view .active {
        display: block;
    }

    .map-form {
        margin: auto;
        margin-top: 20px;
    }

    .map-form .tab {
        height: 30px;
        width: 100%;
    }

    .map-form .tab div.active {
        background-color: #055699;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        font-family: Arial;
        font-size: 14px;
        color: #fff;
    }

    .map-form .tab div {
        padding: 5px 15px;
        line-height: 20px;
        font-size: 12px;
        font-family: Arial;
        float: left;
        cursor: pointer;
        background-color: #cfe5f2;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        margin-right: 4px;
    }

    .tabcontent-view .active {
        display: block;
    }

    .map-form .tab span {
        float: right;
        background-image: url(https://file4.batdongsan.com.vn/images/Product/Maps/search-advance.png);
        background-position: left;
        background-repeat: no-repeat;
        padding: 5px 0 5px 20px;
        line-height: 20px;
        font-family: Arial;
        font-size: 12px;
        color: #055699;
        font-weight: bold;
        cursor: pointer;
    }

    .map-form .body {
        padding: 10px 7px 3px 7px;
        background-color: #055699;
        border-top-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .map-form .body .form-row {
        clear: both;
        width: 100%;
        margin-bottom: 3px;
    }

    .map-form .body .form-row .btnSearch, .map-form .body .form-row .dropbox {
        float: left;
        cursor: pointer;
    }
    .map-form .body .dropbox {
        line-height: 14px;
        font-size: 12px;
        font-family: Arial;
        width: 120px;
        margin-right: 5px;
    }
    #btnProductSearch{
        float: right;
    }
    .map-form .body input[type=text] {
        border: 1px solid #C7C7C7;
        float: left;
        font-family: Arial;
        font-size: 12px;
        margin-right: 5px;
        padding: 5px 0 5px 4px;
        width: 205px;
    }
</style>


<div class="tabcontent-view">
    <div class="map-form product-form active container">
        <div class="tab">
            <div class="active" cateid="38">Bất động sản bán</div>
            <div cateid="49" class="">Bất động sản cho thuê</div>
            <span id="lnkSearchAdvance">Tìm kiếm nâng cao</span>
        </div>
        <div class="body">
            <div class="form-row">
                <input type="text" id="txtKeyword" name="s" value="" placeholder="Nhập địa điểm bất động sản"
                       autocomplete="false">
                <div class="dropbox hidden-dropbox hidden-dropbox-current">
                    <div class="form-group">
                        <div class="district_select_container">
                            <select data-placeholder="Chọn tỉnh/ thành phố" class="province-select" name="province_id" tabindex="5">
                                <option value=""></option>
                                <?php foreach ($provinces as $key => $province): ?>
                                    <option value="<?= $key ?>"><?= $province ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="btnSearch" id="btnProductSearch">Tìm kiếm</div>
            </div>
            <div class="form-row advance-row">

            </div>
        </div>
    </div>
    <div class="map-form project-form " style="display: none">
        <!--add active class if project is default-->
        <div class="body">
            <div class="form-row">
                <div class="dropbox" id="cbbProjectType" placeholder="Chọn lĩnh vực">
                </div>
                <div class="dropbox" id="cbbProjectCity" placeholder="Chọn Tỉnh/Thành phố">
                </div>
                <div class="dropbox" id="cbbProjectDistrict" placeholder="Chọn Quận/Huyện">
                </div>
                <div class="btnSearch" id="btnProjectSearch">Tìm kiếm</div>
            </div>
        </div>
        <div class="map-title">
            <h1 id="projectMapTitle">
                Dư án bất động sản tại Việt Nam</h1>
            <div class="maptype-view">
                <div class="active type-map" rel="product">Xem trên bản đồ</div>
                <div class="type-list">
                    <a id="lnkProjectList" title="Xem theo danh sách">Xem theo danh sách</a>
                </div>
                <!--add active class if project is default-->
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        $('.province-select').chosen().change(function () {
            var district_id = $(this).val();
            //$.ajax({
            //    url: '<?//= Url::to(['ajax/get-ward']) ?>//',
            //    type: 'GET',
            //    data: {
            //        district_id: district_id,
            //    },
            //    success: function (result) {
            //        var response = JSON.parse(result);
            //        changeWard(response);
            //        changeProject(response);
            //    }
            //});
            // $('.district-select').val(district_id).trigger('chosen:updated');
        });
    });
</script>

