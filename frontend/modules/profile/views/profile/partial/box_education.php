<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use frontend\models\profile\UserEducation;
?>
<div class="section-summary section-edit-user">
    <h2>
        <i class="fa fa-fw fa-graduation-cap" aria-hidden="true"></i> Học vấn và bằng cấp
    </h2>
    <div class="view-control">
        <div class="step-education">
            <div class="change-main-user">
                Mô tả học vấn và bằng cấp của bạn càng chi tiết càng tốt, điều đó giúp bạn có cơ hội hiển thị nhiều hơn trong kết quả tìm kiếm
                <div class="mar-top-15">
                    <div class="faq-accordion">
                        <?php
                        if (isset($educations) && $educations) {
                            ?>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                foreach ($educations as $education) {
                                    ?>
                                    <div class="panel panel-default actives">
                                        <div class="panel-heading" role="tab" id="heading<?= $education->id ?>">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $education->id ?>" aria-expanded="true" aria-controls="collapse<?= $education->id ?>" class="collapsed">
                                                    <?= $education->school ?>: <?= date('m-Y', $education['month_from']) ?> - <?= date('m-Y', $education['month_to']) ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?= $education->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $education->id ?>" style="height: 0px;">
                                            <div class="panel-body">
                                                <div class="wishlist-table table-responsive wrap-info-education">
                                                    <div class="view-info-education">
                                                        <div class="form-group">
                                                            <label for="name"> Chuyên ngành</label>
                                                            <p><?= $education['subject'] ?></p>
                                                        </div>
                                                        <div class="form-group width-50 pad-right-15">
                                                            <label>Trường</label>
                                                            <p><?= $education['school'] ?></p>
                                                        </div>
                                                        <div class="form-group width-50">
                                                            <label>Bằng cấp</label>
                                                            <p><?= UserEducation::getQualificationName($education['qualification']) ?></p>
                                                        </div>
                                                        <div class="form-group width-50 pad-right-15">
                                                            <label>Từ tháng</label>
                                                            <p><?= date('m/Y', $education['month_from']) ?></p>
                                                        </div>
                                                        <div class="form-group width-50">
                                                            <label>Đến tháng</label>
                                                            <p><?= date('m/Y', $education['month_to']) ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Thành tựu</label>
                                                            <p><?= nl2br($education['description']) ?></p>
                                                        </div>
                                                        <div class="form-group right">
                                                            <a class="btn btn-default stl_btn_save btn-show-input">Chỉnh sửa</a>
                                                        </div>
                                                    </div>
                                                    <div class="edit-info-education">
                                                        <?php
                                                        $form = ActiveForm::begin([
                                                                    'action' => Url::to(['/profile/profile/update-education']),
                                                                    'options' => [
                                                                        'class' => 'user-education-form'
                                                                    ]
                                                        ]);
                                                        ?>
                                                        <?=
                                                        $form->field($education, 'subject', [
                                                            'template' => '{label}{input}{error}{hint}'
                                                        ])->textInput([
                                                            'placeholder' => 'Ví dụ: Kinh doanh quốc tế'
                                                        ])->label($education->getAttributeLabel('subject'), [
                                                            'class' => ''
                                                        ]);
                                                        ?>

                                                        <div class="width-50 pad-right-15">
                                                            <?=
                                                            $form->field($education, 'school', [
                                                                'template' => '{label}{input}{error}{hint}'
                                                            ])->textInput([
                                                                'placeholder' => 'Ví dụ: Đại học Ngoại Thương'
                                                            ])->label($education->getAttributeLabel('school'), [
                                                                'class' => ''
                                                            ]);
                                                            ?>
                                                        </div>

                                                        <div class="width-50">
                                                            <?=
                                                            $form->field($education, 'qualification', [
                                                                'template' => '{label}{input}{error}{hint}'
                                                            ])->dropDownList(\frontend\models\profile\UserEducation::arrayQualification(), [
                                                                'prompt' => 'Chọn'
                                                            ])->label($education->getAttributeLabel('qualification'), [
                                                                'class' => ''
                                                            ]);
                                                            ?>
                                                        </div>

                                                        <div class="width-50 pad-right-15">
                                                            <?php
                                                            $education->month_from = $education->month_from ? date('d-m-Y', $education->month_from) : date('d-m-Y', time());
                                                            ?>
                                                            <?=
                                                            $form->field($education, 'month_from', [
                                                                'template' => '{label}{input}{error}{hint}'
                                                            ])->textInput([
                                                                'placeholder' => 'Từ tháng',
                                                                'class' => 'form-control date-picker'
                                                            ])->label($education->getAttributeLabel('month_from'), [
                                                                'class' => ''
                                                            ]);
                                                            ?>
                                                        </div>

                                                        <div class="width-50">
                                                            <?php
                                                            $education->month_to = $education->month_to ? date('d-m-Y', $education->month_to) : date('d-m-Y', time());
                                                            ?>
                                                            <?=
                                                            $form->field($education, 'month_to', [
                                                                'template' => '{label}{input}{error}{hint}'
                                                            ])->textInput([
                                                                'placeholder' => 'Đến tháng',
                                                                'class' => 'form-control date-picker'
                                                            ])->label($education->getAttributeLabel('month_to'), [
                                                                'class' => ''
                                                            ]);
                                                            ?>
                                                        </div>

                                                        <?=
                                                        $form->field($education, 'description')->textarea([
                                                            'class' => 'form-control',
                                                            'style' => 'height: 120px',
                                                            'rows' => 7
                                                        ])->label($education->getAttributeLabel('description'), [
                                                            'class' => ''
                                                        ])
                                                        ?>
                                                        <?= Html::activeHiddenInput($education, 'id') ?>
                                                        <div class="form-group right">
                                                            <button type="button" class="btn btn-default stl_btn_remove btn-show-input">Hủy</button>
                                                            <button type="submit" class="btn btn-default stl_btn_save">Lưu</button>
                                                        </div>
                                                        <?php ActiveForm::end(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="edit-main-user">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'user-education-form',
                            'action' => Url::to(['/profile/profile/update-education'])
                ]);
                ?>

                <?=
                $form->field($user_education, 'subject', [
                    'template' => '{label}{input}{error}{hint}'
                ])->textInput([
                    'placeholder' => 'Ví dụ: Kinh doanh quốc tế'
                ])->label($user_education->getAttributeLabel('subject'), [
                    'class' => ''
                ]);
                ?>

                <div class="width-50 pad-right-15">
                    <?=
                    $form->field($user_education, 'school', [
                        'template' => '{label}{input}{error}{hint}'
                    ])->textInput([
                        'placeholder' => 'Ví dụ: Đại học Ngoại Thương'
                    ])->label($user_education->getAttributeLabel('school'), [
                        'class' => ''
                    ]);
                    ?>
                </div>

                <div class="width-50">
                    <?=
                    $form->field($user_education, 'qualification', [
                        'template' => '{label}{input}{error}{hint}'
                    ])->dropDownList(\frontend\models\profile\UserEducation::arrayQualification(), [
                        'prompt' => 'Chọn'
                    ])->label($user_education->getAttributeLabel('qualification'), [
                        'class' => ''
                    ]);
                    ?>
                </div>

                <div class="width-50 pad-right-15">
                    <?=
                    $form->field($user_education, 'month_from', [
                        'template' => '{label}{input}{error}{hint}'
                    ])->textInput([
                        'placeholder' => 'Từ tháng',
                        'class' => 'form-control date-picker'
                    ])->label($user_education->getAttributeLabel('month_from'), [
                        'class' => ''
                    ]);
                    ?>
                </div>

                <div class="width-50">
                    <?=
                    $form->field($user_education, 'month_to', [
                        'template' => '{label}{input}{error}{hint}'
                    ])->textInput([
                        'placeholder' => 'Đến tháng',
                        'class' => 'form-control date-picker'
                    ])->label($user_education->getAttributeLabel('month_to'), [
                        'class' => ''
                    ]);
                    ?>
                </div>

                <?=
                $form->field($user_education, 'description')->textarea([
                    'class' => 'form-control',
                    'style' => 'height: 120px',
                    'rows' => 7
                ])->label($user_education->getAttributeLabel('description'), [
                    'class' => ''
                ])
                ?>
                <div class="form-group">
                    <i>5000 ký tự có thể nhập thêm</i>
                </div>
                <div class="form-group right">
                    <button type="button" class="btn btn-default stl_btn_remove btn-close-box">Hủy</button>
                    <button type="submit" class="btn btn-default stl_btn_save">Lưu</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="user-avatar-edit btn-close-box">
            <button type="button" class="btn btn-sm btn-default">
                <i class="glyphicon glyphicon-pencil"></i>
            </button>
        </div>
        <div class="bottom-edit btn-close-box">
            Bổ sung
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#user-education-form').on('beforeSubmit', function (e) {
        var _form = $(this);
        $.post(
                _form.attr('action'),
                _form.serialize()
                ).done(function (result) {
            if (result.code == 200) {
                $('.step-education').html(result.html);
            }
        }).fail(function () {
            console.log('server error');
        });
        return false;
    });

    $('.user-education-form').on('beforeSubmit', function (e) {
        var _form = $(this);
        $.post(
                _form.attr('action'),
                _form.serialize()
                ).done(function (result) {
            if (result.code == 200) {
                $('.step-education').html(result.html);
            }
        }).fail(function () {
            console.log('server error');
        });
        return false;
    });
</script>
<script>
    $(document).ready(function () {
        $('.date-picker').daterangepicker({
            timePickerIncrement: 5,
            locale: {
                format: 'DD-MM-YYYY',
                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
            singleDatePicker: true,
            calender_style: "picker_4"
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>