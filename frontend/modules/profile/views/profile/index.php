<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/thongtincanhan.css">
<div class="profile_pro_item">
    <div class="container_fix">
        <div class="item_left">
            <div class="menu-my-store">
                <div class="banner-store" id="avatar_img_avatar1">
                    <img id="bgr-shop" src="<?= yii::$app->homeUrl?>images/avt2.png" alt="">
                    <a class="fix-img-bg content_13"><i class="fa fa-camera" aria-hidden="true"></i>Thay đổi ảnh bìa</a>
                </div>
                <div class="img-store">
                    <div class="img" id="avatar_img_avatar2">
                        <img id="avatar-shop" src="<?= yii::$app->homeUrl?>images/avt2.png" alt="">
                    </div>
                    <h2 class="content_15">Trung Đức</h2>
                    <a class="fix-img-avatar content_13">Thay đổi ảnh đại diện</a>
                </div>
                <div class="menu-bar-store" tabindex="-1">
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="">
                            <img src="<?= yii::$app->homeUrl?>images/icon-menu3.png" alt="">
                            Kiểm tra đơn hàng<i class="count-notinfycation content_14">(45)</i>
                        </a>
                    </div>
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="">
                            <img src="<?= yii::$app->homeUrl?>images/bell-notify.png" alt="">
                            Thông báo<i class="count-notinfycation content_14">(165)</i>
                        </a>
                    </div>
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="">
                            <img src="<?= yii::$app->homeUrl?>images/ico-menu7.png" alt="">
                            Tin đăng
                        </a>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="">Danh sách tin</a>
                        </div>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="">
                                Liên hệ bán
                            </a>
                        </div>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="">
                                Liên hệ mua
                            </a>
                        </div>
                        <span class="span-lv-1 fa fa-angle-down"></span>
                    </div>
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href="">
                            <img src="<?= yii::$app->homeUrl?>images/ico-menu7.png" alt="">
                            Quản lý affiliate
                        </a>
                    </div>
                    <div class="menu-bar-lv-1">
                        <a class="a-lv-1 content_14" href=""><img src="<?= yii::$app->homeUrl?>images/icon-menu2.png" alt="">Hồ sơ cá nhân</a>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="">Thông tin cá nhân</a>
                        </div>
                        <div class="menu-bar-lv-2">
                            <a class="a-lv-2 content_14" href="">Địa chỉ</a>
                        </div>
                        <div class="menu-bar-lv-2"><a class="a-lv-2 content_14" href="">Tài khoản, thẻ ngân hàng</a></div>
                        <div class="menu-bar-lv-2"> <a class="a-lv-2 content_14" href="">Đổi mật khẩu</a></div>
                        <div class="menu-bar-lv-2"> <a class="a-lv-2 content_14" href="">Đổi mật khẩu cấp 2</a></div>
                        <span class="span-lv-1 fa fa-angle-down"></span>
                    </div>
                    <div class="menu-bar-lv-1">
                        <a class="content_14" href=""><img src="<?= yii::$app->homeUrl?>images/ico-menu7.png" alt="">Quản lý doanh nghiệp</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="item_right">
