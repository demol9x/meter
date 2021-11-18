<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>

<div class="search">
    <i class="far fa-search search_icon"></i>
    <div class="toggle_search">
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'action' => Url::to(['/package/package/index']),
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

            <button><i class="far fa-search"></i></button>
        <?php ActiveForm::end(); ?>
    </div>
</div>