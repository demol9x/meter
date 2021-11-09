<?php

use yii\helpers\Url;
use common\components\ActiveFormC; ?>
<style>
    .table .trupdt .udtp {
        text-align: right;
        width: 22px;
        padding: 0px;
        border: 0px;
        pointer-events: none;
    }

    .table .trupdt .udtp {}

    .table .udtp {
        width: 30px;
        margin-right: 5px;
    }

    .trupdt .afcb {
        display: none;
    }

    .bfcb {
        display: none;
    }

    .trupdt .bfcb {
        display: inline-block;
    }

    .disabledbuttonone {
        pointer-events: none;
        opacity: 0.4;
    }

    .notcheck .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }

    body .bnt-ch {
        padding: 0px 10px;
        display: inline-block;
        line-height: 0px;
        font-size: 12px;
        height: 30px;
    }

    body a.bnt-ch {
        height: 30px;
        background: green;
        line-height: 30px;
        color: #fff;
        border-radius: 5px;
        margin-right: 15px;
        text-transform: uppercase;
        font-weight: bold;
    }

    .name-p {
        display: inline-block;
        width: 180px;
    }

    .tool a {
        margin-right: 10px;
        text-transform: uppercase;
        font-size: 12px;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= Yii::t('app', 'affiliate') ?>
        </h2>
    </div>
    <div class="list-address-pay">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item active">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Quản lý Afiliate dành cho DN</a>
            </li>
            <li class="nav-item">
                <?php if ($model->status_affiliate) { ?>
                    <a class="nav-link" href="<?= Url::to(['/management/shop-affiliate/index-service']) ?>">QR-CODE dịch vụ</a>
                <?php } else { ?>
                    <a class="nav-link click" onclick="alert('Chức năng chỉ mở khi bạn đã kích hoạt Affilate.')">QR-CODE dịch vụ</a>
                <?php }  ?>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active in" id="home" role="tabpanel" aria-labelledby="home-tab">
                <?php if ($model->affiliate_waitting && !$model->errors) { ?>
                    <p style="margin-top: 20px;">
                        Thông tin affiliate đăng chờ duyệt.

                        <a data-confirm="Xác nhận hủy?" href="<?= Url::to(['cancer-change']) ?>">Hủy thay đổi</a>
                    </p>
                    <table class="table">
                        <tr>
                            <td><b><?= $model->attributeLabels()['status_affiliate_waitting'] ?></b></td>
                            <td><?= $model->status_affiliate_waitting ? 'Bật' : 'Tắt' ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->attributeLabels()['affiliate_admin_waitting'] ?></b></td>
                            <td><?= $model->affiliate_admin_waitting ?>%</td>
                        </tr>
                        <tr>
                            <td><b><?= $model->attributeLabels()['affiliate_gt_shop_waitting'] ?></b></td>
                            <td><?= $model->affiliate_gt_shop_waitting ?>%</td>
                        </tr>
                    </table>
                <?php } ?>
                <?php
                if (!$model->errors) {
                    $model->status_affiliate_waitting = $model->status_affiliate;
                    $model->affiliate_admin_waitting = $model->affiliate_admin;
                    $model->affiliate_gt_shop_waitting = $model->affiliate_gt_shop;
                }
                ?>
                <div class="ctn-form">
                    <?php $form = ActiveFormC::begin(); ?>
                    <?= $form->fieldF($model, 'status_affiliate_waitting')->checkBox()->labelF() ?>
                    <?= $form->fieldF($model, 'affiliate_admin_waitting')->textInput()->labelF() ?>
                    <?= $form->fieldF($model, 'affiliate_gt_shop_waitting')->textInput()->labelF() ?>
                    <div class="btn-submit-form">
                        <input type="submit" id="shop-form" value="<?= ($model->isNewRecord) ?  Yii::t('app', 'create_shop') :  Yii::t('app', 'update_shop') ?>">
                    </div>
                    <?php ActiveFormC::end(); ?>
                </div>
                <hr />
                <p>Danh sách sản phẩm tham gia affiliate /Affiliate cho tài khoản:</p>
                <form action="<?= Url::to(['update-list']) ?>" class="form-list-affiliate" method="POST" name="yourForm">
                    <table class="table">
                        <thead>
                            <tr>
                                <td><input class="chudtpall" type="checkbox"></td>
                                <td>Tên sản phẩm</td>
                                <td>Giới thiệu sản phẩm</td>
                                <td>Mua bằng V</td>
                                <td>Ocop charity 4.0</td>
                                <td>Giảm trực tiếp</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody id="box-item">
                            <?php if ($products) {
                                foreach ($products as $product) if (!$product['pay_servive']) { ?>
                                    <tr class="trupdt">
                                        <td><input class="chudtp" type="checkbox" name="list[<?= $product['id'] ?>][id]" value="1"></td>
                                        <td>
                                            <b class="name-p"><?= $product->name ?></b>
                                        </td>
                                        <td><input class="udtp affiliate_gt_product" type="text" min="0" data-old="<?= $product->affiliate_gt_product ?>" name="list[<?= $product['id'] ?>][affiliate_gt_product]" value="<?= $product->affiliate_gt_product ?>">%</td>
                                        <td><input class="udtp affiliate_m_v" type="text" min="0" data-old="<?= $product->affiliate_m_v ?>" name="list[<?= $product['id'] ?>][affiliate_m_v]" value="<?= $product->affiliate_m_v ?>">%</td>
                                        <td><input class="udtp affiliate_charity" type="text" min="0" data-old="<?= $product->affiliate_charity ?>" name="list[<?= $product['id'] ?>][affiliate_charity]" value="<?= $product->affiliate_charity ?>">%</td>
                                        <td><input class="udtp affiliate_safe" type="text" min="0" data-old="<?= $product->affiliate_safe ?>" name="list[<?= $product['id'] ?>][affiliate_safe]" value="<?= $product->affiliate_safe ?>">%</td>
                                        <td class="tool">
                                            <a class="bfcb update-it click">Sửa</a>
                                            <a data-id="<?= $product['id'] ?>" class="bfcb del-it click">Xóa</a>
                                            <a class="afcb save-it click" product_id="<?= $product['id'] ?>">Lưu</a>
                                            <a class="afcb cancer-it click">Hủy</a>
                                        </td>
                                    </tr>
                                <?php }  ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5">Chưa có sản phẩm tham gia</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <p id="load-form" class="center"></p>
                    <div class="btn-submit-form notcheck">
                        <a class="bnt-ch add-it click open-popup-link" href="#box-add">Thêm sản phẩm</a>
                        <input class="bnt-ch disabledbutton" type="submit" name="update" value="Lưu tất cả đánh dấu">
                        <input class="bnt-ch disabledbutton" type="submit" name="delete" value="Xóa tất cả đánh dấu">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="box-add" class="white-popup mfp-hide">
        <div class="box-account">
            <span class="mfp-close"></span>
            <div class="bg-pop-white">
                <div class="title-popup">
                    <h2>Chọn sản phẩm tham gia affiliate</h2>
                </div>
                <div class="ctn-review-popup">
                    <table class="table">
                        <tbody>
                            <?php if ($product_ns) foreach ($product_ns as $product) { ?>
                                <tr class="trupdt">
                                    <td><input type="checkbox" name="add" value="<?= $product->id ?>" pname="<?= $product->name ?>"></td>
                                    <td>
                                        <b><?= $product->name ?></b>
                                    </td>
                                </tr>
                            <?php }
                            else { ?>
                                <tr>
                                    <td colspan="5">Không có sản phẩm</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="btn-submit-forms">
                        <a class="bnt-ch add-it-add click">Chọn</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('change', '.chudtp', function() {
            if ($(this).is(':checked')) {
                $(this).closest('tr').removeClass('trupdt');
            } else {
                $(this).closest('tr').addClass('trupdt');
            }
            list = $('.chudtp');
            check = false;
            list.each(function() {
                if ($(this).is(':checked')) {
                    check = true;
                    return false;
                }
            });
            if (check) {
                $('.btn-submit-form').removeClass('notcheck');
            } else {
                $('.btn-submit-form').addClass('notcheck');
            }
        });
        $(document).on('change', '.chudtpall', function() {
            if ($(this).is(':checked')) {
                $('.chudtp').prop('checked', true);
                $('.chudtp').checked;
                $('#box-item tr').removeClass('trupdt');
                $('.btn-submit-form').removeClass('notcheck');
            } else {
                $('.chudtp').prop('checked', false);
                $('.chudtp').attr('data-check', '0');
                $('#box-item tr').addClass('trupdt');
                $('.btn-submit-form').addClass('notcheck');
            }
        });
        $(document).on('click', '.cancer-it', function() {
            input = $(this).closest('tr').find('.udtp');
            input.each(function() {
                $(this).val($(this).attr('data-old'));
            });
            $(this).closest('tr').find('.chudtp').click();
        });
        $(document).on('click', '.update-it', function() {
            $(this).closest('tr').find('.chudtp').click();
        });
        $('.form-list-affiliate').submit(function() {
            if ($(this).attr('data-load') != '1') {
                type = $(this).find("input[type=submit]:focus").attr('name');
                if (type == 'delete') {
                    if (confirm('Bạn đồng ý hủy tham gia affiliate những sản phẩm đã chọn?')) {
                        $('#load-form').html('Đang cập nhật...');
                        $.ajax({
                            url: $(this).attr('action'),
                            data: $(this).serialize() + '&submit=' + type,
                            type: 'POST',
                            success: function(result) {
                                $('#load-form').html('');
                                if (result == 'success') {
                                    location.reload();
                                } else {
                                    alert('Lỗi dữ liệu không đúng. Vui lòng kiểm tra lại các sản phẩm cập nhật');
                                    $(this).attr('data-load', '0');
                                }
                            }
                        });
                    }
                } else {
                    $('#load-form').html('Đang cập nhật...');
                    $.ajax({
                        url: $(this).attr('action'),
                        data: $(this).serialize() + '&submit=' + type,
                        type: 'POST',
                        success: function(result) {
                            $('#load-form').html('');
                            if (result == 'success') {
                                location.reload();
                            } else {
                                alert('Lỗi dữ liệu không đúng. Vui lòng kiểm tra lại các sản phẩm cập nhật');
                                $(this).attr('data-load', '0');
                            }
                        }
                    });
                }
            }
            return false;
        });
        $(document).on('click', '.save-it', function() {
            tr = $(this).closest('tr');
            tr.addClass('disabledbuttonone');
            $.ajax({
                url: "<?= Url::to(['update']) ?>",
                data: {
                    product_id: $(this).attr('product_id'),
                    'affiliate_gt_product': tr.find('.affiliate_gt_product').first().val(),
                    'affiliate_m_v': tr.find('.affiliate_m_v').first().val(),
                    'affiliate_charity': tr.find('.affiliate_charity').first().val(),
                    'affiliate_safe': tr.find('.affiliate_safe').first().val()
                },
                type: 'POST',
                success: function(result) {
                    tr.removeClass('disabledbuttonone');
                    tr.html(result);
                }
            });
            return false;
        });
        $(document).on('click', '.add-it-add', function() {
            kt = false;
            $('input[name="add"]:checked').each(function() {
                id = $(this).val();
                $('#box-item').append('<tr class=""> <td><input checked class="chudtp" type="checkbox" name="list[' + id + '][id]" value="1"></td> <td> <b class="name-p">' + $(this).attr('pname') + '</b> </td> <td><input class="udtp affiliate_gt_product" type="text" min="0" data-old="0" name="list[' + id + '][affiliate_gt_product]" value="0">%</td> <td><input class="udtp affiliate_m_v" type="text" min="0" data-old="0" name="list[' + id + '][affiliate_m_v]" value="0">%</td> <td><input class="udtp affiliate_charity" type="text" min="0" data-old="0" name="list[' + id + '][affiliate_charity]" value="0">%</td> <td><input class="udtp affiliate_safe" type="text" min="0" data-old="0" name="list[' + id + '][affiliate_safe]" value="0">%</td> <td class="tool"> <a class="bfcb update-it click">Sửa</a><a href="" class="afcb save-it click" product_id="' + id + '">Lưu</a> <a class="remove-it click">Xóa</a> </td> </tr>');
                kt = true;
                $(this).closest('tr').remove();
            });
            if (kt) {
                $('.btn-submit-form').removeClass('notcheck');
                $('.mfp-close').click();
            } else {
                alert('Vui lòng chọn sản phẩm tham gia');
            }
        });
        $(document).on('click', '.remove-it', function() {
            if (confirm('Bạn đồng ý xóa?')) {
                $(this).closest('tr').remove();
            }
        });
        $(document).on('click', '.del-it', function() {
            _this = $(this);
            if (confirm('Bạn đồng ý xóa?')) {
                $.ajax({
                    url: '<?= Url::to(['/management/shop-affiliate/delele']) ?>',
                    data: {
                        id: $(this).attr('data-id')
                    },
                    type: 'GET',
                    success: function(result) {
                        alert('Đã xóa');
                        _this.closest('tr').remove();
                    }
                });
            }
        });
    </script>
</div>
<?php
__addCss(
    ""
);
?>