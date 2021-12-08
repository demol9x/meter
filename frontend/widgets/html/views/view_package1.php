<?php

use common\models\package\PackageWish;
use common\models\Province;

if (isset($hot_package) && $hot_package) {
    $package_wish = PackageWish::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
    $package_wish = array_column($package_wish, 'package_id', 'id');
    ?>
    <div class="pro_flex_right">
        <div class="pro_package">
            <div class="pro_content">
                <div class="content_text">
                    <h3><?= $title ?></h3>
                </div>
            </div>

            <div class="pro_flex item-list-hot-deal">


                <?php
                $i = 3;
                foreach ($hot_package as $key) {
                    $i + 3;
                    $link = \yii\helpers\Url::to(['/package/package/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                    $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                    if (isset($key['avatar_path']) && $key['avatar_path']) {
                        $avatar_path = \common\components\ClaHost::getImageHost() . $key['avatar_path'] . $key['avatar_name'];
                    }
                    ?>
                    <div class="pro_card wow fadeIn" data-wow-delay="0.<?= $i ?>s">
                        <a href="<?= $link ?>">
                            <div class="card_img">
                                <img src="<?= $avatar_path ?>"
                                     alt="<?= $key['name'] ?>">
                            </div>
                            <div class="card_text">
                                <div class="title"><?= $key['name'] ?></div>
                                <?php
                                if (isset($key['province_id']) && $key['province_id']) {
                                    $provin = Province::findOne(['id' => $key['province_id']]);
                                }
                                ?>
                                <div class="adress">
                                    <span><?= isset($key['province_id']) && $key['province_id'] ? $provin->name : 'Đang cập nhật' ?></span><span>60km</span>
                                </div>
                                <div class="date_time">
                                        <span>
                                            <img src="<?= yii::$app->homeUrl ?>images/time_pro.png" alt="">
                                        <span><?= date('d', $key['updated_at']) ?></span>/<span><?= date('m', $key['updated_at']) ?></span>/<span><?= date('Y', $key['updated_at']) ?></span>
                                        </span>
                                </div>

                            </div>
                        </a>
                        <label class="heart">
                            <a data-id="<?= $key['id'] ?>"
                               class="iuthik1 <?= in_array($key['id'], $package_wish) ? 'active' : '' ?>"><i
                                        class="fas fa-heart"></i></a>
                        </label>
                        <?php if (isset($key['ishot']) && $key['ishot'] == 1) { ?>
                            <div class="hot_product"><img
                                        src="<?= yii::$app->homeUrl ?>images/hot_product.png"
                                        alt=""></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <style>
        .pro_package .date_time {
            justify-content: space-between;
        }
    </style>
    <script>
        function change_link(t) {
            var url = $(t).data('url');
            window.location.href = url;
        }

        $(".iuthik1").click(function () {

            var t = $(this);
            var package_id = $(this).data('id');
            $.ajax({
                url: "<?= yii\helpers\Url::to(['/package/package/add-like']) ?>",
                type: "get",
                data: {"package_id": package_id},
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        t.toggleClass('active');
                    } else {
                        alert(data.message);

                    }


                },
            });
        });

        $(function () {
            $('#select_pro_option').change(function () {
                window.location.href = '/shop/shop/index?&order=' + jQuery(this).find('option:selected').val();
            });
        });

    </script>
<?php } ?>