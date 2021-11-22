<?php
use yii\helpers\Url;
$get = $_GET;
$category_id = isset($get['category_id']) && $get['category_id'] ? $get['category_id'] : '';
$province_id = isset($get['province_id']) && $get['province_id'] ? $get['province_id'] : '';
if($province_id){
    $districts = \common\models\District::find()->where(['province_id' => $province_id])->asArray()->all();
    $districts = array_column($districts,'name','id');
}

$district_id = isset($get['district_id']) && $get['district_id'] ? $get['district_id'] : '';
$price_min = isset($get['price_min']) && $get['price_min'] ? $get['price_min'] : '';
$price_max = isset($get['price_max']) && $get['price_max'] ? $get['price_max'] : '';
$dien_tich_max = isset($get['dien_tich_max']) && $get['dien_tich_max'] ? $get['dien_tich_max'] : '';
$dien_tich_min = isset($get['dien_tich_min']) && $get['dien_tich_min'] ? $get['dien_tich_min'] : '';
$s = isset($get['s']) && $get['s'] ? $get['s'] : '';
$project = isset($get['project']) && $get['project'] ? $get['project'] : '';
if($district_id){
    $wards = \common\models\Ward::find()->where(['district_id' => $district_id])->asArray()->all();
    $wards = array_column($wards,'name','id');
}
$ward_id = isset($get['ward_id']) && $get['ward_id'] ? $get['ward_id'] : '';
$so_phong = isset($get['so_phong']) && $get['so_phong'] ? $get['so_phong'] : '';
$huong_nha = isset($get['huong_nha']) && $get['huong_nha'] ? $get['huong_nha'] : '';
?>
<div id="tab<?php echo $key ?>" class="filter-tab <?php echo $key == 0 ? 'show' : '' ?>">
    <form action="<?php echo Url::to(['/search/search-bds']) ?>" class="filter-tabs-form filter-tabs-form-<?php echo $bds['id'] ?>">
        <div class="form-group search-field">
            <input class="category_type_id" type="hidden" name="hinh_thuc">
            <input type="text" name="s" placeholder="Từ khóa" value="<?= $s ?>"><button
                type="submit"><?php echo Yii::t('app', 'search') ?></button>
        </div>
        <div class="form-group">
            <div class="product_select_extra">
                <select data-placeholder="Loại đất" tabindex="5" name="category_id">
                    <option value="">Loại đất</option>
                    <?php foreach($bds['categories'] as $bds_categories) { ?>
                    <option value="<?php echo $bds_categories['id'] ?>"  <?= $category_id == $bds_categories['id'] ? 'selected' : '' ?>>
                        <?php echo $bds_categories['name'] ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="district_select_container">
                <select data-placeholder="Chọn tỉnh/ thành phố" class="province-select" name="province_id" tabindex="5">
                    <option value=""></option>
                    <?php foreach ($provinces as $key => $province): ?>
                    <option value="<?= $key ?>" <?= $province_id == $key ? 'selected' : '' ?>><?= $province ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="district_select">
                <select data-placeholder="Chọn quận/ huyện" class="chosen-select district-select" tabindex="5" name="district_id">
                    <option value="">Chọn quận/ huyện</option>
                    <?php if (isset($districts) && $districts): ?>
                        <?php foreach ($districts as $k => $district): ?>
                            <option value="<?= $k ?>" <?= $k == $district_id ? 'selected' : '' ?>><?= $district ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="product_select_extra">
                <input class="price_max" type="hidden" name="price_max">
                <select class="none" data-placeholder="Mức giá" tabindex="5" name="price_min">
                    <option value="">Mức giá</option>
                    <?php foreach($bds['price_fillter'] as $price_fillter) { ?>
                        <option value="<?php echo $price_fillter['min'] ?>" data-max="<?php echo $price_fillter['max'] ?>" <?= $price_min == $price_fillter['min'] && $price_max == $price_fillter['max'] ? 'selected' : '' ?>>
                            <?php echo $price_fillter['max'] ? $price_fillter['min'] .' - '. $price_fillter['max'] .' triệu' : '> '. $price_fillter['min'].' triệu'?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="product_select_extra">
                <input class="dien_tich_max" type="hidden" name="dien_tich_max">
                <select class="none dien_tich" data-placeholder="Diện tích" tabindex="5" name="dien_tich_min">
                    <option value="">Diện tích</option>
                    <?php foreach($dien_tich as $k => $dt) : ?>
                    <option value="<?php echo $dt['min'] ?>" data-max="<?php echo $dt['max'] ?>" <?= $dien_tich_min == $dt['min'] && $dien_tich_max == $dt['max'] ? 'selected' : '' ?>>
                        <?php echo $dt['max'] ? $dt['min'] .' - '. $dt['max'] .' m2' : '> '. $dt['min'] .' m2'?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group r2" style="display: none;">
            <div class="project_select">
                <select data-placeholder="Chọn dự án" class="project-chosen-select" tabindex="5" name="project">
                    <option value="">Chọn dự án</option>
                </select>
            </div>
        </div>
        <div class="form-group r2" style="display: none;">
            <div class="ward_select">
                <select data-placeholder="Chọn phường/ xã" class="ward-chosen-select" tabindex="5" name="ward_id">
                    <option value="">Chọn phường/ xã</option>
                    <?php if (isset($wards) && $wards): ?>
                        <?php foreach ($wards as $k => $ward): ?>
                            <option value="<?= $k ?>" <?= $k == $ward_id ? 'selected' : '' ?>><?= $ward ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group r2" style="display: none;">
            <div class="product_select_extra">
                <select data-placeholder="Số phòng" tabindex="5" name="so_phong">
                    <option value="">Số phòng</option>
                    <option value="0" <?= $so_phong == 0 ? 'selected' : '' ?>>Không xác định</option>
                    <option value="1" <?= $so_phong == 1 ? 'selected' : '' ?>>1+</option>
                    <option value="2" <?= $so_phong == 2 ? 'selected' : '' ?>>2+</option>
                    <option value="3" <?= $so_phong == 3 ? 'selected' : '' ?>>3+</option>
                    <option value="4" <?= $so_phong == 4 ? 'selected' : '' ?>>4+</option>
                    <option value="5" <?= $so_phong == 5 ? 'selected' : '' ?>>5+</option>
                </select>
            </div>
        </div>
        <div class="form-group r2" style="display: none;">
            <div class="product_select_extra">
                <select data-placeholder="Hướng nhà đất" tabindex="5" name="huong_nha">
                    <option value="">Hướng nhà đất</option>
                    <?php if(isset($huong_nha) && $huong_nha) foreach($huong_nha as $key => $hn) { ?>
                    <option value="<?php echo $key ?>" <?= $huong_nha == $key ? 'selected' : '' ?>><?php echo $hn ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </form>
</div>