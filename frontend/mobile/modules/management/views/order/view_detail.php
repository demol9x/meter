<h2>
    <i class="fa fa-file-text" aria-hidden="true"></i>
    <b><?= Yii::t('app', 'orders') ?></b>
    OR<?= $data['order_id'] ?>
</h2>
<div class="table-shop">
    <table>
        <tbody>
            <tr>
                <td class="bg-eb" width="150">
                    <p><?= Yii::t('app', 'customer') ?></p>
                </td>
                <td>
                    <p><?= $data['name'] ?></p>
                </td>
            </tr>
            <tr>
                <td class="bg-eb" width="150">
                    <p><?= Yii::t('app', 'address') ?></p>
                </td>
                <td>
                    <p><?= $data['address'] ?></p>
                </td>
            </tr>
            <tr>
                <td class="bg-eb" width="150">
                    <p><?= Yii::t('app', 'phone') ?></p>
                </td>
                <td>
                    <p><a style="color: #000" href="tel:<?= $data['phone'] ?>"><?= $data['phone'] ?></a></p>
                </td>
            </tr>
            <tr>
                <td class="bg-eb" width="150">
                    <p><?= Yii::t('app', 'time_sell') ?></p>
                </td>
                <td>
                    <p><?= date('d/m/Y', $data['created_at']) ?></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>