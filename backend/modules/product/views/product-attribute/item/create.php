<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\ProductAttribute */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Bộ thuộc tính sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $data->name, 'url' => ['add','id' => $data->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-attribute-index">
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
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

