<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app','abuot_us');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-contact bg-whites content-page">
    <div style="padding: 0px 0px 40px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h2 class="title-content"><?= $this->title ?></h2>
        <hr/>
        <p style="margin-left: 25px"><b><?= $model->short_description ?></b></p>
        <div style="padding: 0px 10px" class="instroduce content-standard-ck">
            <?= $model->description ?>
        </div>
    </div>
</div>