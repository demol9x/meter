<?php
\Yii::$app->session->open();
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = Yii::t('app','image_shop');
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    body .ctn-form .item-input-form > label {
        float: left;
        width: 100%;
        padding-bottom: 26px;
    }
    body .boxuploadfile {
        position: unset;
        padding-bottom: 10px;
    }
    body #wrap_image_album {
        margin-left: 0px;
        margin-right: 0%;
    }
    .tools-bottom {
        width: 100%;
    }
    .tools-bottom {
        text-align: center;
        width: 100% !important;
        bottom: 0px !important;
        top: unset !important
    }
    .item-input-form label {
        display: none;
    }
    .tools-bottom {
        right: 0px !important;
    }
    .col-md-55 {
        height: 130px !important;
    }
    
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <div class="ctn-form">
        <?php if(isset($_SESSION['create_shop'])) {?>
            <p><b><?= Yii::t('app', 'guide') ?>:</b> <?= Yii::t('app', 'image_shop_text_1') ?> <a style="color: green" target="_bank" href="<?= Url::to(['/shop/shop/detail', 'id' => $model->id, 'alias' => $model->alias]) ?>"><?= Yii::t('app', 'click_here') ?></a></p>
        <?php } ?>
        <?php $form = ActiveFormC::begin(); ?>
            <?= 
            $this->render('partial/image', [
                'model' => $model,
                'form' => $form,
                'images' => $images
            ]) ?>
            <div class="btn-submit-form">
                <input type="submit" id="shop-form" value="<?= Yii::t('app','save') ?>">
            </div>
        <?php ActiveFormC::end(); ?>
    </div>
    <?php if(isset($_SESSION['create_shop'])) {?>
        <div class="botom-form btn-tool">
            <a href="<?= Url::to(['/management/shop-address/index']) ?>" class="add-info"><?= Yii::t('app', 'add_info') ?></a>
            <a href="<?= Url::to(['/management/shop/remove-new']) ?>" class="end-info"><?= Yii::t('app', 'you_was_know') ?></a>
        </div>
    <?php } ?>
</div>

<script>
    <?php if(isset($alert) && $alert) echo "alert('$alert');"; ?>
    function submit_shop_form() {
        document.getElementById("shop-form").submit();
        return false;
    }
</script>