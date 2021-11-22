<?php
use yii\helpers\Url;
$get = $_GET;
$hinh_thuc = isset($get['hinh_thuc']) && $get['hinh_thuc'] ? $get['hinh_thuc'] : '';

?>
<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl ?>css/chosen.css"/>
<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl ?>css/homefilter.css"/>
<script src="<?php echo Yii::$app->homeUrl ?>js/chosen/chosen.jquery.js"></script>

<?php if(isset($data) && $data) { ?>
    <section class="section-product-filter">
        <div class="container">
            <div class="section-filter"
                style="background-image: url('<?php echo Yii::$app->homeUrl ?>images/img_banner-thin_mountains.jpg');padding: unset">
                <div class="section-filter-head" style="background: rgba(0,0,0,0.4);padding: 3rem 0 0 3rem;">
                    <ul class="filter-tabs-list">
                        <?php if($hinh_thuc): ?>
                            <?php foreach($data as $key => $bds) { ?>
                                <li data-ht="<?php echo $bds['id'] ?>" class="filter-tabs-item <?php echo $hinh_thuc == $bds['id'] ? 'active' : '' ?>" data-tab="#tab<?php echo $key ?>"><?php echo $bds['name'] ?></li>
                            <?php } ?>
                        <?php else: ?>
                            <?php foreach ($data as $key => $bds) { ?>
                                <li data-ht="<?php echo $bds['id'] ?>"
                                    class="filter-tabs-item <?php echo $key == 0 ? 'active' : '' ?>"
                                    data-tab="#tab<?php echo $key ?>"><?php echo $bds['name'] ?></li>
                            <?php } ?>
                        <?php endif; ?>
                    </ul>
                    <div class="search-action">
                        <a href="javascript:void(0)" class="m-r-10 filter-more">
                            <img src="https://file4.batdongsan.com.vn/images/newhome/icon-down-arrow.png">
                            Thêm
                        </a>
                        <a href="javascript:void(0)" class="filter-reset">
                            <img src="https://file4.batdongsan.com.vn/images/newhome/search-reset.png">
                            Xóa
                        </a>
                    </div>
                </div>
                <div class="filter-tabs-body" style="background: rgba(0,0,0,0.4);padding: 0 3rem 0 3rem;">
                    <?php foreach($data as $key => $bds) {
                        echo $this->render('form', array(
                            'key' => $key,
                            'bds' => $bds,
                            'provinces' => $provinces,
                            'huong_nha' => $huong_nha,
                            'dien_tich' => $dien_tich,
                        ));
                     } ?>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('.category_type_id').val($('.filter-tabs-item.active').data('ht'))
            $('.filter-tabs-item').click(function (e) {
                e.preventDefault();
                if ($(this).hasClass('active')) return;
                $('.filter-tabs-item').removeClass('active');
                $(this).addClass('active');
                $('.category_type_id').val($(this).data('ht'))
                let tab = $(this).data('tab');
                $('.filter-tab').removeClass('show');
                $(tab).addClass('show');
            });

            $('.province-select').chosen().change(function () {
                var id = $(this).val();
                var url = '<?= Url::to(['/ajax/get-district']) ?>';
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        province_id: id,
                    },
                    success: function (result) {
                        console.log(result)
                        var response = JSON.parse(result);
                        changeDistrict(response);
                        changeProject(response);
                    }
                });

                $('.province-select').val(id).trigger('chosen:updated');
            });

            $('.district-select').chosen().change(function () {
                var district_id = $(this).val();
                $.ajax({
                    url: '<?= Url::to(['/ajax/get-ward']) ?>',
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
                $('.district-select').val(district_id).trigger('chosen:updated');
            });

            $('.search-action .filter-more').click(function (e) {
                e.preventDefault();
                $(this).toggleClass('shown');
                if($(this).hasClass('shown')) {
                    $(this).html('<img src="https://file4.batdongsan.com.vn/images/newhome/up-arrow.png"> Rút gọn');
                    $('.form-group.r2').css('display', 'block');
                } else {
                    $(this).html('<img src="https://file4.batdongsan.com.vn/images/newhome/icon-down-arrow.png"> Thêm');
                    $('.form-group.r2').css('display', 'none');
                }
            });

            $('.search-action .filter-reset').click(function (e) {
                e.preventDefault();
                let selected = '.filter-tabs-form-'+$('.filter-tabs-item.active').data('ht');
                $(selected).trigger("reset");
                $('.category_type_id').val($('.filter-tabs-item.active').data('ht'))
            });

            $('.dien_tich').change(function (e) {
                e.preventDefault();
                $('.dien_tich').val($(this).val());
                $('.dien_tich_max').val($(this).find(':selected').data('max'))
            });

            $('.project_select select').change(function (e) {
                e.preventDefault();
                $('.project_select select').val($(this).val());
            });

            $('.product_select_extra select[name="so_phong"]').change(function (e) {
                e.preventDefault();
                $('.product_select_extra select[name="so_phong"]').val($(this).val());
            });

            $('.product_select_extra select[name="huong_nha"]').change(function (e) {
                e.preventDefault();
                $('.product_select_extra select[name="huong_nha"]').val($(this).val());
            });

            $('.product_select_extra select[name="price_min"]').change(function (e) {
                e.preventDefault();
                var input_max = $(this).parent('.product_select_extra').children('input[name="price_max"]');
                $(input_max).val($(this).find(':selected').data('max'));
            });
        });

        function changeDistrict(data) {
            var html_district = '<select data-placeholder="Chọn quận/ huyện" class="district-select" name="district_id" tabindex="5"><option value=""></option>';
            for (const [key, value] of Object.entries(data['district'])) {
                html_district += '<option value="' + key + '">' + value + '</option>';
            }
            html_district += '</select>';
            $('.ward_select').empty();
            $('.ward_select').append('<select data-placeholder="Chọn phường/ xã" class="ward-select" name="ward_id" tabindex="5"><option value=""></option></select>');
            $('.ward-select').chosen();
            $('.district_select').empty();
            $('.district_select').append(html_district);
            $('.district-select').chosen().change(function () {
                var district_id = $(this).val();
                $.ajax({
                    url: '<?= Url::to(['/ajax/get-ward']) ?>',
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
                $('.district-select').val(district_id).trigger('chosen:updated');
            });
        };

        function changeWard(data) {
            var html_district = '<select data-placeholder="Chọn phường/ xã" class="ward-select" name="ward_id" tabindex="5"><option value=""></option>';
            for (const [key, value] of Object.entries(data['ward'])) {
                html_district += '<option value="' + key + '">' + value + '</option>';
            }
            html_district += '</select>';
            $('.ward_select').empty();
            $('.ward_select').append(html_district);
            $('.ward-select').chosen().change(function () {
                var ward_id = $(this).val();
                $('.ward-select').val(ward_id).trigger('chosen:updated');
            });;
        };

        function changeProject(data) {
            let defa = $('project_select select').data('placeholder') ?? 'Chọn dự án';
            var html_district = '<option value="">'+ defa +'</option>';
            for (const [key, value] of Object.entries(data['projects'])) {
                console.log(JSON.stringify(value))
                html_district += '<option value="' + value['id'] + '">' + value['name'] + '</option>';
            }
            html_district += '</select>';
            $('.project_select select').empty();
            $('.project_select select').append(html_district);
        };
    </script>
<?php }