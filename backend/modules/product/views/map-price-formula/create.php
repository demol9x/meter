<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\MapPriceFormula */

$this->title = 'Create Map Price Formula';
$this->params['breadcrumbs'][] = ['label' => 'Map Price Formulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-price-formula-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
