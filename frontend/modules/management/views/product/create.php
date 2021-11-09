<?php

use yii\helpers\Html;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = Yii::t('app','create_product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','product_management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <div class="ctn-form">
         <?= 
        $this->render('_form', [
            'model' => $model,
            'images' => $images,
            'certificates' => $certificates,
            'certificate_items' => $certificate_items,
            'shop_transports' => $shop_transports
        ]) ?>
        
    </div>
</div>

<script>
    <?php if(isset($alert) && $alert) echo "alert('$alert');"; ?>
    function submit_shop_form() {
        document.getElementById("shop-form").submit();
        return false;
    }
</script>