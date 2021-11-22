<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo Yii::$app->homeUrl ?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    <?php if($model->ckedit_desc) { ?>
        jQuery(document).ready(function () {
            CKEDITOR.replace("product-description", {
                height: 400,
                language: '<?php echo Yii::$app->language ?>'
            });
        });
    <?php } ?>
    jQuery(document).ready(function () {
            $('#product-ckedit_desc').on("click", function () {
                if (this.checked) {
                    CKEDITOR.replace("product-description", {
                        height: 400,
                        language: '<?php echo Yii::$app->language ?>'
                    });
                } else {
                    var a = CKEDITOR.instances['product-description'];
                    if (a) {
                        a.destroy(true);
                    }

                }
            });
        });

    function formatMoney(a,c, d, t){
        var n = a, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
</script>
<style>
    .form-group {
        margin-bottom: 10px !important;
    }
</style>
<div class="product-form">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'product-form',
                        'options' => [
                            'class' => 'form-horizontal'
                        ]
            ]);
            ?>
            <?= $this->render('partials/basicinfo_update', ['form' => $form, 'model' => $model,'provinces' => $provinces,'district' => $district,'wards' => $wards,]); ?>
            <?= $this->render('partials/image', ['form' => $form, 'model' => $model, 'images' => $images]); ?>
            <?= $this->render('partials/contact', ['form' => $form, 'model' => $model]); ?>
            <div class="form-group" style="margin: 0 0 15px 0px !important;">
                <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','style' => 'width:100%']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('button').click(function() {
               if((($('.price-range-input').last().val() =='' || $('.price-range-input').last().val() == '0')) && parseInt($('.quality-range-input').first().val()) >0) {
                alert('<?= Yii::t('app', 'warning_price_1') ?>');
                $('.price-range-input').last().css('border','1px solid red')
                return false;
            }
            if((($('.quality-range-input').last().val() =='' || $('.quality-range-input').last().val() == '0')) && parseInt($('.price-range-input').first().val()) >0) {
                alert('<?= Yii::t('app', 'warning_price_2') ?>');
                $('.quality-range-input').last().css('border','1px solid red')
                return false;
            }
            if(checkrange()) {
                return false;
            }
        });
    });
    function loadTranport(bool=0) {
        var shop_id = $('#product-shop_id').val();
        var check = $('#thre-tab-3').attr('data');
        // alert(shop_id+'-'+check+'-'+bool);
        if(shop_id != '' && (shop_id !=check || bool == 1)) {
            $('#tab_content3').html('<?= Yii::t('app', 'loading') ?>');
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/product/product/load-transport']) ?>",
                    {shop_id: shop_id}
            ).done(function (data) {
                $('#tab_content3').html(data.html);
                $('#two-tab-3').attr('data', shop_id);
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switchs'));
                    elems.forEach(function (html) {
                        var switchery = new Switchery(html, {
                            color: '#26B99A'
                        });
                    });
                // $('.select-ward-id').html('<option>Phường/xã</option>');
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        }
        // $('#tab_content5').val('');
    }
</script>
