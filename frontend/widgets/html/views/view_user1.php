<?php

use common\models\general\UserWish;
use yii\helpers\Url;

if (isset($users) && $users) {
    $us_wish = UserWish::find()->where(['user_id_from' => Yii::$app->user->id, 'type' => \frontend\models\User::TYPE_DOANH_NGHIEP])->asArray()->all();
    $us_wish = array_column($us_wish, 'user_id', 'id');
    ?>
    <div class="pro_slide">
        <div class="pro_package">
            <div class="pro_content">
                <div class="content_text">
                    <h3><?= $title ?></h3>
                </div>
            </div>

            <div class="pro_flex slide_pro_active">
                <?php

                foreach ($users as $key) {
                    $url = Url::to(['/shop/shop/detail', 'id' => $key['user_id'], 'alias' => $key['alias']]);
                    $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                    if (isset($key['user']['avatar_path']) && $key['user']['avatar_path']) {
                        $avatar_path = \common\components\ClaHost::getImageHost() . $key['user']['avatar_path'] . $key['user']['avatar_name'];
                    }
                    ?>
                    <div class="pro_card wow fadeIn">
                        <a href="<?= Url::to(['/shop/shop/detail', 'id' => $key['user_id']]) ?>">
                            <div class="card_img">
                                <img src="<?= $avatar_path ?>" alt="<?= $key['name'] ?>">
                            </div>
                            <div class="card_text">
                                <div class="title"><?= $key['name'] ?></div>
                                <div class="adress">
                                    <span><?= isset($key['province']['name']) && $key['province']['name'] ? $key['province']['name'] : 'Đang cập nhật' ?></span>
                                    <span><i class="fas fa-star"></i><?php echo $key['rate'] ?>/5</span>
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
            </div>
        </div>
    </div>
<?php } ?>
