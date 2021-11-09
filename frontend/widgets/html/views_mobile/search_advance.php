<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;
?>
<div class="box-advanced-search">
    <div class="close-btn"></div>
    <div class="flex">
        <div class="item-advanced-search">
            <label for="">Loại cửa hàng</label>
            <select name="" id="">
                <option value="">Thể loại</option>
                <option value="1">-- Beef</option>
                <option value="">-- Cheese</option>
                <option value="">-- Chocolate</option>
                <option value="">-- Cocoa Beans</option>
                <option value="">-- Coffee</option>
                <option value="">-- Dried Fruits</option>
                <option value="">-- Fish And Seafood</option>
                <option value="">-- Flour</option>

                <option value="1">Thực phẩm tươi</option>
                <option value="1">Chế biến sẵn</option>
                <option value="1">Thiết bị phương tiện</option>
            </select>
        </div>
        <div class="item-advanced-search">
            <label for="">Loại cửa hàng</label>
            <select name="" id="">
                <option value="1">Thể loại</option>
                <option value="1">Thực phẩm tươi</option>
                <option value="1">Chế biến sẵn</option>
                <option value="1">Thiết bị phương tiện</option>
            </select>
        </div>
        <div class="item-advanced-search position-location">
            <label for="">Địa điểm</label>
            <select name="" id="" class="location">
                <option value="1">Địa điểm</option>
                <option value="1">Hà nội</option>
                <option value="1">Hồ chí minh</option>
                <option value="1">Đà nẵng</option>
            </select>
        </div>
        <div class="item-advanced-search price-from">
            <label for="">Giá bán</label>
            <select name="" id="">
                <option value="1">Từ</option>
                <option value="1">1.000.000</option>
                <option value="1">1.000.000</option>
                <option value="1">1.000.000</option>
            </select>
        </div>
        <div class="item-advanced-search price-to">
            <label for="">Giá bán</label>
            <select name="" id="" >
                <option value="1">Đến</option>
                <option value="1">1.000.000</option>
                <option value="1">1.000.000</option>
                <option value="1">1.000.000</option>
            </select>
        </div>
        <button type="submit" class="submit-search btn-style-2">Tìm kiếm</button>
    </div>
    <div class="list-check awe-check">
        <div class="checkbox">
            <input type="checkbox" class="ais-checkbox" value="checkbox">
            <label><span class="text-clip" title="checkbox">Hàng bán buôn</span></label>
        </div>
        <div class="checkbox">
            <input type="checkbox" class="ais-checkbox" value="checkbox">
            <label><span class="text-clip" title="checkbox">Hàng bán lẻ</span></label>
        </div>
        <div class="checkbox">
            <input type="checkbox" class="ais-checkbox" value="checkbox">
            <label><span class="text-clip" title="checkbox">Người bán được đánh giá cao</span></label>
        </div>
    </div>
</div>