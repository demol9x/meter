<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<div class="vertical-box">
    <div class="container">
        <div class="box-search-job">
            <h2>
                Tìm Công Việc Mơ Ước. <span>Nâng Bước Thành Công!</span>
            </h2>
            <div class="tool-search">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'search-form',
                            'action' => Url::to(['/recruitment/recruitment/index']),
                            'method' => 'GET'
                ]);
                ?>
                <?=
                Html::textInput('k', $keyword, [
                    'placeholder' => 'Nhập chức danh, vị trí, kỹ năng...',
                    'autocomplete' => 'off',
                    'class' => 'width-full'
                ]);
                ?>
                <div class="box-select width-full">
                    <span class="position-select"><i class="fa fa-list" aria-hidden="true"></i></span>
                    <?=
                    Html::dropDownList('c', $category_id, $categories, [
                        'prompt' => 'Tất cả ngành nghề'
                    ])
                    ?>
                </div>
                <div class="box-select width-full">
                    <span class="position-select"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                    <?=
                    Html::dropDownList('l', $location, $locations, [
                        'prompt' => 'Tất cả địa điểm'
                    ])
                    ?>
                </div>
                <div class="btn-submit-job width-full">
                    <a onclick="submitForm()" href="javascript:void(0)">Tìm việc</a>
                </div>
                <?php
                ActiveForm::end();
                ?>
            </div>
            <div class="upload-cv">
                <a href="">Đăng tải hồ sơ của bạn</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function submitForm() {
        $('#search-form').submit();
    }
</script>