<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \common\components\ActiveFormC;
/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'Affliate: #' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Affilate chờ duyệt ', 'url' => ['affiliate']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<style>
    .form-horizontal .control-label {
        text-align: left;
    }
</style>
<div class="user-update">
    <div class="user-form">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <?php
                $form = ActiveFormC::begin([
                    'id' => 'otp-form',
                    'options' => [
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data'
                    ]
                ]);
                ?>
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-bars"></i> <?= Html::encode($this->title) ?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p>
                            Thông tin affiliate đang hoạt động.
                        </p>
                        <table class="table">
                            <tr>
                                <td><b><?= $model->attributeLabels()['status_affiliate_waitting'] ?></b></td>
                                <td><?= $model->status_affiliate ? 'Bật' : 'Tắt' ?></td>
                            </tr>
                            <tr>
                                <td><b><?= $model->attributeLabels()['affiliate_admin_waitting'] ?></b></td>
                                <td><?= $model->affiliate_admin ?>%</td>
                            </tr>
                            <tr>
                                <td><b><?= $model->attributeLabels()['affiliate_gt_shop_waitting'] ?></b></td>
                                <td><?= $model->affiliate_gt_shop ?>%</td>
                            </tr>
                        </table>
                        <p>
                            Thông tin affiliate đăng chờ duyệt.
                        </p>
                        <?= $form->fieldB($model, 'status_affiliate_waitting')->dropDownList(['1' => 'Bật', '0' => 'Tắt'])->label() ?>
                        <?= $form->fieldB($model, 'affiliate_admin_waitting')->textInput(['maxlength' => true])->label() ?>
                        <?= $form->fieldB($model, 'affiliate_gt_shop_waitting')->textInput(['maxlength' => true])->label() ?>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Xác nhận thay đổi', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'submit-form']) ?>
                        <a href="<?= Url::to(['cancer-affiliate', 'id' => $model->id]) ?>" data-confirm="Hủy bỏ thay đổi trên?" class="btn btn-warning">Hủy thay đổi</a>
                    </div>
                </div>
                <?php ActiveFormC::end(); ?>
            </div>
        </div>
    </div>
</div>