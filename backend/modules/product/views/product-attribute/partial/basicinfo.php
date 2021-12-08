<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/28/2021
 * Time: 7:51 PM
 */
?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'type')->dropDownList(\common\models\product\ProductAttribute::getType(),['prompt' => 'Chọn loại thuộc tính']) ?>

<?= $form->field($model, 'display_type')->dropDownList(\common\models\product\ProductAttribute::getDisplayType(),['prompt' => 'Chọn kiểu hiển thị']) ?>
