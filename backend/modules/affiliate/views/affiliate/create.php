<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\affiliate\AffiliateConfig */

$this->title = 'Create Affiliate Config';
$this->params['breadcrumbs'][] = ['label' => 'Affiliate Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="affiliate-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
