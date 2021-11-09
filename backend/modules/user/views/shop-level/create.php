<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\user\UserMoney */

$this->title = 'Thêm danh hiệu gian hàng';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý danh hiệu gian hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-money-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
