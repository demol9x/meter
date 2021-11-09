<?php
\Yii::$app->session->open();
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\shop\ShopSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .col-center {
        display: none;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>/images/ico-vanchuyen.png" alt=""> 
            <?= Yii::t('app', 'transport') ?>
        </h2>
    </div>
    <div class="info-vanchuyen-setting">
        <h2><?= Yii::t('app', 'transport_text_1') ?></h2>
        <p>
            <?= Yii::t('app', 'transport_text_2') ?>
        </p>
        <?php if(isset($_SESSION['create_shop'])) {?>
            <p style="color: green"><b><?= Yii::t('app', 'guide') ?>:</b> <?= Yii::t('app', 'transport_text2_0') ?></p>
        <?php } ?>
        <div class="method-transform">
            <ul>
                <li>
                    <div class="col-left">
                        <?= Yii::t('app', 'transport_method') ?>
                    </div>
                    <div class="col-center">
                    </div>
                    <div class="col-right">
                        <?= Yii::t('app', 'default') ?>
                    </div>
                    <div class="col-right">
                        <?= Yii::t('app', 'status') ?>
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
                                <div class="check-active">
                                    <input <?= $shop_transport['default'] ? 'checked' : '' ?> type="checkbox" class="ios8-switch ios8-switch-small change-bg save-defaut" data-check="<?= $shop_transport['default'] ? '0' : '1' ?>" data-id="<?= $shop_transport['transport_id'] ?>" id="checkbox-df-<?= $shop_transport['transport_id'] ?>">
                                    <label for="checkbox-df-<?= $shop_transport['transport_id'] ?>"></label>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="check-active">
                                    <input checked type="checkbox" class="ios8-switch ios8-switch-small change-bg save-sts" data-check="1" data-id="<?= $shop_transport['transport_id'] ?>" id="checkbox-<?= $shop_transport['transport_id'] ?>">
                                    <label for="checkbox-<?= $shop_transport['transport_id'] ?>"></label>
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
                                    <div class="check-active">
                                        <input  type="checkbox" class="ios8-switch ios8-switch-small change-bg save-defaut" data-check="1" data-id="<?= $transport['id'] ?>" id="checkbox-df-<?= $transport['id'] ?>">
                                        <label for="checkbox-df-<?= $transport['id'] ?>"></label>
                                    </div>
                                </div>
                                <div class="col-right">
                                    <div class="check-active">
                                        <input type="checkbox" class="ios8-switch ios8-switch-small change-bg save-sts" data-id="<?= $transport['id'] ?>" data-check="0" id="checkbox-<?= $transport['id'] ?>">
                                        <label for="checkbox-<?= $transport['id'] ?>"></label>
                                    </div>
                                </div>
                            </li>
                        <?php }
                    }
                } ?>
            </ul>
        </div>
    </div>
    <?php if(isset($_SESSION['create_shop'])) {?>
        <div class="botom-form btn-tool">
            <a href="<?= Url::to(['/management/shop/image']) ?>" class="add-info"><?= Yii::t('app', 'add_info') ?></a>
            <a href="<?= Url::to(['/management/shop/remove-new']) ?>" class="end-info"><?= Yii::t('app', 'you_was_know') ?></a>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    jQuery(document).on('click', '.save-sts', function () {
        var _this = $(this);
        _this.parent().css('display', 'none');
        var id = _this.attr('data-id');
        if(_this.attr('data-check') == '1') {
            var href = "<?= \yii\helpers\Url::to(['/management/shop-transport/update', 'status' => 0]) ?>";
            $('#checkbox-df-'+id).prop('checked', false);
        } else {
            var href = "<?= \yii\helpers\Url::to(['/management/shop-transport/update', 'status' => 1]) ?>";
        }
        jQuery.ajax({
            url: href,
            data:{id : id},
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

    jQuery(document).on('click', '.save-defaut', function () {
        var _this = $(this);
        _this.parent().css('display', 'none');
        var id = _this.attr('data-id');

        $('.save-defaut').prop('checked', false);
        $('.save-defaut').attr('data-check', '0');
        _this.prop('checked', true);
        _this.checked;

        $('#checkbox-'+id).prop('checked', true);
        $('#checkbox-'+id).checked;
        $('#checkbox-'+id).attr('data-check', '1');

        if(_this.attr('data-check') == '1') {
            _this.parent().css('display', 'inline-block');
            return false;
        } else {
            var href = "<?= \yii\helpers\Url::to(['/management/shop-transport/update-default', 'default' => 1]) ?>";
        }
        jQuery.ajax({
            url: href,
            data:{id : id},
            beforeSend: function () {
            },
            success: function (res) {
                _this.attr('data-check', '1');
                _this.parent().css('display', 'inline-block');
            },
            error: function () {
            }
        });
    });
</script>
