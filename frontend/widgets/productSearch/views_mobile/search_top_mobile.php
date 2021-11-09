<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;
$log = Yii::$app->user->getId() ? Url::to(['/management/profile/index-management']) : Url::to(['/login/login/login']);
$user = \frontend\models\User::findIdentity(Yii::$app->user->getId());
if (isset($user)) {
    if ($user && $user->avatar_name) {
        $image_u = \common\components\ClaHost::getImageHost() . $user->avatar_path .'s50_50/'. $user->avatar_name;
    } else {
        $image_u = \common\components\ClaHost::getImageHost() . '/imgs/user_default.png';
    }
}
?>
<div class="flex-col flex-right hidden-lg hidden-md hidden-sm login-in-mobile">
    <a href="<?= $log ?>">
        <img src="<?= isset($image_u) ? $image_u : Yii::$app->homeUrl.'images/user-header.png' ?>" alt="">
    </a>
</div>

<?= frontend\widgets\notifications\NotificationsWidget::widget() ?>

<?= frontend\widgets\shoppingcart\Shoppingcart::widget([
                        'view' => 'view_m',
                    ]) ?>
<style type="text/css">
    .flex-col .form-search-inmobile > span {
        text-align: right;
        outline: none;
        position: absolute;
        right: 0px;
        top: 0px;
        border: none;
        background: transparent;
        border-radius: 50%;
        height: 32px;
        width: 100%;
        color: #dbbf6d;
        margin-top: 12px;
        margin-right: 5px;
    }
</style>
<div class="flex-col flex-right hidden-lg hidden-md hidden-sm box-search-inmobile">
    <div class="form-search-inmobile">
        <input type="text" class="text-search" name="keyword" placeholder="<?= Yii::t('app', 'enter_text_search') ?>">
        <div class="box-searchResults">
            <div id="searchResults" class="search-results">
            </div>
        </div>
        <span id="btn-search-mobile"><i class="fa fa-search"></i></span>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-search-mobile').click(function () {
            $('#box-search-mobile').addClass('open');
            $('body').css('overflow', 'hidden');
            href = '<?= Url::to(['/search/search/index-ajax']) ?>';
            if($(this).attr('data-load') != 0) {
                $(this).attr('data-load', 0); 
                loadAjax(href, $('#from-search-mobile').serialize(),$('#box-load-search'));
            }
            return false;
        });
         //
        $('.back-page').click(function () {
            $('#box-search-mobile').removeClass('open');
            $('body').css('overflow', 'auto');
        });
        jQuery(document).on('click', function (e) {
            if ($(e.target).closest("#searchForm").length === 0) {
                jQuery('#searchResults').fadeOut(200);
            }
        });
    })
</script>