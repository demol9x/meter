<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Recruitment */

$this->title = 'Cập nhật thông tin';
$this->params['breadcrumbs'][] = ['label' => 'Thông tin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruitment-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?=
    $this->render('_form', [
        'model' => $model,
        'provinces' => $provinces,
        'districts' => $districts,
        'wards' => $wards,
    ])
    ?>

</div>
