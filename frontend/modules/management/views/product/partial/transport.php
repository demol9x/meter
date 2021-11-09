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
    li.disable {
        position: relative;
    }
    li.disable::before {
        content: '';
        position: absolute;
        display: block;
        width: 100%;
        height: 100%;
        opacity: 0.6;
        z-index: 1;
        background: #fff;
        top: 0px;
        left: 0px;
    }
</style>

<div class="item-input-form">
    <label class="bold" for=""><?= Yii::t('app', 'transport') ?></label>
    <div class="group-input">
        <?= $form->fields($model, 'weight', ['class'=> ''])->textInput(['class'=> 'form-control chang-transports', 'type' => 'number']) ?>
        <div class="half-input">
            <label class="" for="product-weight"><?= Yii::t('app', 'product_create_2') ?></label>
            <div class="width-3">
                <input type="number" placeholder="R" id="product-width" class="form-control chang-transports" name="Product[width]" value="<?= $model->width ?>">
                <input type="number" placeholder="D" id="product-length" class="form-control chang-transports" name="Product[length]" value="<?= $model->length ?>">
                <input type="number" placeholder="C" id="product-height" class="form-control chang-transports" name="Product[height]" value="<?= $model->height ?>"> <span>cm</span>
            </div>
            <p><i><?= Yii::t('app', 'product_create_3') ?></i></p>
        </div>
         <div class="half-input">
            <div class="info-vanchuyen-setting">
                <label class="" for="product-weight"><?= Yii::t('app', 'transport_cost') ?></label>
                <br/>
                <span class="red"><i><?= Yii::t('app', 'transport_cost_1') ?></i></span>
                <div class="method-transform">
                    <ul>
                        <?php 
                            $in = [];
                            if($product_transports){
                                foreach ($product_transports as $transport) {  
                                    $in[] = $transport['transport_id']; ?>
                                    <li class="<?= ($transport['transport_id'] != 0) ? 'check-transport' : '' ?>">
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
                                                <input type="checkbox" <?= $transport['default'] ? 'checked' : '' ?> class="ios8-switch ios8-switch-small change-bg save-sts" data-id="<?= $transport['transport_id'] ?>" data-check="<?= $transport['default'] ? 1 : 0 ?>" id="checkbox-<?= $transport['transport_id'] ?>">
                                                <label for="checkbox-<?= $transport['transport_id'] ?>"></label>
                                            </div>
                                        </div>
                                    </li>
                                <?php }
                            } 
                        ?>
                        <?php 
                            if($shop_transports){
                                $check = ($model->width && $model->height && $model->length) ? 0 : 1;
                                foreach ($shop_transports as $transport) 
                                    if(!in_array($transport['transport_id'], $in)) {  
                                    ?>
                                    <li class="<?= ($transport['transport_id'] != 0 && $check) ? 'check-transport disable' : '' ?>">
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
                                                <input type="checkbox" class="ios8-switch ios8-switch-small change-bg save-sts" data-id="<?= $transport['transport_id'] ?>" data-check="0" id="checkbox-<?= $transport['transport_id'] ?>">
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
<script type="text/javascript">
    jQuery(document).on('click', '.save-sts', function () {
        $('.save-sts').prop('checked', false);
        $('.save-sts').attr('data-check', 0);
        $(this).prop('checked', true);
        $(this).checked;
        var _this = $(this);
        _this.parent().css('display', 'none');
        var id = _this.attr('data-id');
        if(_this.attr('data-check') == '1') {
            var href = "<?= \yii\helpers\Url::to(['/management/product-transport/update', 'status' => 0, 'product_id' => ($model->id ? $model->id : 0) ]) ?>";
        } else {
            var href = "<?= \yii\helpers\Url::to(['/management/product-transport/update', 'status' => ($model->id ? 1 : 2), 'product_id' => ($model->id ? $model->id : 0) ]) ?>";
        }
        jQuery.ajax({
            url: href,
            data:{transport_id : id},
            beforeSend: function () {
            },
            success: function (res) {
                if(_this.attr('data-check') == '1') {
                    _this.attr('data-check', '0');
                } else {
                    _this.attr('data-check', '1');
                }
                _this.parent().css('display', 'inline-block');
            },
            error: function () {
            }
        });
    });
    $(document).ready(function () {
        $('.chang-transports').change(function () {
            var tgt = $('.chang-transports');
            for (var i = 0; i < tgt.length; i++) {
                if($(tgt[i]).val() == '') {
                    $('.check-transport').addClass('disable');
                    return false;
                }
            }
            $('.check-transport').removeClass('disable');
            return true;
        });
    });
    
</script>
