<?php

use common\components\ClaLid;
use yii\helpers\ArrayHelper;
use common\models\shop\ShopLevel;
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'name_contact')->textInput(['maxlength' => true]) ?>
<script>
    jQuery(document).ready(function() {
        jQuery("#shop-level").select2({
            maximumSelectionLength: 63,
            placeholder: "Chọn các danh hiệu",
            allowClear: true
        });
    });
    jQuery(document).ready(function() {
        jQuery("#shop-type").select2({
            maximumSelectionLength: 63,
            placeholder: "Chọn các loại",
            allowClear: true
        });
    });
</script>
<?= $form->field($model, 'level')
    ->dropDownList(
        ArrayHelper::map(ShopLevel::find()->all(), 'id', 'name'),
        [
            'multiple' => 'multiple'
        ]
    )
?>

<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>


<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'scale')->dropDownList(\common\models\shop\Shop::getScale()) ?>

<?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

<?= $form->field($model, 'type')->dropDownList(\common\models\shop\Shop::getType(), ['multiple' => 'multiple']) ?>

<?= $form->field($model, 'cmt')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'number_auth')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'date_auth')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'address_auth')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'number_paper_auth')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'shop_acount_type')->dropDownList(['' => 'Chọn loại'] + \common\models\shop\Shop::getOptionsTypeAcount()) ?>

<?=
    $form->field($model, 'account_status')->dropDownList([
        ClaLid::STATUS_ACTIVED => Yii::t('app', 'active'),
        ClaLid::STATUS_DEACTIVED => Yii::t('app', 'non_active'),
        ClaLid::STATUS_CRAWLER => Yii::t('app', 'waiting'),
    ])
?>

<?=
    $form->field($model, 'status')->dropDownList([
        ClaLid::STATUS_ACTIVED => Yii::t('app', 'active'),
        ClaLid::STATUS_DEACTIVED => Yii::t('app', 'non_active'),
        ClaLid::STATUS_CRAWLER => Yii::t('app', 'waiting'),
    ])
?>

<?=
    $form->field($model, 'status_discount_code')->dropDownList([
        ClaLid::STATUS_ACTIVED => Yii::t('app', 'active'),
        ClaLid::STATUS_DEACTIVED => Yii::t('app', 'non_active'),
    ])
?>