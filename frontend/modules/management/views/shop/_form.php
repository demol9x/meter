<?php

use yii\helpers\Html;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .tools-bottom a {
        display: block;
        text-align: center;
    }
    .select2-search input {
        border: 0px !important;
    }
    .select2 ul {
        height: 45px;
        padding: 8px 7px !important;
    }
    
</style>
<script type="text/javascript">
    var baseUrl = '<?php echo Yii::$app->homeUrl ?>';
</script>
<link href="<?= Yii::$app->homeUrl ?>gentelella/select2/dist/css/select2.min.css" rel="stylesheet">
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>gentelella/select2/dist/js/select2.full.min.js"></script>
<!-- <script src="<?php echo Yii::$app->homeUrl ?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        CKEDITOR.replace("shop-description", {
            height: 400,
            language: '<?php echo Yii::$app->language ?>'
        });
    });
</script> -->
<?php $form = ActiveFormC::begin(); ?>
    <?= 
    $this->render('partial/tabbasicinfo', [
        'model' => $model,
        'form' => $form,
        'list_district' => $list_district,
        'list_ward' => $list_ward,
        'list_province' => $list_province,
        'user' => $user
    ]) ?>
    <!-- <?= 
    $this->render('partial/image', [
        'model' => $model,
        'form' => $form,
        'images' => $images
    ]) ?> -->
    
    <div class="btn-submit-form">
        <input type="submit" id="shop-form" value="<?= ($model->isNewRecord) ?  Yii::t('app','create_shop') :  Yii::t('app','update_shop') ?>">
    </div>
<?php ActiveFormC::end(); ?>
