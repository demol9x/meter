<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\user\Tho */

$this->title = 'Create Tho';
$this->params['breadcrumbs'][] = ['label' => 'Thos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tho-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
