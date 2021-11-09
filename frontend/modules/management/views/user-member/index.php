<?php  
    use yii\helpers\Url;
    $this->title = Yii::t('app','config_user_member');
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-map-marker.png" alt=""> <?= $this->title ?>
            <?php if($user->member_privatekey) { ?>
                <a onclick="return confirm('<?= Yii::t('app','delete_sure') ?>')" href="<?= Url::to(['/management/user-member/del']) ?>" class="add-address-pay">
                    <?= Yii::t('app', 'delete') ?>
                </a>
            <?php } ?>
        </h2>
    </div>
    <div class="list-address-pay">
        <?php if($user->member_privatekey) { ?>
            <p><?= Yii::t('app','config_1') ?>: <?= substr($user->member_privatekey, 0, -24); ?>************************</p>
            <p style="color: green" class="center"><?= Yii::t('app','note') ?>: <?= Yii::t('app','config_3') ?></p>
            <?php } else { ?>
                <p style="color: green" class="center"><?= Yii::t('app','note') ?>: <?= Yii::t('app','config_0') ?></p>
                <div class="ctn-form">
                    <form id="form-cf">
                        <div class="form-group field-useraddress-name_contact required has-success">
                            <div class="item-input-form">
                                <label class="" for="useraddress-name_contact"><?= Yii::t('app','us_cf1') ?></label>
                                <div class="group-input">
                                    <div class="full-input">
                                        <input type="text" id="useraddress-name_contact" class="form-control" name="username" maxlength="50">
                                        <div class="help-block"></div>
                                        <p class="skip"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="item-input-form">
                                <label class="" for="useraddress-name_contact"><?= Yii::t('app','us_cf2') ?></label>
                                <div class="group-input">
                                    <div class="full-input">
                                        <input type="password" id="useraddress-name_contact" class="form-control" name="password" maxlength="50">
                                        <div class="help-block"></div>
                                        <p class="skip"></p>
                                    </div>
                                </div>
                            </div>
                            <div id="box-load" style="color: red"></div>
                            <div class="btn-submit-form">
                                <input type="submit" id="user-form" value="<?= Yii::t('app','config') ?>">
                            </div>
                        </div>
                    </form>
                </div>   
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#form-cf').submit(function () {
            var href = '<?= Url::to(['/management/user-member/get-key']) ?>';
            loadAjax(href, $('#form-cf').serialize(), $('#box-load'));
            return false;
        })
    });
</script>
