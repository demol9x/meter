<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\shop\Shop;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="center">
    <br/>
        Đã gủi: <?= $end;  ?> / <?= $count ?>
    <hr>
    <?php if($end < $count) { ?>
        <a href="<?= Url::to(['/user/mail/index']) ?>" class="btn btn-danger cancer">Hủy gửi</a>
        <script type="text/javascript">
            var href = '<?= Url::to(['/user/mail/send-mail', 'page' => $page]) ?>';
            $.ajax({
                url: href,
                type: 'POST',
                data: <?= json_encode($post) ?>,
                success: function(result){
                    $('.box-mail').html(result);
                }
            }); 
            $('.cancer').click(function () {
                location.reload();
            });
        </script>
    <?php } else { ?>
        <a href="<?= Url::to(['/user/mail/index']) ?>" class="btn btn-primary cancer">Đã gửi</a>
        <script type="text/javascript">
            $('.cancer').click(function () {
                location.reload();
            });
        </script>
    <?php } ?>
</div>
