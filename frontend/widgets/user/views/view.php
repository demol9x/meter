<?php
if(isset($data) && $data){
?>
<div class="pro_package">
    <div class="pro_content">
        <div class="content_text"><h3>tìm thợ</h3></div>
        <a class="content_viewall" href="<?= \yii\helpers\Url::to(['/user/user/index'])?>"><span>Xem tất cả</span><i class="far fa-chevron-right"></i></a>
    </div>
    <div class="pro_flex">
        <?php
        $i=1;
            foreach ($data as $key){
                $i = $i +2;
                $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                if (isset($key['user']['avatar_path']) && $key['user']['avatar_path']) {
                    $avatar_path = \common\components\ClaHost::getImageHost() . $key['user']['avatar_path'] . $key['user']['avatar_name'];
                }
                $link = \yii\helpers\Url::to(['/user/user/detail','id'=>$key['user_id']]);
        ?>
        <div class="pro_card wow fadeIn"  data-wow-delay="0.<?= $i ?>s">
            <a href="<?= $link ?>">
                <div class="card_img">
                    <img src="<?= $avatar_path ?>" alt="<?= $key['name'] ?>">
                </div>
                <div class="card_text">
                    <div class="title"><?= $key['name'] ?>
                        <p><?= isset($key['job']['name']) && $key['job']['name'] ? $key['job']['name'] : '' ?></p>
                    </div>
                    <div class="adress"><span><?= isset($key['province']['name']) && $key['province']['name'] ? $key['province']['name'] : 'Đang cập nhật' ?></span><span><?= isset($key['kinh_nghiem']) && $key['kinh_nghiem'] ? \common\models\user\Tho::numberKn()[$key['kinh_nghiem']] : '' ?></span></div>
                </div>
            </a>
            <label class="heart">
                <a data-id="<?= $key['user_id'] ?>" class="iuthik1 iuthik_user  <?= in_array($key['user_id'], $us_wish) ? 'active' : '' ?>"><i class="fas fa-heart"></i></a>
            </label>
            <?php
            if(isset($key['is_hot']) && $key['is_hot']==1){
            ?>
            <div class="hot_product"><img src="<?php Yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
            <?php } ?>
        </div>
        <?php }?>
    </div>
</div>
<?php } ?>
<script>
$(".iuthik_user").click(function (){
    var t = $(this);
    var tho_id = $(this).data('id');
    $.ajax({
        url: "<?= yii\helpers\Url::to(['/user/user/add-like']) ?>",
        type: "get",
        data: {"tho_id": tho_id},
        success: function (response) {
            var data = JSON.parse(response);
            if (data.success) {
                t.toggleClass('active');
            } else {
                alert(data.message)
            }

        },
    });
});
</script>
