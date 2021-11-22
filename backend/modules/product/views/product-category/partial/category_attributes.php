<div class="col-md-4">
    <?= $form->field($model, 'mat_tien')->checkBox(['label' => 'Mặt tiền', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'duong_vao')->checkBox(['label' => 'Đường vào', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'huong_nha')->checkBox(['label' => 'Hướng nhà', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'huong_ban_cong')->checkBox(['label' => 'Hướng ban công', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'so_tang')->checkBox(['label' => 'Số tầng', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'so_phong_ngu')->checkBox(['label' => 'Số phòng ngủ', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'so_toilet')->checkBox(['label' => 'Số toilet', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'noi_that')->checkBox(['label' => 'Nội thất', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'thong_tin_phap_ly')->checkBox(['label' => 'Thông tin pháp lý', 'data-size' => 'small', 'class' => 'bs_switch'

        , 'style' => 'margin-bottom:4px;', 'id' => 'active']) ?>
</div>
