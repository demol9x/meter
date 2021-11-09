<?php 
$order = new \common\models\order\Order();
$order->setAttributeShow($data);
?>

<div class="box-detail-order" id="box-detail">
    <h2>
        <i class="fa fa-file-text" aria-hidden="true"></i>
        <b><?= Yii::t('app', 'orders') ?></b>
        <?= $order->getOrderLabelId() ?>
    </h2>
    <div class="table-shop">
        <table >
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
                        <p><a style="color: #000" href="tel:<?= $data['phone'] ?>"><?= formatPhone($data['user_phone']) ?></a></p>
                    </td>
                </tr>
                <tr>
                    <td class="bg-eb" width="150">
                        <p><?= Yii::t('app', 'payment_method') ?></p>
                    </td>
                    <td>
                        <p><?= common\components\payments\ClaPayment::getName($data['payment_method']) ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="bg-eb" width="150">
                        <p><?= Yii::t('app', 'time_sell') ?></p>
                    </td>
                    <td>
                        <p><?= date('d/m/Y H:i', $data['created_at']) ?></p>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>