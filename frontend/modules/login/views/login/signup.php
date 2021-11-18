<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
\Yii::$app->session->open();

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

$authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['/site/auth']
]);


?>
