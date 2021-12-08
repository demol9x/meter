<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/27/2021
 * Time: 9:25 AM
 */
$rating = \common\models\rating\Rating::find()->where(['parent_id' => $rating_id])->joinWith(['user'])->asArray()->all();
if(isset($id) && $id){
    $rating = \common\models\rating\Rating::find()->where(['rating.parent_id' => $rating_id,'rating.id' => $id])->joinWith(['user'])->asArray()->all();
}
use common\components\ClaHost;
?>
<?php if ($rating): ?>
    <?php foreach ($rating as $value):
        $avatar = ClaHost::getImageHost() . '/imgs/default.png';
        if (isset($value['user']['avatar_path']) && $value['user']['avatar_path']) {
            $avatar = ClaHost::getImageHost() . $value['user']['avatar_path'] . $value['user']['avatar_name'];
        }
        ?>
        <div class="phanhoi-item">
            <div class="avt-phanhoi">
                <img src="<?= $avatar ?>" alt="">
            </div>
            <div class="comment-phanhoi">
                <div class="name-date">
                    <h5 class="content_14"><?= $value['user']['username'] ?></h5>
                    <p class="content_14"><?= date('d-m-Y', $value['created_at']) ?></p>
                </div>
                <p class="content_14"><?= \yii\bootstrap\Html::encode($value['content']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>