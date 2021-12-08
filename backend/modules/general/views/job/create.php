<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\general\ChucDanh */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Nghề nghiệp', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a(Yii::t('app', 'create'), ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>