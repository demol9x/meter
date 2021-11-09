<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\user\UserMoney */

$this->title = 'Cập nhật tiền cho số điện thoại: ' . $model->phone;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý tiền Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="user-money-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?=
    $this->render('_form_update', [
        'model' => $model,
        'log' => $log,
    ])
    ?>

</div>
