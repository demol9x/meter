<?php if (\common\components\ClaSite::isActiceApp()) { 
    switch (\common\components\ClaSite::isActiceApp()) {
        case 'ios': { ?>
                <link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl ?>css/ios.css?vs=<?= time() ?>">
                <!-- <script type="text/javascript">
                    $('a').removeAttr("target");
                </script> -->
            <?php }
          break;
        case 'android':  { 
            \Yii::$app->session->open();
            if(isset($_SESSION['new_logout']) && $_SESSION['new_logout']) {
                unset($_SESSION['new_logout']); ?>
                <script type="text/javascript">
                    Android.callBackLogout();
                </script>
            <?php } ?>
                <link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl ?>css/android.css?vs=<?= time() ?>">
            <?php }
          break;
        }
    ?>
    <style type="text/css">
        .list-skip-link {
            margin-top: 10px;
        }
    </style>
<?php } ?>