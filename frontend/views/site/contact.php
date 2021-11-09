<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
// use common\components\ClaLid;

$this->title = 'Liên hệ ocopmart.org';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    li {
        list-style: none;
    }
    .errmsg {
        display: none;
    }
    .form-contact .form-group {
        clear: both;
    }
</style>
<div class="page-contact bg-whites page-contact-us" style="">
    <div class="boxsss">
        <h2 class="title-content"><?= $info->title ?></h2>
        <hr/>
        <?= common\widgets\Alert::widget() ?>
        <p><?= $info->short_description ?></p>
        <p><?= Yii::t('app','contact_method') ?></p>
        <ul class="font14 pl20" style="list-style:disc">
            <li><?= Yii::t('app','phone') ?>: <strong><?= $infoAdd->phone ?></strong></li>
            <li><?= Yii::t('app','outside_us') ?>: <strong><?= $infoAdd->hotline ?></strong></li>
            <li>Email: <a class="edumore" href="mailto:<?= $infoAdd->email ?>"><strong><?= $infoAdd->email ?></strong></a></li>
            <li>Địa chỉ: <strong><?= $infoAdd->address ?></strong></li>
        </ul>
        <div class="contact">
            <p class="pd-20">Hoặc gửi nội dung trực tiếp đến ban quản lý để được giải đáp một cách toàn diện nhất.</p>
            <?php
                $form = ActiveForm::begin([
                            'id' => 'form-contact',
                            'options' => [
                                'class' => ''
                            ]
                ]);
                ?>
                    <?=
                        $form->field($model, 'name', [
                            'template' => '<div class="col2"> 
                                    <div class="tar p5">
                                        <span class="errmsg">*</span>{label}</span>
                                    </div></div>
                                <div class="col10">{input}{error}{hint}
                                </div>'
                        ])->textInput([
                            'class' => 'pb15 col12',
                            'placeholder' => $model->getAttributeLabel('name')
                        ])->label($model->getAttributeLabel('name'), [
                            'class' => 'lab'
                        ]);
                    ?>

                    <?=
                        $form->field($model, 'phone', [
                            'template' => '<div class="col2"> 
                                    <div class="tar p5">
                                        <span class="errmsg">*</span>{label}</span>
                                    </div></div>
                                <div class="col10">{input}{error}{hint}
                                </div>'
                        ])->textInput([
                            'class' => 'pb15 col12',
                            'placeholder' => $model->getAttributeLabel('phone')
                        ])->label($model->getAttributeLabel('phone'), [
                            'class' => 'lab'
                        ]);
                    ?>
                    <?=
                        $form->field($model, 'email', [
                            'template' => '<div class="col2"> 
                                    <div class="tar p5">
                                        <span class="errmsg">*</span>{label}</span>
                                    </div></div>
                                <div class="col10">{input}{error}{hint}
                                </div>'
                        ])->textInput([
                            'class' => 'pb15 col12',
                            'placeholder' => $model->getAttributeLabel('email')
                        ])->label($model->getAttributeLabel('email'), [
                            'class' => 'lab'
                        ]);
                    ?>
                    <?=
                        $form->field($model, 'subject', [
                            'template' => '<div class="col2"> 
                                    <div class="tar p5">
                                        <span class="errmsg">*</span>{label}</span>
                                    </div></div>
                                <div class="col10">{input}{error}{hint}
                                </div>'
                        ])->textInput([
                            'class' => 'pb15 col12',
                            'placeholder' => $model->getAttributeLabel('subject')
                        ])->label($model->getAttributeLabel('subject'), [
                            'class' => 'lab'
                        ]);
                    ?>
                    <?=
                        $form->field($model, 'body', [
                            'template' => '<div class="col2"> 
                                    <div class="tar p5">
                                        <span class="errmsg">*</span>{label}</span>
                                    </div></div>
                                <div class="col10">{input}{error}{hint}
                                </div>'
                        ])->textArea([
                            'class' => 'pb15 col12',
                            'placeholder' => $model->getAttributeLabel('body')
                        ])->label($model->getAttributeLabel('body'), [
                            'class' => 'lab'
                        ]);
                    ?>
                    <div class="pb15 col12">
                        <div class="col2">
                            <div class="tar p5"></div>
                        </div>
                        <div class="col10 right"> 
                            <a class="ovalbutton" id="submit" href="javascript:void(0);"><span><?= Yii::t('app','submit') ?></span></a> 
                            <a class="ovalbutton" id="reset" href="javascript:void(0);"><span><?= Yii::t('app','reset') ?></span></a> 
                        </div>
                    </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="clear"></div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#submit').click( function() {
                $('#form-contact').submit();
            })
        })
        $(document).ready(function () {
            $('#reset').click( function() {
                document.getElementById('form-contact').reset();
            })
        })
    </script>
</div>