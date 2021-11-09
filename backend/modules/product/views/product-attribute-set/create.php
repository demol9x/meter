<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\ProductAttributeSet */

$this->title = 'Tạo nhóm thuộc tính';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý nhóm thuộc tính', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-attribute-set-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
