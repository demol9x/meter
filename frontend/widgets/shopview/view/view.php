<?php
foreach ($users as $key) {
    $url= Url::to(['/shop/shop/detail','id'=>$key['user_id'],'alias'=>$key['alias']]);
    $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
    if (isset($key['user']['avatar_path']) && $key['user']['avatar_path']) {
        $avatar_path = \common\components\ClaHost::getImageHost() . $key['user']['avatar_path'] . $key['user']['avatar_name'];
    }
    ?>
    <div class="pro_card wow fadeIn">
        <a href="">
            <div class="card_img">
                <img src="<?= $avatar_path ?>" alt="<?= $key['name'] ?>">
            </div>
            <div class="card_text">
                <div class="title"><?= $key['name'] ?></div>
                <div class="adress"><span><?= $key['province']['name'] ?></span>
                    <?php
                    if (isset($key['rate']) && $key['rate']) { ?>
                        <span><i class="fas fa-star"></i><?php echo $key['rate'] ?>/5</span>
                    <?php } ?>
                </div>
            </div>
        </a>
        <label class="heart">
            <a data-id="<?= $key['user_id'] ?>"
               class="iuthik1 <?= in_array($key['user_id'], $us_wish) ? 'active' : '' ?>"><i
                        class="fas fa-heart"></i></a>
        </label>
    </div>
<?php } ?>