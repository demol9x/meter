<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
    .method-transform ul li .col-center {
        display: none;
    }
    .interview {
        width: unset !important;
        height: 45px !important;
        padding: 6px 33px !important;
        display: inline-block !important;
        float: right;
        margin-right: 20px;
    }
    .box-crops .in-flex {
        height: 60% !important;
    }
    body .croppie-container {
        height: 85%;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').append('<div class="box-crops"> <div class="flex"> <div class="in-flex" id="box-crops-in-flex"> <div class="close-box-crops">x</div> <div id="box-inner-croppie"> </div> </div> </div>');
        
    });
    $(document).on( "click", ".close-box-crops", function() {
            $('.box-crops').css('left', '-100%');
            $('body').css('overflow', 'auto');
    });
</script>
<?php $form = ActiveFormC::begin(); ?>
    <?=  
        $this->render('partial/tabbasicinfo', [
            'model' => $model,
            'form' => $form,
        ]) 
    ?>
    <?=  
        $this->render('partial/tabtypeproduct', [
            'model' => $model,
            'form' => $form,
        ]) 
    ?>
    <?=  
        $this->render('partial/fee', [
            'model' => $model,
            'form' => $form,
        ]) 
    ?>
    <?php  
        if(isset($shop_transports) && $shop_transports) {
            echo $this->render('partial/transport', [
                    'model' => $model,
                    'form' => $form,
                    'shop_transports' => $shop_transports,
                    'product_transports' => isset($product_transports) ? $product_transports : '',
                ]);
            } else {  ?>
            <div class="item-input-form">
                <label class="bold" for=""><?= Yii::t('app', 'transport') ?></label>
                <div class="group-input">
                    <p>
                        <?= Yii::t('app', 'create_product_1') ?>
                        <a href="<?= Url::to(['/management/shop-transport/index']) ?>"><b><?= Yii::t('app', 'click_here') ?></b></a>
                    </p>
                </div>
            </div>
    <?php } ?>
    <?=  
        $this->render('partial/image', [
            'model' => $model,
            'form' => $form,
            'images' => $images
        ])
    ?>

    <?= 
        $this->render('partial/certificate', [
            'model' => $model,
            'form' => $form,
            'certificates' => $certificates,
            'certificate_items' => $certificate_items
        ]) 
    ?>
    <div class="btn-submit-form">
        <p class="skip"><?= Yii::t('app', 'text_fp_1') ?></p>
        <button id="shop-form"><?= ($model->isNewRecord) ?  Yii::t('app','create_product') :  Yii::t('app','update_product') ?></button>
        <!-- <a onclick="reviews()" class="interview"><?= Yii::t('app', 'preview') ?></a> -->
    </div>
<?php ActiveFormC::end(); ?>

<script type="text/javascript">
$(document).on( "keydown", ".change-price-s", function() {
    $(this).addClass("change-price-sactive");
    setTimeout(function(){
        var tg =$(".change-price-sactive");
        tg.val(tg.val().replace(/\./g, ""));
        tg.val(formatMoney(tg.val(),0, ',', '.'));
        tg.removeClass('change-price-sactive');
    }, 150);
});
</script>
<script type="text/javascript">
    function checkall(){
        if($('#product-name').val() && $('#category_id').val() && $('#product-description').val()) {
            return false;
        } else {
            return true;
        }
    }
    function reviews(){
        if(checksave()) {
            return false;
        }
        prev = window.open();
        if($("#product-price").val()) {
            $("#product-price").val($("#product-price").val().replace(/\./g, ""));
        } 
        // $("#Product_price_market").val($("#Product_price_market").val().replace(/\./g, ""));
        var data = jQuery('#w0').serialize();
        jQuery.ajax({
                type: 'post',
                url: '<?= Url::to(['/management/product/review']).(isset($_GET['id']) ? '?id='.$_GET['id'] : ''); ?>',
                data: data,
                success: function (res) {
                    prev.window.document.write(res);
                    prev.window.document.close();
                },
        });
    }
    function checkimg() {
        var imgs =$('.col-md-55');
        if(imgs.length < 1) {
            $('.alert-imgs').html('<?= Yii::t('app', 'alert_fp_1') ?>');
            return true;
        } else {
            $('.alert-imgs').html('');
        }
        return false;
    }
    function checksave() {
        if(checkall()){
            $('#w0').submit();
            return true;
        }
        if((($('.price-range-input').last().val() =='' || $('.price-range-input').last().val() == '0')) && parseInt($('.quality-range-input').first().val()) >0) {
            alert('<?= Yii::t('app', 'warning_price_1') ?>');
            $('.price-range-input').last().css('border','1px solid red')
            return true;
        }
        if((($('.quality-range-input').last().val() =='' || $('.quality-range-input').last().val() == '0')) && parseInt($('.price-range-input').first().val()) >0) {
            alert('<?= Yii::t('app', 'warning_price_2') ?>');
            $('.quality-range-input').last().css('border','1px solid red')
            return true;
        }
        if(checkrange()) {
            return true;
        }
        if(checkimg()) {
            return true;
        }
        return false;
    }
    $('#shop-form').click(function () {
        if(checksave()) return false;
    });
</script>