<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\package\Package */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách gói thầu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl ?>images/ico-hoso.png" alt=""> Thêm mới gói thầu
            </h2>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
            'images' => $images,
        ]) ?>
    </div>
</div>