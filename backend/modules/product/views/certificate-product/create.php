<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\CertificateProduct */

$this->title = 'Thêm chứng chỉ';
$this->params['breadcrumbs'][] = ['label' => 'Chứng chỉ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
