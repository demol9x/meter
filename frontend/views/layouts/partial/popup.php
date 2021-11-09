<?php
\Yii::$app->session->open();
$siteinfo = common\components\ClaLid::getSiteinfo();
$session_name = 'show_popup_gca';
if (!isset($_SESSION[$session_name])) {
    $_SESSION[$session_name] = time();
    if (!$siteinfo['video_link']) {
        echo \frontend\widgets\banner\BannerWidget::widget([
            'view' => 'popup',
            'group_id' => 6,
            'limit' => 3
        ]);
    } else { ?>
        <div class="popup-sapphire">
            <div class="bg-shadow"></div>
            <div class="popup-ctn-sapphire">
                <div id="box-cr-popupss">
                    <iframe id="iframe-video" width="100%" height="400px" src="<?= \common\components\ClaAll::getEmbedToLink($siteinfo['video_link']) ?>?autoplay=1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" frameborder="0" allowautoplay="true" allowfullscreen="true"></iframe>
                </div>
                <div class="close-btn-sapphire">x</div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.close-btn-sapphire').click(function() {
                    $('.popup-sapphire').css('display', 'none');
                    $('#box-cr-popupss').remove();
                });
            });
        </script>
    <?php } ?>
<?php } ?>