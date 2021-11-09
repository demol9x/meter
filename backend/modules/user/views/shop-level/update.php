<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\user\UserMoney */

$this->title = 'Cập nhật danh hiệu gian hàng: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý danh hiệu gian hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="shop-level-update">
    <?=
	    $this->render('_form', [
	        'model' => $model,
	    ])
    ?>
</div>
