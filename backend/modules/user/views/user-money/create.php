<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\user\UserMoney */

$this->title = 'Thêm tiền vào số điện thoại';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý tiền Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-money-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
