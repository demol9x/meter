<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\user\Tho */

$this->title = 'Update Tho: ' . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Thos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tho-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
