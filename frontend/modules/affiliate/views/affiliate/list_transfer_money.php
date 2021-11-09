<?php 
use common\models\affiliate\AffiliateTransferMoney;
?>
<div class="form-create-store">
    <div class="infor-account">
        <h2>
            Danh sách yêu cầu chuyển khoản
        </h2>
    </div>
    <div class="ctn-donhang tab-menu-read tab-menu-read-1" style="display: block;">
        <div class="item-info-donhang">
            <div class="table-donhang table-shop">
                <table>
                    <tbody>
                        <tr class="header-table">
                            <td>
                                <b>Số thứ tự</b>
                            </td>
                            <td class="center">
                                <b>Số tiền</b>
                            </td>
                            <td class="center">
                                <b>Ghi chú</b>
                            </td>
                            <td class="center">
                                <b>Admin phản hồi</b>
                            </td>
                            <td class="center">
                                <b>Trạng thái</b>
                            </td>
                        </tr>
                        <?php
                        if (isset($data) && $data) {
                            foreach ($data as $item) {
                                ?>
                                <tr>
                                    <td class="center">
                                        <b><?= $item['id'] ?></b>
                                    </td>
                                    <td class="center">
                                        <b><?= number_format($item['money'], 0, ',', '.') ?> VNĐ</b>
                                    </td>
                                    <td class="center">
                                        <b><?= $item['note'] ?></b>
                                    </td>
                                    <td class="center">
                                        <b><?= $item['note_admin'] ?></b>
                                    </td>
                                    <td class="center">
                                        <b><?= AffiliateTransferMoney::getNameStatus($item['status']) ?></b>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>