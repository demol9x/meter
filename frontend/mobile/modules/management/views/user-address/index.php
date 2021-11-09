<?php  
    use yii\helpers\Url;
    $this->title = Yii::t('app','address');
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= Yii::t('app', 'address') ?>
            <a href="<?= Url::to(['/management/user-address/create']) ?>" class="add-address-pay">
                <?= Yii::t('app', 'add_new_address') ?>
            </a>
        </h2>
    </div>
    <div class="list-address-pay">
        <?php foreach ($address as $add) {?>
            <div class="item-address-pay">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        <h2>
                            <b><?= Yii::t('app','full_name') ?>:</b> 
                            <?= $add['name_contact'] ?>
                            <!-- <input class="input-fixed" type="text" placeholder="Nguyễn Việt Hưng"> -->
                        </h2>
                        <p>
                            <b><?= Yii::t('app','phone') ?>:</b> 
                            <?= $add['phone'] ?>
                            <!-- <input class="input-fixed" type="text" placeholder="Hà Nội, chi nhánh: Phạm Hùng"> -->
                        </p>
                        <p>
                            <b><?= Yii::t('app','address') ?>:</b> 
                            <?= ($add['address'] ? $add['address'].', ' : '').$add['ward_name'].', '.$add['district_name'].', '.$add['province_name'] ?>
                            <!-- <input class="input-fixed" type="text" placeholder="Phòng B2T10 chung cư 335 Cầu Giấy, Hà Nội"> -->
                        </p>
                        <!-- <div class="btn-save input-fixed"><a href="" class="btn-style-2">Lưu</a></div> -->
                        <?php if($add['isdefault']) { ?>
                            <div class="btn-default-pay">
                                <a><?= Yii::t('app','default') ?></a>
                                <span><i class="fa fa-check"></i> <?= Yii::t('app','address_send_to') ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                        <div class="tool-box">
                            <a href="<?= Url::to(['/management/user-address/update', 'id' => $add['id']]) ?>" class="open-input-fixeds"><i class="fa fa-pencil"></i><?= Yii::t('app','update') ?></a>
                            <?php if(!$add['isdefault']) { ?>
                                <a class="cance" onclick="return confirm('<?= Yii::t('app', 'delete_sure') ?>?');" href="<?= Url::to(['/management/user-address/del', 'id' => $add['id']]) ?>"><i class="fa fa-times"></i><?= Yii::t('app','delete') ?></a>
                            <?php } ?>
                            <a class="btn-set-default <?= $add['isdefault'] ? 'active' : '' ?>" <?= $add['isdefault'] ? '' : 'href="'.Url::to(['/management/user-address/updatedf', 'id' => $add['id']]).'"' ?> ><?= Yii::t('app','select_default') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>