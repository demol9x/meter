<?php
\Yii::$app->session->open();
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\shop\Shop;
$types = Shop::getType();
/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = Yii::t('app','file_shop').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<style type="text/css">
    .alert {
        color: red;
    }
    .nice-select, .nice-select >ul {
        width: 100%;
    }
</style>
<script>
    <?php if(isset($alert) && $alert) echo "alert('$alert');"; ?>
    function submit_shop_form() {
        document.getElementById("shop-form").submit();
        return false;
    }
</script>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= Yii::t('app','file_shop') ?>
        </h2>
        <?php if(isset($_SESSION['create_shop'])) {?>
            <p class="center" style="color: green"><b><?= Yii::t('app', 'guide') ?>:</b> <?= Yii::t('app', 'shop_update_text2_0') ?> <a href="<?= Url::to(['/management/product/index']) ?>"><b><?= Yii::t('app', 'click_here') ?></b></a></p>
        <?php } ?>
        <?= $model->status == 2 ? '<div class="alert">Gian hàng quý khách đăng chờ được duyệt. Vui lòng đợi tối đa là 24h.</div>' : '' ?>
        <?= $model->status == 0 ? '<div class="alert">Gian hàng quý khách đã bị khóa. Vui lòng <a href="'.Url::to(['/site/contact']).'">liên hệ</a> ban quản lý.</div>' : '' ?>
    </div>
    <div class="table-buyer table-shop">
        <table>
            <tbody>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','timing') ?></label>
                    </td>
                    <td>
                        <p><?= (($time = date('Y',time()) - date('Y', $model->created_time)) >= 1) ? $time : Yii::t('app', 'under_1') ?> <?= Yii::t('app', 'year') ?></p>
                    </td>
                    <td width="170" class="txt-right">
                        
                    </td>
                </tr>
                <tr>
                    <td width="230">
                        <label for=""><?= Yii::t('app','product') ?></label>
                    </td>
                    <td>
                        <p><?= $sum_product ?></p>
                    </td>
                    <td width="170" class="txt-right">
                        <a href="<?= Url::to(['/management/product/index']) ?>" class="view-more"><?= Yii::t('app','view_all') ?></a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','rate') ?></label>
                    </td>
                    <td>
                        <p> <?= $model->rate ? $model->rate.'('.$model->rate_count.' '.Yii::t('app','rate_count').')' : Yii::t('app','havent') ?></p>
                    </td>
                    <td width="170" class="txt-right">
                        <?php if($model->rate) {?>
                            <a href="<?= Url::to(['/management/shop/rate']) ?>" class="view-more"><?= Yii::t('app','view_all') ?></a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','shop_scale') ?></label>
                    </td>
                    <td>
                        <p><?= $model->scale ?></p>
                        <div class="form-fixed" id ="shopscale">
                            <?php $scales = \common\models\shop\Shop::getScale(); ?>
                            <select class="input_text" name="scale">
                                <?php foreach ($scales as $id => $value) { ?>
                                    <option value="<?= $id ?>"><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#shopscale" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','shop_name') ?></label>
                    </td>
                    <td>
                        <p><?= $model->name ?></p>
                        <div class="form-fixed"  id ="shopname">
                            <input class="input_text" name="name" type="text" placeholder="<?= Yii::t('app','enter_new_name') ?>">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#shopname" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','shop_type') ?></label>
                    </td>
                    <td>
                        <p><?= Shop::getType($model->type) ?></p>
                        <div class="form-fixed" id ="shoptype">
                            <select class="input_text" name="type">
                                <?php if($types) foreach ($types as $key => $value) { ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                       <!--  <a data="#shoptype" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div> -->
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','email') ?></label>
                    </td>
                    <td>
                        <p><?= $model->email ?></p>
                        <div class="form-fixed" id="shopemail">
                            <input type="text" class="input_text" name="email" placeholder="<?= Yii::t('app','enter_new_email') ?>">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#shopemail" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','phone') ?></label>
                    </td>
                    <td>
                        <p>
                            <?= formatPhone($model->phone) ?>
                            <?php if($model->phone_add) {
                                $phones = explode(',', $model->phone_add);
                                foreach ($phones as $phone) {
                                    ?>
                                    ,<?= formatPhone($phone) ?>
                                <?php }
                            } ?>    
                        </p>
                    </td>
                    <td width="170" class="txt-right">
                        <a href="<?= Url::to(['/management/shop-address/index']) ?>" class="view-more"><?= Yii::t('app','update') ?></a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','website') ?></label>
                    </td>
                    <td>
                        <p><?= $model->website ?></p>
                        <div class="form-fixed" id="shopwebsite">
                            <input type="text" class="input_text" name="website" placeholder="<?= Yii::t('app','enter_new_website') ?>">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#shopwebsite" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','facebook') ?></label>
                    </td>
                    <td>
                        <p><?= $model->facebook ?></p>
                        <div class="form-fixed" id="shopfacebook">
                            <input type="text" class="input_text" name="facebook" placeholder="<?= Yii::t('app','enter_new_facebook') ?>">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#shopfacebook" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','zalo') ?></label>
                    </td>
                    <td>
                        <p><?= $model->zalo ?></p>
                        <div class="form-fixed" id="shopzalo">
                            <input type="text" class="input_text" name="zalo" placeholder="<?= Yii::t('app','enter_new_zalo') ?>">
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#shopzalo" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for=""><?= Yii::t('app','shop_description') ?></label>
                    </td>
                    <td>
                        <p><?= $model->description ?></p>
                        <div class="form-fixed" id="shopdescription">
                            <textarea name="description" class="input_text" cols="30" rows="10"></textarea>
                        </div>
                    </td>
                    <td width="170" class="txt-right">
                        <a data="#shopdescription" class="open-fixed"><i class="fa fa-pencil"></i><?= Yii::t('app','change') ?></a>
                        <div class="form-fixed">
                            <a class="save-shop"><i class="fa fa-check"></i><?= Yii::t('app','save') ?></a>
                            <a class="cance" href="javascript:void(0);"><i class="fa fa-times"></i><?= Yii::t('app','cancer') ?></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
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
            confirmCS('<?= Yii::t('app', 'Bạn có chắc muốn thay đổi?') ?>', {});
            yesConFirm =  function(option) {
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
                            case 'type':
                                label.html($('#shoptype').find('select option:selected').text());
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
                        alert('<?= Yii::t('app', 'please_enter_real') ?>');
                    }
                }).fail(function (jqxhr, textStatus, error) {
                    alert('<?= Yii::t('app', 'please_enter_real') ?>');
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