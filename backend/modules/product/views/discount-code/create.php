<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\Brand */

$this->title = 'Tạo mã giảm giá';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý mã giảm giá', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
