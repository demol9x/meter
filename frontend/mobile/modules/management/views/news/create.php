<?php

$this->title = 'Đăng bài tin';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý bài tin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <div class="ctn-form">
            <?= 
            $this->render('_form', [
                'model' => $model,
            ]) ?>
    </div>
</div>

<script>
    <?php if(isset($alert) && $alert) echo "alert('$alert');"; ?>
</script>