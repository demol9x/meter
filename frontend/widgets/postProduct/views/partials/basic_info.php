<div class="ps-basic_info">
    <div class="partial-head">Thông tin cơ bản</div>
    <div class="partial-content">
        <div class="row mb-3">
            <label for="product-name" class="col-sm-2 col-form-label col-form-label-sm">Tiêu đề (<span class="required">*</span>)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="product-name"
                       placeholder="Tiêu đề tin đăng của bạn" name="Product[name]" required>
                <small class="field-error text-danger d-none">Error</small>
            </div>
        </div>
        <div class="row mb-3">
            <?php if (isset($data) && $data) { ?>
                <div class="col-sm-6">
                    <div class="row">
                        <label for="product-hinh_thuc" class="col-sm-3 col-form-label col-form-label-sm">Hình thức
                            (<span class="required">*</span>)</label>
                        <div class="col-sm-9">
                            <select type="text" class="form-control form-control-sm" id="product-hinh_thuc"
                                    name="Product[hinh_thuc]" required>
                                <option value="">Chọn hình thức</option>
                                <?php foreach ($data as $key => $hinhthuc) { ?>
                                    <option value="<?php echo $hinhthuc['id'] ?>"><?php echo $hinhthuc['name'] ?></option>
                                <?php } ?>
                            </select>
                            <small class="field-error text-danger d-none">Error</small>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-sm-6">
                <div class="row">
                    <label for="product-category_id" class="col-sm-3 col-form-label col-form-label-sm">Loại tin (<span
                                class="required">*</span>)</label>
                    <div class="col-sm-9">
                        <select type="text" class="form-control form-control-sm" id="product-category_id"
                                name="Product[category_id]" required>
                            <option value="">Chọn loại tin</option>
                        </select>
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <?php if(isset($provinces) && $provinces) { ?>
                <div class="col-sm-6">
                    <div class="row">
                        <label for="product-province_id" class="col-sm-3 col-form-label col-form-label-sm">Tỉnh/Thành phố
                            (<span class="required">*</span>)</label>
                        <div class="col-sm-9">
                            <select type="text" class="form-control form-control-sm" id="product-province_id"
                                    name="Product[province_id]" required>
                                <option value="">Chọn tỉnh/thành phố</option>
                                <?php foreach($provinces as $key => $province) { ?>
                                    <option data-coordinate="<?php echo $province['latlng'] ?>" value="<?php echo $province['id'] ?>"><?php echo $province['name'] ?></option>
                                <?php } ?>
                            </select>
                            <small class="field-error text-danger d-none">Error</small>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-sm-6">
                <div class="row">
                    <label for="product-district_id" class="col-sm-3 col-form-label col-form-label-sm">Quận/Huyện (<span
                                class="required">*</span>)</label>
                    <div class="col-sm-9">
                        <div id="product-district_id-container">
                            <select type="text" class="form-control form-control-sm" id="product-district_id"
                                    name="Product[district_id]" required>
                                <option value="">Chọn quận/huyện</option>
                            </select>
                        </div>
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="row">
                    <label for="product-ward_id" class="col-sm-3 col-form-label col-form-label-sm">Phường/Xã</label>
                    <div class="col-sm-9">
                        <div id="product-ward_id-container">
                            <select type="text" class="form-control form-control-sm" id="product-ward_id"
                                    name="Product[ward_id]">
                                <option value="">Chọn phường/xã</option>
                            </select>
                        </div>
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <label for="product-address" class="col-sm-3 col-form-label col-form-label-sm">Địa chỉ (<span
                                class="required">*</span>)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="product-address"
                               placeholder="Địa chỉ" name="Product[address]">
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="row">
                    <label for="product-project_id" class="col-sm-3 col-form-label col-form-label-sm">Dự án</label>
                    <div class="col-sm-9">
                        <select type="text" class="form-control form-control-sm" id="product-project_id"
                                name="Product[project_id]" required>
                            <option value="">Chọn dự án</option>
                        </select>
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <label for="product-dien_tich" class="col-sm-3 col-form-label col-form-label-sm">Diện tích</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="product-dien_tich"
                                   placeholder="Diện tích" name="Product[dien_tich]">
                            <span class="input-group-text" id="product-dien_tich">m²</span>
                        </div>
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <label for="product-price" class="col-sm-3 col-form-label col-form-label-sm">Giá</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="product-price"
                               placeholder="Diện tích" name="Product[price]">
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <label for="product-price_type" class="col-sm-3 col-form-label col-form-label-sm">Đơn vị</label>
                    <div class="col-sm-9">
                        <input type="hidden" id="product-bo_donvi_tiente" name="Product[bo_donvi_tiente]">
                        <select type="text" class="form-control form-control-sm" id="product-price_type"
                                name="Product[price_type]" required>
                            <option value="">Chọn đơn vị</option>
                        </select>
                        <small class="field-error text-danger d-none">Error</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function () {
            //onChange Hình thức
            jQuery('#product-hinh_thuc').on('change', function () {
                jQuery('.ps-other_info .partial-content .row-form').empty();
                var category_type_id = $(this).val();
                jQuery.ajax({
                    url: '<?= \yii\helpers\Url::to(['get-category-by-type']) ?>',
                    type: 'GET',
                    data: {
                        category_type_id: category_type_id,
                    },
                    success: function (result) {
                        var response = JSON.parse(result);
                        jQuery('#product-bo_donvi_tiente').val(response['bo_donvi_tiente']);
                        changeCategory(response);
                        changeMoney(response);
                    }
                });
            });

            // onChange Danh mục
            jQuery('#product-category_id').on('change', function () {
                var category_id = $(this).val();
                jQuery.ajax({
                    url: '<?= \yii\helpers\Url::to(['get-product-attribute']) ?>',
                    type: 'GET',
                    data: {
                        category_id: category_id,
                    },
                    success: function (result) {
                        console.log(result)
                        jQuery('.ps-other_info').empty();
                        jQuery('.ps-other_info').append(result);
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            });
        });

        function changeCategory(data) {
            var html_district = '<option value="">Chọn loại tin</option>';
            for (const [key, value] of Object.entries(data['category'])) {
                html_district += '<option value="' + key + '">' + value + '</option>';
            }
            jQuery('#product-category_id').empty();
            jQuery('#product-category_id').append(html_district);
        };

        function changeMoney(data) {
            var html_district = '';
            for (const [key, value] of Object.entries(data['money'])) {
                html_district += '<option value="' + key + '">' + value + '</option>';
            }
            jQuery('#product-price_type').empty();
            jQuery('#product-price_type').append(html_district);
        };

        jQuery('#product-district_id').chosen();
        jQuery('#product-ward_id').chosen();
        jQuery('#product-province_id').chosen().change(function () {
            var id = $(this).val();
            jQuery.ajax({
                url: '<?= \yii\helpers\Url::to(['/admin/product/product/get-district']) ?>',
                type: 'GET',
                data: {
                    province_id: id,
                },
                success: function (result) {
                    var response = JSON.parse(result);
                    changeDistrict(response);
                    changeProject(response);
                }
            });
            var latlng = jQuery(this).find(':selected').data('coordinate');
            window.moveMapTo(window.map, latlng.split(',')[0], latlng.split(',')[1])
        });

        function changeDistrict(data) {
            var html_district = '<select type="text" class="form-control form-control-sm" id="product-district_id" name="Product[district_id]" required><option data-coordinate="" value="">Chọn quận/huyện</option>';
            for (const [key, value] of Object.entries(data['district'])) {
                html_district += '<option data-coordinate="'+ value['latlng'] +'" value="' + value['id'] + '">' + value['name'] + '</option>';
            }
            html_district+= '</select>';
            jQuery('#product-ward_id').empty();
            jQuery('#product-ward_id').append('<option data-coordinate="" value="">Chọn Phường/Xã</option>');
            jQuery('#product-ward_id').chosen();
            jQuery('#product-district_id-container').empty();
            jQuery('#product-district_id-container').append(html_district);
            jQuery('#product-district_id-container #product-district_id').chosen().change(function () {
                var district_id = $(this).val();
                jQuery.ajax({
                    url: '<?= \yii\helpers\Url::to(['/admin/product/product/get-ward']) ?>',
                    type: 'GET',
                    data: {
                        district_id: district_id,
                    },
                    success: function (result) {
                        var response = JSON.parse(result);
                        changeWard(response);
                        changeProject(response);
                    }
                });
                var latlng = jQuery(this).find(':selected').data('coordinate');
                window.moveMapTo(window.map, latlng.split(',')[0], latlng.split(',')[1])
            });
        };

        function changeWard(data) {
            var html_district = '<select type="text" class="form-control form-control-sm" id="product-ward_id" name="Product[ward_id]" required><option data-coordinate="" value="">Chọn phường/xã</option>';
            for (const [key, value] of Object.entries(data['ward'])) {
                html_district += '<option data-coordinate="'+ value['latlng'] +'" value="' + value['id'] + '">' + value['name'] + '</option>';
            }
            html_district+= '</select>';
            jQuery('#product-ward_id-container').empty();
            jQuery('#product-ward_id-container').append(html_district);
            jQuery('#product-ward_id').chosen().change(function () {
                var latlng = jQuery(this).find(':selected').data('coordinate');
                window.moveMapTo(window.map, latlng.split(',')[0], latlng.split(',')[1])
            });
        };

        function changeProject(data) {
            var html_district = '<option value="">Chọn dự án</option>';
            for (const [key, value] of Object.entries(data['project'])) {
                html_district += '<option value="' + key + '">' + value + '</option>';
            }
            jQuery('#product-project_id').empty();
            jQuery('#product-project_id').append(html_district);
        };
    </script>
</div>
