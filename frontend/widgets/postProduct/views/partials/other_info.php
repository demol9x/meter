<div class="ps-other_info">
    <?php if(isset($category_id)) {
        $category = \common\models\product\ProductCategory::findOne($category_id);
        $huong_nha = \common\components\ClaBds::huong_nha(); ?>
    <div class="partial-head">Thông tin khác</div>
    <div class="partial-content">
        <div class="row">
            <small class="d-block mb-3" style="margin-left: 15px">Điền đầy đủ thông tin để có hiệu quả đăng tin tốt hơn</small>
        </div>
        <div class="row row-form">
            <?php if (is_object($category) && $category->mat_tien == 1): ?>
            <div class="col-sm-6 mb-3">
                <div class="row">
                    <label for="product-mat_tien" class="col-sm-3 col-form-label col-form-label-sm">Mặt tiền (m)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="product-mat_tien"
                               placeholder="Mặt tiền" name="Product[mat_tien]">
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (is_object($category) && $category->duong_vao == 1): ?>
            <div class="col-sm-6 mb-3">
                <div class="row">
                    <label for="product-duong_vao" class="col-sm-3 col-form-label col-form-label-sm">Đường vào</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="product-duong_vao"
                               placeholder="Đường vào" name="Product[duong_vao]">
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (is_object($category) && $category->huong_nha == 1): ?>
            <div class="col-sm-6 mb-3">
                <div class="row">
                    <label for="product-huong_nha" class="col-sm-3 col-form-label col-form-label-sm">Hướng nhà</label>
                    <div class="col-sm-9">
                        <select type="text" class="form-control form-control-sm" id="product-huong_nha"
                                name="Product[huong_nha]" required>
                            <?php foreach ($huong_nha as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (is_object($category) && $category->huong_ban_cong == 1): ?>
            <div class="col-sm-6 mb-3">
                <div class="row">
                    <label for="product-huong_ban_cong" class="col-sm-3 col-form-label col-form-label-sm">Hướng ban
                        công</label>
                    <div class="col-sm-9">
                        <select type="text" class="form-control form-control-sm" id="product-huong_ban_cong"
                                name="Product[huong_ban_cong]" required>
                            <?php foreach ($huong_nha as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (is_object($category) && $category->so_tang == 1): ?>
            <div class="col-sm-6 mb-3">
                <div class="row">
                    <label for="product-so_tang" class="col-sm-3 col-form-label col-form-label-sm">Số tầng</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control form-control-sm" id="product-so_tang"
                               placeholder="Số tầng" name="Product[so_tang]">
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (is_object($category) && $category->so_phong_ngu == 1): ?>
            <div class="col-sm-6 mb-3">
                <div class="row">
                    <label for="product-so_phong_ngu" class="col-sm-3 col-form-label col-form-label-sm">Số phòng
                        ngủ</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control form-control-sm" id="product-so_phong_ngu"
                               placeholder="Số phòng ngủ" name="Product[so_phong_ngu]">
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (is_object($category) && $category->so_toilet == 1): ?>
            <div class="col-sm-6 mb-3">
                <div class="row">
                    <label for="product-so_toilet" class="col-sm-3 col-form-label col-form-label-sm">Số toilet</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control form-control-sm" id="product-so_toilet"
                               placeholder="Số toilet" name="Product[so_toilet]">
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (is_object($category) && $category->noi_that == 1): ?>
            <div class="col-sm-12">
                <div class="container-f">
                    <div class="form-group">
                        <label for="product-noi_that" class="form-label">Nội thất</label>
                        <textarea class="form-control" id="product-noi_that" name="Product[noi_that]"
                                  placeholder="Mô tả nội thất"></textarea>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (is_object($category) && $category->thong_tin_phap_ly == 1): ?>
            <div class="col-sm-12">
                <div class="container-f">
                    <div class="form-group">
                        <label for="product-thong_tin_phap_ly" class="form-label">Thông tin pháp lý</label>
                        <textarea class="form-control" id="product-thong_tin_phap_ly" name="Product[thong_tin_phap_ly]"
                                  placeholder="Ví dụ: Đã có sổ đỏ. Đã có sổ hồng. Đã được phê duyệt quyết định đầu tư..."></textarea>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php } ?>
</div>
