<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = Yii::t('app', 'update_shop').': #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'shop_manager'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="user-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?=
    $this->render('_form', [
        'model' => $model,
        'transports' => $transports,
        'shop_transports' => $shop_transports,
        'image_auths' => $image_auths,
        'images' => $images,
    ])
    ?>

</div>
