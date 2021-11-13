<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>

<div class="search">
    <img class="search_icon" src="<?= Yii::$app->homeUrl ?>images/search.png" alt="" >
    <div class="toggle_search">
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'action' => Url::to(['/product/product/index']),
            'method' => 'GET',
            'options' => [
                'class' => 'search-box'
            ]
        ]); ?>
        <?=
        Html::textInput('k', $keyword, [
            'placeholder' => 'Tìm kiếm',
            'autocomplete' => 'off',
            'class' => ''
        ]);
        ?>

            <button><img src="<?= Yii::$app->homeUrl ?>images/search.png" alt="" ></button>
        <?php ActiveForm::end(); ?>
    </div>
</div>