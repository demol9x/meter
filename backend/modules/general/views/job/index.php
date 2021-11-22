<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\general\ChucDanhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nghề nghiệp';
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
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            'name',
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>