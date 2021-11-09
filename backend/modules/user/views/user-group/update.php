<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'Cập nhật nhóm người dùng: #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý nhóm người dùng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="user-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
