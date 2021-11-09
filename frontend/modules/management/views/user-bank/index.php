<?php  
    use yii\helpers\Url;
    $this->title = Yii::t('app','bank');
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= Yii::t('app', 'bank') ?>
            <a href="<?= Url::to(['/management/user-bank/create']) ?>" class="add-address-pay">
                <?= Yii::t('app', 'add_new_bank') ?>
            </a>
        </h2>
    </div>
    <div class="list-address-pay">
        <?php foreach ($model as $bank) {?>
            <div class="item-address-pay">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        <h2>
                            <b><?= Yii::t('app','bank') ?>:</b> 
                            <?= $bank['bank_name'] ?>
                        </h2>
                        <p>
                            <b><?= Yii::t('app','user_bank') ?>:</b> 
                            <?= $bank['name'] ?>
                        </p>
                        <p>
                            <b><?= Yii::t('app','user_bank_number') ?>:</b> 
                            <?= $bank['number'] ?>
                        </p>
                        <p>
                            <b><?= Yii::t('app','phone') ?>:</b> 
                            <?= $bank['phone'] ?>
                        </p>
                        <p>
                            <b><?= Yii::t('app','address_bank') ?>:</b>
                            <?= $bank['address'] ?>
                        </p>
                        
                        <?php if($bank['isdefault']) { ?>
                            <div class="btn-default-pay">
                                <a><?= Yii::t('app','default') ?></a>
                                <span><i class="fa fa-check"></i> </span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                        <div class="tool-box">
                            <a href="<?= Url::to(['/management/user-bank/update', 'id' => $bank['id']]) ?>" class="open-input-fixeds"><i class="fa fa-pencil"></i><?= Yii::t('app','update') ?></a>
                            <?php if(!$bank['isdefault']) { ?>
                                <a class="cance" href="<?= Url::to(['/management/user-bank/del', 'id' => $bank['id']]) ?>"><i class="fa fa-times"></i><?= Yii::t('app','delete') ?></a>
                            <?php } ?>
                            <a class="btn-set-default <?= $bank['isdefault'] ? 'active' : '' ?>" <?= $bank['isdefault'] ? '' : 'href="'.Url::to(['/management/user-bank/updatedf', 'id' => $bank['id']]).'"' ?> ><?= Yii::t('app','select_default') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>