<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\affiliate\AffiliateLink */

$this->title = 'Create Affiliate Link';
$this->params['breadcrumbs'][] = ['label' => 'Affiliate Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="affiliate-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
