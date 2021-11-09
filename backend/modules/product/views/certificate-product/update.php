<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\CertificateProduct */

$this->title = 'Cập nhập chứng chỉ: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Chứng chỉ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'update');
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
