<?php 
    use yii\helpers\Html;
    use common\components\ClaHost;
?>
<style type="text/css">
    .width-3 input{
        width: 30%;
        float: left;
    }
    .half-input p {
        clear: both;
    }
    .width-3 span{
        display: inline-block;
        padding: 10px;
    }
</style>
<style type="text/css">
    .box-checkbox {
        position: relative;
        clear: both;
        cursor: pointer;
        display: inline-block;
    }
    .box-checkbox::before{
        content: '';
        display: block;
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    .box-checkbox.check .switcherys {
        background-color: rgb(38, 185, 154) !important; 
        border-color: rgb(38, 185, 154); 
        box-shadow: rgb(38, 185, 154) 0px 0px 0px 11px inset !important;  
        transition: border 0.4s, box-shadow 0.4s, background-color 1.2s !important; 
    }
    .box-checkbox.check .switcherys small {
        left: 11px !important;  
        background-color: rgb(255, 255, 255) !important;  
        transition: background-color 0.4s, left 0.2s !important; 
    }
    .box-checkbox .switcherys {
        box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; 
        border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); 
        transition: border 0.4s, box-shadow 0.4s;
    }
    .box-checkbox .switcherys small {
        left: 0px; 
        transition: background-color 0.4s, left 0.2s; 
    }
</style>
<div class="item-input-form">
    <?=
        $form->field($model, 'weight', [
            'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => $model->getAttributeLabel('weight')
        ])->label($model->getAttributeLabel('weight'), [
            'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
        ])  
    ?>
    <div class="group-input">
        <div class="half-input">
            <label class="" for="product-weight"><?= Yii::t('app', 'product_create_2') ?></label>
            <div class="width-3">
                <?=
                    $form->field($model, 'width', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => $model->getAttributeLabel('width')
                    ])->label($model->getAttributeLabel('width'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])  
                ?>

                <?=
                    $form->field($model, 'length', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => $model->getAttributeLabel('length')
                    ])->label($model->getAttributeLabel('length'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])  
                ?>
                <?=
                    $form->field($model, 'height', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => $model->getAttributeLabel('height')
                    ])->label($model->getAttributeLabel('height'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])  
                ?>  
            </div>
            <div class="form-group field-product-height">
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-height"></label>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <p><i><?= Yii::t('app', 'product_create_3') ?></i></p>
                </div>
            </div>
            <label class="bold" for=""><?= Yii::t('app', 'transport_cost') ?> </label>
            <div class="form-group field-product-height">  
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="product-height"></label> 
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <div class="half-input">
                        <div class="info-vanchuyen-setting">
                            <label class="" for="product-weight"></label>
                            <div class="method-transform">
                                <ul>
                                    <?php 
                                        $in = [];
                                        if($product_transports){
                                            foreach ($product_transports as $transport) {  
                                                $in[] = $transport['transport_id']; ?>
                                                <li>
                                                    <div class="col-left">
                                                        <label for=""><?= $transport['name'] ?></label>
                                                    </div>
                                                    <div class="col-center">
                                                        <div class="info">
                                                           <?= $transport['note'] ?> 
                                                        </div>
                                                    </div>
                                                    <div class="col-right">
                                                        <div class="check-active">
                                                            <div class="box-checkbox <?= $transport['default'] ? 'check' : '' ?>"  data-id="<?= $transport['transport_id'] ?>">
                                                                <span class="switchery switcherys" ><small></small></span>
                                                            </div>
                                                            <label for="checkbox-<?= $transport['transport_id'] ?>"></label>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }
                                        } 
                                    ?>
                                    <?php 
                                        if($shop_transports){
                                            foreach ($shop_transports as $transport) 
                                                if(!in_array($transport['transport_id'], $in)) {  
                                                ?>
                                                <li>
                                                    <div class="col-left">
                                                        <label for=""><?= $transport['name'] ?></label>
                                                    </div>
                                                    <div class="col-center">
                                                        <div class="info">
                                                           <?= $transport['note'] ?> 
                                                        </div>
                                                    </div>
                                                    <div class="col-right">
                                                        <div class="check-active">
                                                            <div class="box-checkbox"  data-id="<?= $transport['transport_id'] ?>">
                                                                <span class="switchery switcherys" ><small></small></span>
                                                            </div>
                                                            <label for="checkbox-<?= $transport['transport_id'] ?>"></label>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }
                                        } 
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<script type="text/javascript">
    function changeTransport(_this) {
        var id = _this.attr('data-id');
        var href = "<?= \yii\helpers\Url::to(['/product/product/update-transport', 'status' => ($model->id ? 1 : 2), 'product_id' => ($model->id ? $model->id : 0) ]) ?>";
        jQuery.ajax({
            url: href,
            data:{transport_id : id},
            beforeSend: function () {
            },
            success: function (res) {
            },
            error: function () {
            }
        });
    }
    jQuery(document).on('click', '.box-checkbox', function () {
        if(!$(this).hasClass('check')) {
            <?= $model->isNewRecord ? '' : 'if(confirm("'.Yii::t('app', 'you_sure_change').'")) {' ?>
                $(this).css('display','none');
                setTimeout(function(){ 
                    $('.box-checkbox').css('display','block');
                }, 1000);
                var checkbox = $(this).find('.updateajax').first();
                changeTransport($(this));
                var label = $(this).find('.switchery').first();
                $('.box-checkbox').removeClass('check');
                $(this).addClass('check');
            <?= $model->isNewRecord ? '' : '}' ?>
        }
        return false;
    });
</script>
