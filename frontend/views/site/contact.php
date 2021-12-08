<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
?>
<div class="container_fix">
    <?php //Menu main
    echo frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget([
            'view'=>'view'
    ])
    ?>
    <div class="lienhe__row">
        <div class="lienhe__row--left">
            <h2 class="title-icon title_30">THÔNG TIN LIÊN HỆ</h2>
            <h3 class="title_26"><span><?= $infoAdd->title ?></span></h3>
            <ul class="content_16">
                <li>
                    MST: 01N8022048 - Ngày cấp: 27/11/2020
                </li>
                <li>
                    Nơi cấp: UBND Quận Long Biên - Phòng tài chính - Kế hoạch
                </li>
                <li>
                    <i class="far fa-map-marker-alt"></i> <?= $infoAdd->address ?>
                </li>
                <li>
                    <i class="far fa-phone-alt"></i> <?= $infoAdd->hotline ?> - <?= $infoAdd->phone ?>
                </li>
                <li>
                    <i class="far fa-envelope"></i> <?= $infoAdd->email ?>
                </li>
            </ul>
        </div>

        <div class="lienhe__row--right">
            <p class="content_16">Xin vui lòng để lại thông tin liên lạc, chúng tôi sẽ cập nhật những thông tin mới nhất tới bạn.</p>
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
                    'template' => '<div class="form_env"><i class="far fa-user"></i>{input}</div>{error}{hint}'
                ])->textInput([
                    'class' => 'content_16',
                    'placeholder' => 'Họ - tên'
                ])
                ?>
            <div class="row-input">
                <?=
                $form->field($model, 'phone', [
                    'template' => '<div class="form_env"><i class="fal fa-phone-alt"></i>{input}</div>{error}{hint}'
                ])->textInput([
                    'class' => 'content_16',
                    'placeholder' => 'Số điện thoại'
                ])
                ?>
                <?=
                $form->field($model, 'email', [
                    'template' => '<div class="form_env"><i class="far fa-envelope"></i>{input}</div>{error}{hint}'
                ])->textInput([
                    'class' => 'content_16',
                    'placeholder' => 'Email'
                ])
                ?>
            </div>
                <?=
                $form->field($model, 'subject', [
                    'template' => '<div class="form_env"><i class="fal fa-flag"></i>{input}</div>{error}{hint}'
                ])->textInput([
                    'class' => 'content_16',
                    'placeholder' => 'Tiêu đề'
                ])
                ?>
                <?=
                $form->field($model, 'body', [
                    'template' => ' <div class="form_env"><i class="fal fa-comment-alt-dots"></i>{input}</div>{error}{hint}'
                ])->textarea([
                    'class' => 'content_16',
                    'placeholder' => 'Nội dung',
                    'cols'=>30,
                    'rows'=>50,
                ])
                ?>
                <button class="content_16 btn-animation1" type="submit">Gửi </button>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="lienhe--map">
        <iframe src="<?= $infoAdd->iframe ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>
</div>