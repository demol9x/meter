<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductCategory */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý dự án', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'provinces' => $provinces,
    ]) ?>

</div>
