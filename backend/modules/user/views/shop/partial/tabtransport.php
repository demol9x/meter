<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\shop\ShopSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .method-transform ul li {
        display: flex;
        float: left;
        width: 100%;
        padding: 15px 0px;
        border-top: 1px solid #ebebeb;
        position: relative;
    }
    .method-transform ul li .col-left {
        min-width: 200px;
        float: left;
    }
    .method-transform ul li .col-center {
        width: 100%;
        float: left;
    }
    .method-transform ul li .col-right {
        min-width: 110px;
        text-align: center;
        float: right;
    }
    .method-transform li {
        list-style: none;
        padding: 15px 0px;
        font-size: 14px;
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
        left: 13px !important;  
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

<div class="info-vanchuyen-setting">
    <div class="method-transform">
        <ul>
            <li>
                <div class="col-left">
                    <?= Yii::t('app', 'transport_method') ?>
                </div>
                <div class="col-center">
                </div>
                <div class="col-right">
                    <?= Yii::t('app', 'status') ?>
                </div>
                <div class="col-right">
                    <?= Yii::t('app', 'default') ?>
                </div>
            </li>
           <?php if($shop_transports){
                foreach ($shop_transports as $shop_transport) {  ?>
                    <li>
                        <div class="col-left">
                            <label for=""><?= $shop_transport['name'] ?></label>
                        </div>
                        <div class="col-center">
                            <div class="info">
                               <?= $shop_transport['note'] ?> 
                            </div>
                        </div>
                        <div class="col-right">
                            <div class="check-active check-status">
                                <div class="box-checkbox-st  box-checkbox check"  data-id="<?= $shop_transport['transport_id'] ?>"  data-check="1">
                                    <span class="switchery switcherys" ><small></small></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-right">
                            <div class="check-active check-default">
                                <div class="box-checkbox-df box-checkbox <?= $shop_transport['default'] ? 'check' : '' ?>"  data-id="<?= $shop_transport['transport_id'] ?>">
                                    <span class="switchery switcherys" ><small></small></span>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php }
            } ?>
            <?php 
            $act = array_column($shop_transports, 'transport_id');
            if($transports){
                foreach ($transports as $transport) {  
                    if(!in_array($transport['id'], $act)){
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
                                <div class="check-active check-status">
                                    <div class="box-checkbox-st  box-checkbox"  data-id="<?= $transport['id'] ?>"  data-check="0">
                                        <span class="switchery switcherys" ><small></small></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="check-active check-default">
                                    <div class="box-checkbox-df  box-checkbox"  data-id="<?= $transport['id'] ?>">
                                        <span class="switchery switcherys" ><small></small></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php }
                }
            } ?>
        </ul>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).on('click', '.box-checkbox-df', function () {
        if(!$(this).hasClass('check')) {
            if(confirm("<?= Yii::t('app', 'you_sure_change') ?>")) {
                $(this).css('display','none');
                var checkbox = $(this).find('.updateajax').first();
                changeTransportDefault($(this));
               
            }
        }
        return false;
    });
    jQuery(document).on('click', '.box-checkbox-st', function () {
        if(confirm("<?= Yii::t('app', 'you_sure_change') ?>")) {
            $(this).css('display','none');
            var checkbox = $(this).find('.updateajax').first();
            changeTransportStatus($(this));
        }
        return false;
    });

    function changeTransportDefault(_this){
        var id = _this.attr('data-id');
        var href = "<?= \yii\helpers\Url::to(['/user/shop/update-transport-default', 'default' => 1]) ?>";
        jQuery.ajax({
            url: href,
            data:{id : id, shop_id: <?= $model->id ?>},
            beforeSend: function () {
            },
            success: function (res) {
                var tg = _this.parent().parent().parent().find('.box-checkbox-st').first();
                tg.attr('data-check', '1');
                // console.log(tg.attr('class'));
                tg.addClass('check');
                $('.box-checkbox-df').removeClass('check');
                _this.addClass('check');
                _this.css('display','block');
            },
            error: function () {
            }
        });
    };

    function changeTransportStatus(_this) {
        var id = _this.attr('data-id');
        if(_this.attr('data-check') == '1') {
            var href = "<?= \yii\helpers\Url::to(['/user/shop/update-transport', 'status' => 0]) ?>";
        } else {
            var href = "<?= \yii\helpers\Url::to(['/user/shop/update-transport', 'status' => 1]) ?>";
        }
        jQuery.ajax({
            url: href,
            data:{id : id, shop_id: <?= $model->id ?>},
            beforeSend: function () {
            },
            success: function (res) {
                if(_this.hasClass('check')) {
                    _this.parent().parent().parent().find('.box-checkbox-df').first().removeClass('check');
                    _this.removeClass('check');
                    _this.attr('data-check', '0');
                } else {
                    _this.addClass('check');
                    _this.attr('data-check', '1');
                }
                _this.css('display','block');
            },
            error: function () {
            }
        });
    };
</script>
