<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = Yii::t('app','update').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','product_management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
	.alert {
		color: red;
	}
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= $this->title ?>
        </h2>
        <div class="alert">
        	<?= $model->status == 2 ? 'Tin của quý khách đăng chờ được duyệt. Vui lòng đợi tối đa là 24h.' : '' ?>
        </div>
    </div>
    <div class="ctn-form">
            <?= 
            $this->render('_form', [
                'model' => $model,
                'images' => $images,
                'certificates' => $certificates,
                'certificate_items' => $certificate_items,
                'product_transports' => $product_transports,
                'shop_transports' => $shop_transports,
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