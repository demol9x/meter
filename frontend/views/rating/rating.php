<?php
/**
 * Created by PhpStorm.
 * User: trung
 * Date: 11/26/2021
 * Time: 8:57 PM
 */
use \common\components\ClaHost;
?>
<?php if ($data): ?>
    <?php foreach ($data as $value):
        $avatar = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
        if (isset($value['user']['avatar_path']) && $value['user']['avatar_path']) {
            $avatar = ClaHost::getImageHost() . $value['user']['avatar_path'] . $value['user']['avatar_name'];
        }
        ?>
        <div class="item-comment">
            <div class="avt-main">
                <div class="image-avt">
                    <img src="<?= $avatar ?>" alt="">
                </div>

                <div class="textch">
                    <h5 class="content_14"><?= $value['user']['username'] ?></h5>
                    <p class="content_14"><?= date('d-m-Y', $value['created_at']) ?></p>
                </div>
            </div>

            <div class="item-chat">
                <?php if ($value['rating']): ?>
                    <div class="danhgiakh">
                        <div class="star-vote">
                            <div class="star-style star-rating"
                                 style="background-image: url(<?= ClaHost::getImageHost() ?>/imgs/star.jpg); width:<?= $value['rating'] * 100 / 5 ?>%"></div>
                            <div class="star-style star_background"
                                 style="background-image: url(<?= ClaHost::getImageHost() ?>/imgs/star2.jpg);"></div>
                        </div>
                        <p class="content_14"><?= \common\components\ClaMeter::genStarText()[$value['rating']] ?></p>
                    </div>
                <?php endif; ?>

                <div style="display: flex;flex-wrap: wrap">
                    <?php
                    if(isset($value['images']) && $value['images']){?>
                        <?php foreach ($value['images'] as $key ){
                            $avatar_image = ClaHost::getImageHost() . '/imgs/default.png';
                            if (isset($key['path']) && $key['path']) {
                                $avatar_image = ClaHost::getImageHost() .$key['path'] . $key['name'];
                            }
                            ?>
                            <div class="images_danhgia_all">
                                <a data-fancybox="gallery" href="<?= $avatar_image ?>" >
                                    <img src="<?= $avatar_image ?>" alt="<?= $key['name']?>">
                                </a>
                            </div>
                        <?php }?>
                    <?php } ?>
                </div>

                <p class="content_14"><?= \yii\bootstrap\Html::encode($value['content']) ?></p>

                <div class="rep-like">
                    <div class="rep">
                        <button onclick="repComment(this)" data-id="<?= $value['id'] ?>"><i
                                    class="fa fa-reply"></i>&nbsp;Trả lời
                        </button>
                    </div>
                    <button onclick="likeComment(this)" data-id="<?= $value['id'] ?>"
                            class="<?= $value['is_like'] ? 'like-active' : '' ?>">
                        <i class="fa fa-thumbs-up"></i>&nbsp;<span>Thích</span>
                    </button>
                </div>
                <?= $this->render('partial/rating_item', ['rating_id' => $value['id'],'id' => '']); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
