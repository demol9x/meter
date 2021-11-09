<?php
\Yii::$app->session->open();
use yii\helpers\Html;
use common\models\ActiveFormC;

/* @var $this yii\web\View */
/* @var $model common\models\shop\Shop */

$this->title = Yii::t('app','create_shop');
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-page-store">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md12 col-sm-12 col-xs-12">
                <div class="form-create-store">
                    <div class="title-form">
                        <h2>
                            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> 
                            <?= $this->title ?>
                        </h2>
                    </div>
                    <?php if(isset($_SESSION['create_shop'])) { ?>
                        <div class="list-process-payment" style="border-bottom: none;">
                            <ul>
                                <li class="active">
                                    <a href="">
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-1.png" alt="">
                                        <span><?=  Yii::t('app', 'signup_user')  ?></span>
                                    </a>
                                </li>
                                <li class="active current">
                                    <a href="">
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-2.png" alt="">
                                        <span><?=  Yii::t('app', 'enter_info')  ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="<?= Yii::$app->homeUrl ?>images/process-3.png" alt="">
                                        <span><?=  Yii::t('app', 'enter_auth')  ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                    <div class="ctn-form form-buywith-gca">
                        <?= 
                            $this->render('_form', [
                                'model' => $model,
                                'images' => $images,
                                'list_district' => $list_district,
                                'list_ward' => $list_ward,
                                'list_province' => $list_province,
                                'user' => $user
                            ]) 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    <?php if(isset($alert) && $alert) echo "alert('$alert');"; ?>
    function submit_shop_form() {
        document.getElementById("shop-form").submit();
        return false;
    }
</script>