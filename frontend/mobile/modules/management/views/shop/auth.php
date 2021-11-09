<?php
\Yii::$app->session->open();
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\shop\Shop;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = Yii::t('app','file_shop').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<script>
    <?php if(isset($alert) && $alert) echo "alert('$alert');"; ?>
    function submit_shop_form() {
        document.getElementById("shop-form").submit();
        return false;
    }
</script>
<div class="form-create-store">
    <?php if(isset($_SESSION['create_shop'])) { ?>
        <div class="title-form">
            <h2>
                <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> 
                <?=  Yii::t('app', 'create_shop')  ?>
            </h2>
        </div>
        <div class="list-process-payment" style="border-bottom: none;">
            <ul>
                <li class="active">
                    <a>
                        <img src="<?= Yii::$app->homeUrl ?>images/process-1.png" alt="">
                        <span><?=  Yii::t('app', 'signup_user')  ?></span>
                    </a>
                </li>
                <li class="active">
                    <a>
                        <img src="<?= Yii::$app->homeUrl ?>images/process-2.png" alt="">
                        <span><?=  Yii::t('app', 'enter_info')  ?></span>
                    </a>
                </li>
                <li class="active current">
                    <a>
                        <img src="<?= Yii::$app->homeUrl ?>images/process-3.png" alt="">
                        <span><?=  Yii::t('app', 'enter_auth')  ?></span>
                    </a>
                </li>
            </ul>
        </div>
    <?php } else { ?>
        <div class="title-form">
            <h2>
                <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= Yii::t('app','shop_auth') ?>
            </h2>
        </div>
    <?php } ?>
    <p class="center" style="color: green"><b><?= Yii::t('app', 'note') ?>:</b> <?= Yii::t('app', 'auth_text_1') ?></p>
    <div class="table-buyer table-shop">
        <table>
            <tbody>
                <tr>
                    <td class="td-label">
                        <label for=""><?= Yii::t('app','cmt') ?></label>
                    </td>
                    <td>
                        <p><?= $model->cmt ?></p>
                        <div class="form-fixed"  id ="cmt">
                            <input class="input_text" maxlength="20"  name="cmt" type="text" placeholder="">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#cmt" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-label">
                        <label for=""><?= Yii::t('app','number_auth') ?></label>
                    </td>
                    <td>
                        <p><?= $model->number_auth ?></p>
                        <div class="form-fixed"  id ="numberauth">
                            <input class="input_text" name="number_auth" type="number" placeholder="">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#numberauth" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-label">
                        <label for=""><?= Yii::t('app','number_paper_auth') ?></label>
                    </td>
                    <td>
                        <p><?= $model->number_paper_auth ?></p>
                        <div class="form-fixed"  id ="numberpaperauth">
                            <input class="input_text" name="number_paper_auth" placeholder="">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#numberpaperauth" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-label">
                        <label for=""><?= Yii::t('app','address_auth') ?></label>
                    </td>
                    <td>
                        <p><?= $model->address_auth ?></p>
                        <div class="form-fixed"  id ="address_auth">
                            <input class="input_text" name="address_auth" type="text" placeholder="">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#address_auth" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-label">
                        <label for=""><?= Yii::t('app','date_auth') ?></label>
                    </td>
                    <td>
                        <p><?= $model->date_auth ?></p>
                        <div class="form-fixed"  id ="date_auth">
                            <input class="input_text" name="date_auth" type="text" placeholder="">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#date_auth" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-label" style=" min-width: 100px;">
                        <label style="white-space: unset; padding-right: 10px;" for=""><?= Yii::t('app','up_cmt') ?></label>
                    </td>
                    <td colspan="2">
                        <?php 
                            $form = ActiveFormC::begin();
                        ?>
                        <input type="submit" id="shop-form" value="<?= Yii::t('app','save') ?>">
                        <?= 
                        $this->render('partial/image', [
                            'model' => $model,
                            'form' => $form,
                            'images' => $images,
                        ]) ?>
                        <?php ActiveFormC::end(); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php if(isset($_SESSION['create_shop'])) {?>
        <div class="botom-form btn-tool">
            <a href="<?= Url::to(['/management/shop-transport/index']) ?>" class="add-info"><?= Yii::t('app', 'add_info') ?></a>
            <a href="<?= Url::to(['/management/shop/remove-new']) ?>" class="end-info"><?= Yii::t('app', 'you_was_know') ?></a>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.open-fixed').click(function() {
            $('tr').removeClass('open');
            var id = $(this).attr('data');
            $('.input_text').attr('id' , '');
            $(id).children('.input_text').attr('id', 'input-send');
        });
        $('.save-shop').click(function() {
            if (confirm('Bạn có chắc muốn thay đổi?')) {
                var attr = $('#input-send').attr('name');
                var value = $('#input-send').val();
                $.getJSON(
                        "<?= \yii\helpers\Url::to(['/management/shop/update-ajax']) ?>",
                        {attr: attr, value: value}
                ).done(function (data) {
                    var label = $('#input-send').parent().parent().children('p');
                    if(data == '1') {
                        switch(attr) {
                            case 'birthday':
                                label.html($('#birthday-day').val()+'/'+$('#birthday-month').val()+'/'+$('#birthday-year').val());
                                break;
                            case 'sex':
                                if(value =='1') {
                                    label.html('<?= Yii::t('app', 'man') ?>');
                                } else {
                                    label.html('<?= Yii::t('app', 'woman') ?>');
                                }
                                break;
                            default:
                                label.html(value);
                        }
                    } else {
                        alert('<?= Yii::t('app', 'please_enter_real') ?>')
                    }
                }).fail(function (jqxhr, textStatus, error) {
                    alert('<?= Yii::t('app', 'please_enter_real') ?>')
                });
            }
        });
        $('.save-shop-b').click(function() {
            var tg = $('#birthday-month').val()+'/'+$('#birthday-day').val()+'/'+$('#birthday-year').val();
            var tg = $('#input-send').val(tg);
            $('.save-shop').first().click();
        });
        $('.radio-change').click(function() {
            $('#input-send').val($(this).val());
        });
    });
</script>
<style type="text/css">
    .alert {
        color: red;
    }
    .boxuploadfile {
        /*margin: -30px 0px 11px 115px;*/
        margin-bottom: 10px;
    }
    body .boxuploadfile > span {
        display: inline-block !important;
    }
    #shop-form {
        float: right;
        background: #17a349;
        color: #fff;
        padding: 5px 17px;
        border: 0px;
        border-radius: 5px;
    }
    .tools-bottom {
        text-align: center;
    }
    .td-label{
        max-width: 60px;
    }
    .item-input-form label {
        display: none;
    }
</style>