<?php

use yii\helpers\Html;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = 'Kết nối ' . $cer->name;;
$this->params['breadcrumbs'][] = ['label' => 'Chứng thực số', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <div class="ctn-form">
        <?=
            $this->render('_form', [
                'model' => $model,
            ]) ?>
    </div>
</div>