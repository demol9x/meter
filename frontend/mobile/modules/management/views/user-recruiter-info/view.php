<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserRecruiterInfo */

$this->title = 'Thông tin nhà tuyển dụng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-recruiter-info-view">


    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> <?= Html::encode($this->title) ?> </h2>
                    <?= Html::a('Cập nhật', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'user_id',
                            'contact_name',
                            'phone',
                            'scale',
                            'address',
                            'province_id' => [
                                'attribute' => 'province_id',
                                'content' => function($model) {
                                    $province = common\models\Province::findOne($model->province_id);
                                    echo "<pre>";
                                    print_r($province);
                                    echo "</pre>";
                                    die();
                                    return $province->name;
                                }
                            ],
                            'district_id',
                            'ward_id',
                            'avatar_path',
                            'avatar_name',
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
