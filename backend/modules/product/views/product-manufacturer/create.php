<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OptionPrice */

$this->title = 'Thêm Thương hiệu';
$this->params['breadcrumbs'][] = ['label' => 'Thương hiệu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
