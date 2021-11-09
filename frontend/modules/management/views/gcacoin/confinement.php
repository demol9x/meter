<?php

use yii\helpers\Url;

$this->title = 'Chi tiết' . __VOUCHER_RED . ' tạm khóa';
?>

<div class="form-create-store">
    <div class="title-form">
        <h2><img src="/gcaeco/images/ico-map-marker.png" alt=""> <?= $this->title ?> </h2>
    </div>
    <div class="row" style="padding: 15px 25px;">
        <div class="col-md-4"><label>Số <?= __VOUCHER_RED ?> tạm khóa</label></div>
        <div class="col-md-4"><?= number_format(\common\models\gcacoin\CoinConfinement::getCoinConfinement(Yii::$app->user->id), 0, ',', '.')  ?> (<?= __VOUCHER_RED ?>)</div>
    </div>
</div>
<div class="form-create-store">
    <div class="title-form">
        <h2><img src="/gcaeco/images/ico-map-marker.png" alt="">Danh sách </h2>
        <i style="padding: 0px 10px; display: block;"><b>Lưu ý:</b> Thời gian tạm khóa chỉ đếm ngược khi đơn hàng của quý khách đã ở trang thái "Đã giao hàng".</i>
    </div>
    <div class="row box-chitiet-taikhoan" style="padding: 15px 25px;">
        <table class="tbllisting" style="margin-top:15px">
            <tbody>
                <tr class="tblsheader">
                    <th scope="col" class="colCenter">Ngày thêm</th>
                    <th scope="col" class="colCenter">Số OCOP V khóa</th>
                    <th scope="col" class="colCenter">Mô tả</th>
                    <th scope="col" class="colCenter">Thời gian khóa</th>
                </tr>
                <?php if (isset($confinements) && $confinements) : ?>
                    <?php
                    foreach ($confinements as $item) {
                        $coin = $item['coin'];
                    ?>
                        <tr>
                            <td class="colCenter"><?= date('d-m-Y H:i:s', $item['created_at']) ?></td>
                            <td class="colRight"><span style="padding-right: 25px"><?= (($coin) > 0) ? '+' . formatCoin(($coin)) : ($coin) ?></span></td>
                            <td class="colCenter">
                                <?php
                                print_r($item['note']);
                                ?>
                            </td>
                            <td>
                                <?php
                                $time = $item['hour'];
                                if ($item['order_status'] != 4) {
                                    $time = $time / (60 * 60);
                                    echo 'Hơn ' . (($time / 24 > 1) ? CEIL($time / 24) . ' ngày' : CEIL($time ? $time : 1) . ' giờ');
                                } else {
                                    $time = ($item['order_updated_at'] + $time) - time();
                                    $time = $time > 0 ? $time / (60 * 60) : 0;
                                    if ($time) {
                                        echo 'Gần ' . (($time / 24 > 1) ? CEIL($time / 24) . ' ngày' : CEIL($time) . ' giờ');
                                    } else {
                                        echo 'Gần 5 phút';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('input').keyup(function() {
        var number = $('#money').val();
        number = number.replace(/\,/g, '');
        var a = format_number(number);
        $('#money').val(a);
    });

    function format_number(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    $(document).ready(function() {
        $('#payment_method_open').click(function() {
            $('#payment_method').css('display', 'block');
        });
        $('#payment_method_close').click(function() {
            $('#payment_method').css('display', 'none');
        })
    });

    function payment_method(t) {
        var type = $('input[name=payment_method]:checked').val();
        var money = $('#money').val();
        money = money.replace(/\,/g, '');
        money = parseInt(money);

        if (money) {
            if (money % 1000 == 0) {
                $.ajax({
                    url: '<?= Url::to(['/management/gcacoin/payment-method']) ?>',
                    type: 'POST',
                    data: {
                        type: type,
                        money: money,
                        _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
                    },
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            window.location.href = data;
                        }
                    }
                });
            } else {
                alert('Số tiền phải là bội số của 1000');
            }

        } else {
            alert('Số tiền không hợp lệ hoặc Bạn chưa điền đủ thông tin');
        }

    }
</script>