<!--            <style>-->
<!--                .table-shop {-->
<!--                    overflow-x: unset;-->
<!--                }-->
<!---->
<!--                .form-fixed .row {-->
<!--                    padding: 15px 0px;-->
<!--                    border-bottom: 1px solid #ebebeb;-->
<!--                }-->
<!---->
<!--                .form-fixed select {-->
<!--                    height: 34px;-->
<!--                    width: 100%;-->
<!--                }-->
<!---->
<!--                .btn {-->
<!--                    background: #dbbf6d;-->
<!--                    padding: 7px 20px;-->
<!--                    border: 0px;-->
<!--                    border-radius: 2px;-->
<!--                    display: inline-block;-->
<!--                    color: #fff;-->
<!--                }-->
<!---->
<!--                .delete-selfish {-->
<!--                    background: red;-->
<!--                }-->
<!---->
<!--                .form-fixed .note {-->
<!--                    color: red;-->
<!--                    font-size: 12px;-->
<!--                }-->
<!--            </style>-->
            <div class="form-create-store">
                <div class="title-form">
                    <h2 class="content_15"><img src="<?= yii::$app->homeUrl?>images/ico-hoso.png" alt=""> Hồ sơ của tôi</h2>
                </div>
                <div class="table-buyer table-shop">
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <label for="">Tên</label>
                            </td>
                            <td>
                                <p>Trung Đức</p>
                                <div class="form-fixed" id="username">
                                    <input type="text" class="input_text" name="username" placeholder="Nhập tên mới">
                                </div>
                            </td>
                            <td width="170" class="txt-right">
                                <a href="javascript:void(0);" class="open-fixed" data="#username"><i class="fa fa-pencil"></i>Thay đổi</a>
                                <div class="form-fixed">
                                    <a class="save-user"><i class="fa fa-check"></i>Lưu</a>
                                    <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="vertical-top">
                                <label for="">Email</label>
                            </td>
                            <td>
                                <p>trungduc.vnu@gmail.com</p>
                                <div class="form-fixed" id="useremail">
                                    <input type="text" class="input_text" name="email" placeholder="Nhập email mới">
                                </div>
                            </td>
                            <td width="170" class="txt-right">
                                <a class="open-fixed" data="#useremail"><i class="fa fa-pencil"></i>Thay đổi</a>
                                <div class="form-fixed">
                                    <a class="save-user-otp"><i class="fa fa-check"></i>Lưu</a>
                                    <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="vertical-top">
                                <label for="">Điện thoại</label>
                            </td>
                            <td>
                                <p>12345678912</p>
                                <div class="form-fixed" id="userphone">
                                    <input type="text" name="phone" class="input_text" placeholder="NHập số điện thoại mới">
                                </div>
                            </td>
                            <td width="170" class="txt-right">
                                <a class="open-fixed" data="#userphone"><i class="fa fa-pencil"></i>Thay đổi</a>
                                <div class="form-fixed">
                                    <a class="save-user-otp"><i class="fa fa-check"></i>Lưu</a>
                                    <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="vertical-top">
                                <label for="">Số CMT</label>
                            </td>
                            <td>
                                <p></p>
                                <div class="form-fixed" id="usercmt">
                                    <input type="text" name="cmt" class="input_text" placeholder="Nhập số CCCD mới">
                                </div>
                            </td>
                            <td width="170" class="txt-right">
                                <a class="open-fixed" data="#usercmt"><i class="fa fa-pencil"></i>Thay đổi</a>
                                <div class="form-fixed">
                                    <a class="save-user-otp"><i class="fa fa-check"></i>Lưu</a>
                                    <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="vertical-top">
                                <label for="">Giới tính</label>
                            </td>
                            <td>
                                <p>Nam</p>
                                <div class="form-fixed" id="usersex">
                                    <input type="hidden" class="input_text" name="sex">
                                    <div class="awe-check">
                                        <div class="group-check-box active">
                                            <label class="radio">
                                                <input type="radio" class="radio-change" name="radiobox" value="1">
                                                <div class="label"><span class="text-clip" title="radio">Nam</span></div>
                                            </label>
                                            <label class="radio">
                                                <input type="radio" class="radio-change" name="radiobox" value="0">
                                                <div class="label"><span class="text-clip" title="radio">Nữ</span></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td width="170" class="txt-right">
                                <a class="open-fixed" data="#usersex"><i class="fa fa-pencil"></i>Thay đổi</a>
                                <div class="form-fixed">
                                    <a class="save-user"><i class="fa fa-check"></i>Lưu</a>
                                    <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="vertical-top">
                                <label for="">Ngày sinh</label>
                            </td>
                            <td>
                                <p>30/07/2021</p>
                                <div class="form-fixed" id="userbirthday">
                                    <input type="hidden" class="input_text" name="birthday">
                                    <div class="row userbirthday">
                                        <div class="col-xs-4">
                                            <input type="number" id="birthday-day" min="0" max="31" placeholder="Ngày">
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="number" id="birthday-month" min="0" max="12" placeholder="Tháng">
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="number" id="birthday-year" min="1890" max="2019" placeholder="năm">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td width="170" class="txt-right">
                                <a class="open-fixed" data="#userbirthday"><i class="fa fa-pencil"></i>Thay đổi</a>
                                <div class="form-fixed">
                                    <a class="save-user-b"><i class="fa fa-check"></i>Lưu</a>
                                    <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="vertical-top">
                                <label for="">Địa chỉ</label>
                            </td>
                            <td>
                                <p>335, cầu giấy, Vĩnh Mỹ B, Hoà Bình, Bạc Liêu</p>
                            </td>
                            <td width="170" class="txt-right">
                                <a href="/dia-chi-ca-nhan.html"><i class="fa fa-pencil"></i>Thay đổi</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="vertical-top">
                                <label for="">Bạn là:</label>
                            </td>
                            <td>
                                <p></p>
                                <div class="form-fixed" id="bform-submit-group">
                                    <form class="form-submit-group">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <select name="UserInGroup[user_group_id]" id="user_group_id">
                                                    <option value="22">OCOP AN GIANG</option>
                                                    <option value="21">Hội viên Hiệp Hội Khởi Nghiệp Quốc Gia viNen</option>
                                                    <option value="19">Nhà sản xuất</option>
                                                    <option value="18">Người tiêu dùng</option>
                                                    <option value="15">Hội Nhà Vườn</option>
                                                    <option value="14">Chủ Doanh Nghiệp</option>
                                                    <option value="11">HIỆP HỘI OCOP VIỆT NAM</option>
                                                    <option value="10">OCOP HÀ NỘI</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <div class="box-imd">
                                                        <input type="hidden" id="useringroup-avatar" name="UserInGroup[avatar]">
                                                        <div id="useringroupavatar_img" class="img-view">
                                                        </div>
                                                        <div id="useringroupavatar_form" style="display: inline-block; position: relative;">
                                                            <button type="button" class="btn">Chọn ảnh thẻ chứng thực</button>
                                                            <div class="help-block"></div>
                                                            <form style="margin: 0px !important; padding: 0px !important; position: absolute; top: 0px; left: 0px; height: 100%; width: 100%;" method="POST" enctype="multipart/form-data" action="/upload/uploadfile.html">
                                                                <input name="file" type="file" style="display: block; overflow: hidden; width: 100%; height: 100%; text-align: right; opacity: 0; z-index: 999999; cursor: pointer;">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <button class="btn save-selfish">Lưu</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </td>
                            <td width="170" class="txt-right">
                                <a class="open-fixed" data="#userbirthday"><i class="fa fa-pencil"></i>Thay đổi</a>
                                <div class="form-fixed">
                                    <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i>Hủy</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
