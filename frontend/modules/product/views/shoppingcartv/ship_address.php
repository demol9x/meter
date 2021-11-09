<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="shopping-cart-page">
    <section id="address-ship" class="address-ship">
        <div class="container">
            <div class="box-shadow-payment">
                <div class="address-ship-content">
                    <h2><?= Yii::t('app', 'ship_address') ?></h2>
                    <?php if ($addresses) { ?>
                        <p>
                            <?= Yii::t('app', 'ship_address_1') ?>
                        </p>
                        <p>
                            <?= Yii::t('app', 'ship_address_2') ?> <a href="#add-address-other" class="open-popup-link"><?= Yii::t('app', 'add_new_address') ?></a>
                        </p>
                    <?php } else { ?>
                        <p>
                            <?= Yii::t('app', 'ship_address_3') ?>
                        </p>
                        <p>
                            <a href="#add-address-other" class="open-popup-link"><?= Yii::t('app', 'add_new_address') ?></a>
                        </p>
                    <?php } ?>
                    <?php foreach ($addresses as $address) { ?>
                        <div class="box-address-ship">
                            <p>
                                <b><?= Yii::t('app', 'full_name') ?>:</b> <?= $address['name_contact'] ?>
                            </p>
                            <p>
                                <b><?= Yii::t('app', 'phone') ?>:</b> <?= $address['phone'] ?>
                            </p>
                            <p>
                                <b><?= Yii::t('app', 'address') ?>:</b> <?= $address['address'] . ' (' . join(', ', [$address['ward_name'], $address['district_name'], $address['province_name']]) . ')' ?>
                            </p>
                            <?php if ($address['isdefault']) { ?>
                                <p>
                                    <a href=""><i class="fa fa-check"></i><?= Yii::t('app', 'ship_address_4') ?></a>
                                </p>

                                <div class="btn-tool">
                                    <a href="<?= Url::to(['/product/shoppingcartv/index']) ?>" class="btn-style-2"><?= Yii::t('app', 'ship_address_5') ?></a>
                                </div>
                            <?php } else { ?>
                                <div class="btn-tool">
                                    <a onclick="chooseAddressReceive(<?= $address['id'] ?>)" href="javascript:void(0)" class="btn-style-2"><?= Yii::t('app', 'ship_address_5') ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    function chooseAddressReceive(address_id) {
        $.getJSON(
                '<?= Url::to(['/product/shoppingcart/add-address-receive']) ?>',
                {address_id: address_id},
                function (data) {
                    if (data.message == 'success') {
                        location.href = '<?= Url::to(['/product/shoppingcartv/index']) ?>';
                    }
                }
        );
    }
</script>
<div id="add-address-other" class="white-popup mfp-hide">
    <div class="box-account">
        <span class="mfp-close"></span>
        <div class="bg-pop-white">
            <div class="form-create-store">
                <div class="title-form">
                    <h2>
                        <img src="<?= Url::home() ?>images/ico-bansanpham.png" alt=""> <?= Yii::t('app', 'ship_address_6') ?>
                    </h2>
                </div>
                <?php $form = ActiveForm::begin() ?>
                <div class="ctn-form">
                    <?=
                    $form->field($model, 'name_contact', [
                        'template' => '<div class="item-input-form"><div class="group-input"><div class="full-input">{label}{input}{hint}{error}</div></div></div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'full_name')
                    ])->label($model->getAttributeLabel('name_contact'), [
                        'class' => ''
                    ])
                    ?>
                    <?=
                    $form->field($model, 'phone', [
                        'template' => '<div class="item-input-form"><div class="group-input"><div class="full-input">{label}{input}{hint}{error}</div></div></div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'phone')
                    ])->label($model->getAttributeLabel('phone'), [
                        'class' => ''
                    ])
                    ?>
                    <?=
                    $form->field($model, 'email', [
                        'template' => '<div class="item-input-form"><div class="group-input"><div class="full-input">{label}{input}{hint}{error}</div></div></div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'email')
                    ])->label($model->getAttributeLabel('email'), [
                        'class' => ''
                    ])
                    ?>
                    <?=
                    $form->field($model, 'province_id', [
                        'template' => '<div class="item-input-form"><div class="group-input"><div class="full-input">{label}{input}{hint}{error}</div></div></div>'
                    ])->dropDownList($listProvince, [
                        'class' => 'form-control select-province-id',
                    ])->label($model->getAttributeLabel('province_id'), [
                        'class' => ''
                    ])
                    ?>
                    <?=
                    $form->field($model, 'district_id', [
                        'template' => '<div class="item-input-form"><div class="group-input"><div class="full-input">{label}{input}{hint}{error}</div></div></div>'
                    ])->dropDownList($listDistrict, [
                        'class' => 'form-control select-district-id',
                        'onclick' => 'getWard(this)'
                    ])->label($model->getAttributeLabel('district_id'), [
                        'class' => ''
                    ])
                    ?>
                    <?=
                    $form->field($model, 'ward_id', [
                        'template' => '<div class="item-input-form"><div class="group-input"><div class="full-input">{label}{input}{hint}{error}</div></div></div>'
                    ])->dropDownList($listWard, [
                        'class' => 'form-control select-ward-id',
                    ])->label($model->getAttributeLabel('ward_id'), [
                        'class' => ''
                    ])
                    ?>
                    <?=
                    $form->field($model, 'address', [
                        'template' => '<div class="item-input-form"><div class="group-input"><div class="full-input">{label}{input}{hint}{error}</div></div></div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'address')
                    ])->label($model->getAttributeLabel('address'), [
                        'class' => ''
                    ])
                    ?>
                    <div class="item-input-form">
                        <div class="group-input">
                            <div class="full-input">
                                <div class="btn-tool">
                                    <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn-style-2']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.select-province-id').change(function () {
            var province_id = $(this).val();
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/suggest/getdistrict']) ?>",
                    {province_id: province_id, label: '<?= Yii::t('app', 'district') ?>'}
            ).done(function (data) {
                $('.select-district-id').html(data.html);
                $('.select-ward-id').html('<option>Phường/xã</option>');
                $('select').niceSelect('update');
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        });

        $('.select-district-id').change(function () {
            var district_id = $(this).val();
            $.getJSON(
                    "<?= \yii\helpers\Url::to(['/suggest/getward']) ?>",
                    {district_id: district_id, label: '<?= Yii::t('app', 'ward') ?>'}
            ).done(function (data) {
                $('.select-ward-id').html(data.html);
                $('select').niceSelect('update');
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            });
        });
    });
</script>