<?php
use  common\components\ClaHost;
//echo '<pre>';
//print_r($model);
//echo '</pre>';
//die();
?>
<div class="site51_prodel_col12_chitietgoithau">
    <div class="container_fix">
        <?php //Menu main
        echo frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(['view'=>'view']);
        ?>
        <div class="pro_detail">
            <div class="detail_left wow fadeInLeft" data-wow-duration="3s"
                 style="visibility: visible; animation-duration: 3s;">
                <div class="left_env">
                    <div class="slide_detail_on">
                        <div class="img_detail">
                            <a data-fancybox="gallery" href="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>">
                                <img src="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>" alt="">
                            </a>
                        </div>

                    </div>
                    <div class="slide_detail_in">
                        <div class="img_detail_1">
                            <a data-fancybox="gallery" href="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>">
                                <img src="<?= ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>" alt="">
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="detail_right wow fadeInRight" data-wow-duration="3s"
                 style="visibility: visible; animation-duration: 3s;">
                <div class="content">
                    <div class="title title_28">
                        <?= $model->name ?>
                    </div>
                    <div class="description">
                        <i class="far fa-sticky-note"></i><span class="content_16">Đăng ký dự thầu 15</span></div>
                </div>
                <div class="contact_info">
                    <div class="content_16_b">Thông tin liên lạc:</div>
                    <div class="contact_row">
                        <img src="<?= yii::$app->homeUrl?>images/img_detail_home.png" alt="">
                        <a href="" class="content_16"><?= $shop->name?></a>
                    </div>
                    <div class="contact_row">
                        <i class="far fa-map-marker-alt"></i>
                        <span class="content_16"><?= $shop->address ?></span>
                    </div>
                    <div class="contact_row">
                        <div class="contact_flex">
                            <div class="flex">
                                <i class="far fa-phone-alt"></i>
                                <a href="tel:<?= $shop->phone ?>" class="content_16"><?= $shop->phone ?></a>
                            </div>
                            <div class="flex">
                                <i class="far fa-envelope"></i>
                                <a href="mailto:<?= $shop->email ?>" class="content_16"> <?= $shop->email ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail_des">
                    <span class="content_16_b">Giới thiệu:</span>
                    <span class="content_16"><?= isset($model->short_description) && $model->short_description ? $model->short_description : 'Đang cập nhật' ?></span>
                </div>
                <div class="detail_upload">
                    <i class="far fa-paperclip"></i>
                    <a href="" class="content_16"><?= $model->ho_so?></a>
                </div>
                <a class="detail_button btn-animation">
                    <img src="<?= yii::$app->homeUrl?>images/pages.png" alt=""><span class="content_16_b">Đăng ký dự thầu</span>
                </a>
            </div>
        </div>
        <?php //gói thầu
        echo frontend\widgets\package\PackageWidget::widget([
            'view'=>'view',
            'shop_id'=> $model->shop_id,
            'limit'=>10
        ]);
        ?>
        <div class="pro_main">
            <div class="pro_flex_left">
                <div class="nav_menu">
                    <a id="scroll_load_1" href="#" class="nav_list active title_18">Mô tả gói thầu</a>
                    <a id="scroll_load_2" href="#" class="nav_list title_18">hồ sơ dự thầu</a>
                </div>
                <div id="pro_desc_list" class="pro_description">
                    <?= $model->description ?>
                    <div class="button_position">
                        <a class="content_16 btn-animation">Xem thêm <i class="fas fa-chevron-down"></i></a>
                    </div>
                    <div class="button_position_view active">
                        <a class="content_16 btn-animation">Thu gọn <i class="fas fa-chevron-up"></i></a>
                    </div>
                </div>
                <div id="pro_desc_list_1" class="pro_description_1">
                    <div class="pro_package">
                        <div class="pro_content">
                            <div class="content_text">
                                <h3>hồ sơ dự thầu</h3>
                            </div>
                        </div>
                        <div class="pro_flex">
                            <table>
                                <tr>
                                    <td class="content_16">Đơn dự thầu hoặc giấy tờ thỏa thuận liên doanh (nếu có)</td>
                                    <td class="content_16">Bộ giấy tờ thỏa thuận liên doanh chỉ có khi các đơn vị đấu thầu cùng liên
                                        kết, hợp tác với nhau để giành lấy gói thầu lớn với mức giá cả mà các bên
                                        đều thỏa thuận đồng ý.</td>
                                </tr>
                                <tr>
                                    <td class="content_16">Đơn dự thầu hoặc giấy tờ thỏa thuận liên doanh (nếu có)</td>
                                    <td class="content_16">Bộ giấy tờ thỏa thuận liên doanh chỉ có khi các đơn vị đấu thầu cùng liên
                                        kết, hợp tác với nhau để giành lấy gói thầu lớn với mức giá cả mà các bên
                                        đều thỏa thuận đồng ý.</td>
                                </tr>
                                <tr>
                                    <td class="content_16">Đơn dự thầu hoặc giấy tờ thỏa thuận liên doanh (nếu có)</td>
                                    <td class="content_16">Bộ giấy tờ thỏa thuận liên doanh chỉ có khi các đơn vị đấu thầu cùng liên
                                        kết, hợp tác với nhau để giành lấy gói thầu lớn với mức giá cả mà các bên
                                        đều thỏa thuận đồng ý.</td>
                                </tr>
                                <tr>
                                    <td class="content_16">Đơn dự thầu hoặc giấy tờ thỏa thuận liên doanh (nếu có)</td>
                                    <td class="content_16">Bộ giấy tờ thỏa thuận liên doanh chỉ có khi các đơn vị đấu thầu cùng liên
                                        kết, hợp tác với nhau để giành lấy gói thầu lớn với mức giá cả mà các bên
                                        đều thỏa thuận đồng ý.</td>
                                </tr>
                                <tr>
                                    <td class="content_16">Đơn dự thầu hoặc giấy tờ thỏa thuận liên doanh (nếu có)</td>
                                    <td class="content_16">Bộ giấy tờ thỏa thuận liên doanh chỉ có khi các đơn vị đấu thầu cùng liên
                                        kết, hợp tác với nhau để giành lấy gói thầu lớn với mức giá cả mà các bên
                                        đều thỏa thuận đồng ý.</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="button_pro_detail">
                    <a class="detail_button btn-animation">
                        <img src="<?= yii::$app->homeUrl?>images/pages.png" alt=""><span class="content_16_b">Đăng ký dự thầu</span>
                    </a>
                </div>
            </div>
            <?php //gói thầu
            echo frontend\widgets\package\PackageWidget::widget([
                'view'=>'view_left',
                'isnew'=> 1,
                'limit'=> 10
            ]);
            ?>
        </div>
        <div class="pro_slide">
            <div class="pro_package">
                <div class="pro_content">
                    <div class="content_text">
                        <h3>gói thầu khác</h3>
                    </div>
                </div>
                <?php //gói thầu
                echo frontend\widgets\package\PackageWidget::widget([
                    'view'=>'view_random',
                    'isnew'=> 1,
                    'ishot'=>1,
                    'limit'=> 10
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div id="popup_goithau" class="site51_popup_col12_popupgoithau">
    <div class="popup_goithau">
        <div class="popup_flex">
            <div class="item-title-popup">
                <div class="title-popup-donhang">
                    <h3 class="title_26">ĐĂNG KÝ DỰ THẦU</h3>
                    <img class="Rectangle" src="<?= yii::$app->homeUrl?>images/Rectangle.png">
                </div>
            </div>
            <div id="popup_close_goithau" class="popup_close">
                <i class="fas fa-times"></i>
            </div>
            <div class="popup_goithau--env">
                <div class="popup_content">
                    <div class="popup_img">
                        <img src="<?= yii::$app->homeUrl?>images/image10.png" alt="">
                    </div>
                    <div class="detaile">
                        <div class="popup_title title_28">
                            <span> Công trình nhà hàng Sen Lý Thái Tổ</span>
                        </div>
                        <div class="contact_info">
                            <div class="content_16_b">Thông tin liên lạc:</div>
                            <div class="contact_row">
                                <img src="<?= yii::$app->homeUrl?>images/img_detail_home.png" alt="">
                                <a href="" class="content_16">Công ty Cổ phần ABC</a>
                            </div>
                            <div class="contact_row">
                                <i class="far fa-map-marker-alt"></i>
                                <span class="content_16">60 Phố Lý Thái Tổ, Tràng Tiền, Hoàn Kiếm, Hà Nội</span>
                            </div>
                            <div class="contact_row">
                                <div class="contact_flex">
                                    <div class="flex">
                                        <i class="far fa-phone-alt"></i>
                                        <a href="" class="content_16">0123.456.789</a>
                                    </div>
                                    <div class="flex">
                                        <i class="far fa-envelope"></i>
                                        <a href="" class="content_16">abcgroup@gmail.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pro_content">
                    <div class="content_text">
                        <h3>HỒ SƠ DỰ THẦU</h3>
                    </div>
                </div>
                <form action="">
                    <div class="form-group form-row">
                        <label for="">Tên công ty<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="text" id="" name="" placeholder="Tên công ty">
                            <small class="error-message">Nhập đầy đủ tên công ty</small>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Ngày thành lập<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="date" id="" name="" placeholder="Ngày/Tháng/Năm">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Mã số thuế<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="text" id="" name="" placeholder="Nhập mã số thuế">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Ngành nghề chính<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="text" id="" name="" placeholder="Nhập lĩnh vực kinh doanh">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Số điện thoại<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="text" id="" name="" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Email<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="text" id="" name="" placeholder="Nhập email công ty">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Website<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="text" id="" name="" placeholder="Nhập website công ty">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Địa chỉ<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="text" id="" name="" placeholder="Nhập địa chỉ công ty">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Vốn điều lệ<span class="require">(*)</span></label>
                        <div class="form-field">
                            <input type="text" id="" name="" placeholder="Nhập vốn điều lệ công ty">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="">Tài liệu đính kèm<span class="require">(*)</span></label>
                        <div class="form-field">
                            <label>
                                <input type="file" id="" name="" placeholder="Chọn hình ảnh">
                                <p class="content_16">Chọn file</p>
                            </label>
                        </div>
                    </div>
                    <textarea class="content_16" name="" id="" placeholder="Thông tin khác"></textarea>
                </form>

                <a href="" title="" class="btn-animation click_send content_16">Nộp hồ sơ
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cursor" viewBox="0 0 16 16">
                        <path d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>





