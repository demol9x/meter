<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\CertificateProductItem */

$this->title = 'Create Certificate Product Item';
$this->params['breadcrumbs'][] = ['label' => 'Certificate Product Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-product-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
