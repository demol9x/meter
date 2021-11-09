<?php

use yii\helpers\Html;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\user\user */

$this->title = Yii::t('app','bank');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','bank'), 'url' => ['index']];
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
    function submit_user_form() {
        document.getElementById("user-form").submit();
        return false;
    }
</script>