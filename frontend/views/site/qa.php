<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app','question_normal');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .full h2 {
        color: #000;
        font-size: 36px;
        font-style: normal;
        line-height: 48px;
        text-transform: capitalize;
        padding: 10px 0 20px;
        text-align: center;
    }
    .full {
        background: url(../images/edu_banner_bg.jpg);
        margin-bottom: -30px;
    }
    .qa .staticpage h2 {
        font-size: 26px;
    }
</style>
<div class="page-about-us qa">
    <div class="full">
        <h2>
            <?= $this->title ?>
        </h2>
    </div>
    <div class="container">
        <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>
    </div>
    <div class="container">
        <?=
            \frontend\widgets\quetionAns\QuetionAnsWidget::widget([
                'view' => 'view',
                'parent' => 0
            ]);
        ?>
    </div>
</div>