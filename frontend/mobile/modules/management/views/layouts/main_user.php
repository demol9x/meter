<?php 
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use common\widgets\Alert;
use common\components\ClaHost;
use common\components\ClaLid;
$user = \common\models\User::findOne(Yii::$app->user->id);
?>
<style type="text/css">
    .alert {
        position: fixed;
        z-index: 1;
        top: 100px;
        width: 70%;
        margin-left: 15%;
    }
</style>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <div id="main">
        <?= Alert::widget() ?>
        <div class="create-page-store">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>
