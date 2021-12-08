

    <div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt="">Chi tiết nhà đầu tư<div class="close_popup_duthau">X</div></h2>

        </div>
        <div class="table-buyer table-shop">
            <table>
                <tbody>
                <tr>
                    <td>
                        <label for="">Tên</label>
                    </td>
                    <td>
                        <p><?= $shop_oder['name'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Email</label>
                    </td>
                    <td>
                        <p><?= $shop_oder['email'] ?></p>

                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Điện thoại</label>
                    </td>
                    <td>
                        <p><?= $shop_oder['phone'] ?></p>
                        <div class="form-fixed" id="userphone">
                            <input type="text" name="phone" class="input_text" placeholder="NHập số điện thoại mới">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Ngày thành lập</label>
                    </td>
                    <td>
                        <p ><?= date('d/m/Y', $shop_oder['founding']) ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Địa chỉ</label>
                    </td>
                    <td>
                        <p><?= $shop_oder['address']?></p>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Vốn điều lệ</label>
                    </td>
                    <td>
                        <p><?= $shop_oder['price']?></p>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">website</label>
                    </td>
                    <td>
                        <p><?= $shop_oder['website']?></p>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Ngành nghề khinh doanh</label>
                    </td>
                    <td>
                        <p><?= $shop_oder['business']?></p>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Mã số thuế</label>
                    </td>
                    <td>
                        <p><?= $shop_oder['number_auth']?></p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <script>
        $('.close_popup_duthau').click(function () {
            $('.pop_up_view').toggleClass('active');
        })
    </script>
