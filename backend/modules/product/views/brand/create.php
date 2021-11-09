<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\Brand */

$this->title = 'Tạo thương hiệu';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thương hiệu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
