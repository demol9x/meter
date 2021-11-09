<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\MapPriceFormula */

$this->title = 'Update Map Price Formula: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Map Price Formulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="map-price-formula-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
