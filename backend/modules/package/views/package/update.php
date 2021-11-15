<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\package\Package */

$this->title = 'Cập nhật gói thầu: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách gói thầu', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="package-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'images' => $images,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
