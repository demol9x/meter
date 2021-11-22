<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 6/29/2021
 * Time: 11:10 AM
 */
?>
<?php if ($model->mat_tien == 1): ?>
    <div class="form-group field-product-mat_tien">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-mat_tien">Mặt tiền (m)</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input type="text" id="product-mat_tien" class="form-control" name="Product[mat_tien]" placeholder="">
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->duong_vao == 1): ?>
    <div class="form-group field-product-duong_vao">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-duong_vao">Đường vào (m)</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input type="text" id="product-duong_vao" class="form-control" name="Product[duong_vao]" placeholder="">
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

<?php $huong_nha = \common\components\ClaBds::huong_nha(); ?>

<?php if ($model->huong_nha == 1): ?>
    <div class="form-group field-product-huong_nha">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-huong_nha">Hướng nhà</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <select id="product-huong_nha" class="form-control" name="Product[huong_nha]" aria-required="true" aria-invalid="false">
                <?php foreach ($huong_nha as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->huong_ban_cong == 1): ?>
    <div class="form-group field-product-huong_ban_cong">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-huong_ban_cong">Hướng ban công</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <select id="product-huong_ban_cong" class="form-control" name="Product[huong_ban_cong]" aria-required="true" aria-invalid="false">
                <?php foreach ($huong_nha as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->so_tang == 1): ?>
    <div class="form-group field-product-so_tang">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-so_tang">Số tầng</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input type="text" id="product-so_tang" class="form-control" name="Product[so_tang]" placeholder="">
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->so_phong_ngu == 1): ?>
    <div class="form-group field-product-so_phong_ngu">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-so_phong_ngu">Số phòng ngủ</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input type="text" id="product-so_phong_ngu" class="form-control" name="Product[so_phong_ngu]" placeholder="">
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->so_toilet == 1): ?>
    <div class="form-group field-product-so_toilet">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-so_toilet">Số toilet</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input type="text" id="product-so_toilet" class="form-control" name="Product[so_toilet]" placeholder="">
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->noi_that == 1): ?>
    <div class="form-group field-product-noi_that">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-noi_that">Nội thất</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <textarea id="product-noi_that" class="form-control" name="Product[noi_that]" rows="4" aria-required="true" aria-invalid="true"></textarea>
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->thong_tin_phap_ly == 1): ?>
    <div class="form-group field-product-thong_tin_phap_ly">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-thong_tin_phap_ly">Thông tin pháp lý</label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <textarea id="product-thong_tin_phap_ly" class="form-control" name="Product[thong_tin_phap_ly]" rows="4" aria-required="true" aria-invalid="true"></textarea>
            <div class="help-block"></div>
        </div>
    </div>
<?php endif; ?>

