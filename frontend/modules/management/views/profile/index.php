<?php

use  common\components\ClaHost;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="item_right">
    <!--    <style>-->
    <!--        .table-shop {-->
    <!--            overflow-x: unset;-->
    <!--        }-->
    <!---->
    <!--        .form-fixed .row {-->
    <!--            padding: 15px 0px;-->
    <!--            border-bottom: 1px solid #ebebeb;-->
    <!--        }-->
    <!---->
    <!--        .form-fixed select {-->
    <!--            height: 34px;-->
    <!--            width: 100%;-->
    <!--        }-->
    <!---->
    <!--        .btn {-->
    <!--            background: #dbbf6d;-->
    <!--            padding: 7px 20px;-->
    <!--            border: 0px;-->
    <!--            border-radius: 2px;-->
    <!--            display: inline-block;-->
    <!--            color: #fff;-->
    <!--        }-->
    <!---->
    <!--        .delete-selfish {-->
    <!--            background: red;-->
    <!--        }-->
    <!---->
    <!--        .form-fixed .note {-->
    <!--            color: red;-->
    <!--            font-size: 12px;-->
    <!--        }-->
    <!--    </style>-->
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt=""> Hồ sơ của tôi</h2>
        </div>

        <div class="table-buyer table-shop">
            <table>
                <tbody>
                <tr>
                    <td>
                        <label for="">Tên</label>
                    </td>
                    <td>
                        <p><?= $user['username'] ?></p>
                        <div class="form-fixed" id="username">
                            <input type="text" class="input_text" name="username" placeholder="Nhập tên mới">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Email</label>
                    </td>
                    <td>
                        <p><?= $user['email'] ?></p>

                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Điện thoại</label>
                    </td>
                    <td>
                        <p><?= $user['phone'] ?></p>
                        <div class="form-fixed" id="userphone">
                            <input type="text" name="phone" class="input_text" placeholder="NHập số điện thoại mới">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Ngày sinh</label>
                    </td>
                    <td>
                        <p><?= date('d/m/Y', $user->birthday) ?></p>
                    </td>

                </tr>
                <tr>
                    <td class="vertical-top">
                        <label for="">Địa chỉ</label>
                    </td>
                    <td>
                        <p><?= $user_address['address']?> - <?= $user_address['ward_name']?> - <?= $user_address['district_name'] ?> - <?= $user_address['province_name'] ?></p>
                    </td>
                    <td width="170" class="txt-right">
                        <a href="<?= Url::to(['/management/profile/address'])?>"><i class="fa fa-pencil"></i>Thay đổi</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
