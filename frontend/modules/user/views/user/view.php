<?php if ($data) { ?>
    <?php foreach ($data as $user):

        $url = \yii\helpers\Url::to(['/user/user/detail', 'id' => $user['user_id'], 'alias' => $user['alias']]);
        $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
        if (isset($user['user']['avatar_path']) && $user['user']['avatar_path']) {
            $avatar_path = \common\components\ClaHost::getImageHost() . $user['user']['avatar_path'] . $user['user']['avatar_name'];
        }
        ?>
        <div class="pro_card wow fadeIn" data-wow-delay="0.1s">
            <a href="<?= $url ?>">
                <div class="card_img">
                    <img src="<?= $avatar_path ?>" alt="">
                </div>
                <div class="card_text">
                    <div class="title"><?= $user['name'] ?>
                        <p><?= isset($user['job']['name']) && $user['job']['name'] ? $user['job']['name'] : '' ?></p>
                    </div>
                    <div class="adress">
                        <span><?= isset($user['province']['name']) && $user['province']['name'] ? $user['province']['name'] : '' ?></span><span><?= isset($user['kinh_nghiem']) && $user['kinh_nghiem'] ? \common\models\user\Tho::numberKn()[$user['kinh_nghiem']] : '' ?></span>
                    </div>
                </div>
            </a>
            <label class="heart">
                <a data-id="<?= $user['user_id'] ?>"
                   class="iuthik1 <?= in_array($user['user_id'], $us_wish) ? 'active' : '' ?>"><i
                            class="fas fa-heart"></i></a>
            </label>
        </div>
    <?php endforeach; ?>
<?php } ?>

