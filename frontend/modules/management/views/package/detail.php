<?php
use yii\helpers\Url;

?>
<style>
    th{width: auto}
</style>
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt="">Doanh nghiệp đăng kí dự thầu</h2>
        </div>
        <div class="table-buyer table-shop">
            <table>
                <tr><th>Tên</th><th>Email</th><th>Điện thoại</th><th>Ngày đăng ký</th><th>Vốn điều lệ</th></tr>
                <?php foreach ($shop_oder as $key){?>
                <tr><td><?= $key['name']?></td>

                <td><p><?= $key['email'] ?></p></td>
                <td><p><?= $key['phone'] ?></p></td>
                <td style="width: 170px;"><p><?= date('d/m/Y', $key['created_at'])?></p></td>
                <td><p><?= $key['price']?></p></td><td width="170" class="txt-right"><a class="view_package"  data-id="<?= $key['id']?>"><i class="fa fa-pencil"></i>Xem thông tin</a></td></tr>
                <?php }?>
            </table>
        </div>
    </div>
</div>


<div id="pop_up_view-dd"class="pop_up_view"></div>
<style>

</style>
<script>
    $('.view_package').click(function () {
        $('.pop_up_view').addClass('active');
        var data_id = $(this).data('id');

        $.ajax({
            url: "<?= yii\helpers\Url::to(['/management/package/viewpopup']) ?>",
            type: "get",
            data: {"data_id": data_id},
            success: function (response) {
                if (response.code=='200' && response.html) {
                    $('#pop_up_view-dd').html(response.html);
                    return false;
                }
                else
                {
                    alert(response.mess);
                }

            },
        });
    });

</script>