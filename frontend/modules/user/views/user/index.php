<?php

?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/list_packages.css">

<div class="site51_bann_col0_slidein">
    <div class="bann_in">
        <img src="<?= yii::$app->homeUrl ?>images/site51_bann_col0_slidein.png" alt="">
    </div>
</div>
<div class="site52_pro_col12_nhathau">
    <div class="container_fix">
        <div class="pro_flex">
            <div class="site51_profil_col3_locsanpham">
                <div class="locsanpham">
                    <?php if ($provinces): ?>
                        <div class="pro_fitler">
                            <div class="pro_env">
                                <span class="content_16_b">Địa điểm</span><i class="fas fa-chevron-right"></i>
                            </div>
                            <div class="fitler croll">
                                <?php foreach ($provinces as $key => $province):
                                    $checked = \common\components\ClaUrl::getValueFieldToUrl('province_id');
                                    $url = \common\components\ClaUrl::setLink($key, 'province_id');
                                    ?>
                                    <div>
                                        <input onclick="change_link(this)" type="radio" id="province_fillter<?= $key ?>"
                                               name="province_id"
                                               value="<?= $key ?>" <?= $checked && $checked == $key ? 'checked' : '' ?>
                                               data-url="<?= $url ?>">
                                        <label for="province_fillter<?= $key ?>"> <?= $province ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($jobs): ?>
                        <div class="pro_fitler">
                            <div class="pro_env">
                                <span class="content_16_b">Chức danh</span><i class="fas fa-chevron-right"></i>
                            </div>
                            <div class="fitler">
                                <?php foreach ($jobs as $key => $job):
                                    $checked = \common\components\ClaUrl::getValueFieldToUrl('job_id');
                                    $url = \common\components\ClaUrl::setLink($key, 'job_id');
                                    ?>
                                    <div class="fitler_flex">
                                        <div>
                                            <input onclick="change_link(this)" type="radio" id="jobs<?= $key ?>"
                                                   name="job_id" value="<?= $key ?>"
                                                   data-url="<?= $url ?>" <?= $checked && $checked == $key ? 'checked' : '' ?>>
                                            <label for="jobs<?= $key ?>"><?= $job ?></label>
                                        </div>
<!--                                        <span>15</span>-->
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($kns): ?>
                        <div class="pro_fitler">
                            <div class="pro_env">
                                <span class="content_16_b">Kinh nghiệm làm việc</span><i
                                        class="fas fa-chevron-right"></i>
                            </div>
                            <div class="fitler">
                                <?php foreach ($kns as $key => $kn):
                                    $checked = \common\components\ClaUrl::getValueFieldToUrl('kn');
                                    $url = \common\components\ClaUrl::setLink($key, 'kn');
                                    ?>
                                    <div class="fitler_flex">
                                        <div>
                                            <input onclick="change_link(this)" type="radio" id="kn<?= $key ?>" name="kn"
                                                   value="<?= $key ?>"
                                                   data-url="<?= $url ?>" <?= $checked && $checked == $key ? 'checked' : '' ?>>
                                            <label for="kn<?= $key ?>"> <?= $kn ?></label>
                                        </div>
<!--                                        <span>15</span>-->
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="pro_fitler">
                        <div class="pro_env">
                            <span class="content_16_b">Ngày đăng</span><i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="fitler">
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="moinhat" name="moinhat" value="moinhat" checked>
                                    <label for="moinhat"> Mới nhất</label>
                                </div>
                            </div>

                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="tuantruoc" name="tuantruoc" value="tuantruoc">
                                    <label for="tuantruoc"> Tuần trước</label>
                                </div>
                            </div>
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="thangtruoc" name="thangtruoc" value="thangtruoc">
                                    <label for="thangtruoc"> Tháng trước</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site52_pro_col10_nhathau">
                <div class="pro_package">
                    <div class="pro_content">
                        <div class="content_text">
                            <h3>tìm thợ</h3>
                        </div>
                        <div class="pro_select_env">
                            <div class="pro_select">
                                <span>Sắp xếp:</span>
                                <select>
                                    <option value="">Cao - Thấp</option>
                                    <option value="">A-Z</option>
                                    <option value="">Mới nhất</option>
                                </select>
                            </div>
                            <div class="buttons">
                                <div class="list active">
                                    <img src="<?= yii::$app->homeUrl ?>images/img_sapxep_1.png" alt="">
                                </div>
                                <div class="grid">
                                    <img src="<?= yii::$app->homeUrl ?>images/img_sapxep_2.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pro_flex" id="wrapper">
                        <?php if ($users): ?>
                            <?php foreach ($users as $user):
                                $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                                if (isset($user['user']['avatar_path']) && $user['user']['avatar_path']) {
                                    $avatar_path = \common\components\ClaHost::getImageHost() . $user['user']['avatar_path'] . $user['user']['avatar_name'];
                                }
                                ?>

                                <div class="pro_card wow fadeIn" data-wow-delay="0.7s">
                                    <a href="chitietgoitho.php">
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
                                        <span class="iuthik1 <?= in_array($user['user_id'], $us_wish) ? 'active' : '' ?>"><i
                                                    class="fas fa-heart"></i></span>
                                    </label>
                                    <div class="hot_product">
                                        <!--                                        <img src="images/hot_product.png" alt="">-->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pagination">
                    <?php
                    $pagination = new \yii\data\Pagination(['totalCount' => $totalitem, 'pageSize' => $limit]);

                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function change_link(t) {
        var url = $(t).data('url');
        window.location.href = url;
    }
</script>
