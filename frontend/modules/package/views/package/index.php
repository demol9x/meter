<?php

use common\components\ClaHost;
use common\models\Province;
use yii\helpers\Url;
use common\components\ClaLid;
use common\components\ClaMeter;

?>
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner-main-in',
    'group_id' => 5,
])
?>
<div class="site52_pro_col12_nhathau">
    <div class="container_fix">
        <div class="pro_flex">
            <div class="site51_profil_col3_locsanpham">
                <div class="locsanpham">
                    <?php if ($provinces) { ?>
                        <div class="pro_fitler">
                            <div class="pro_env">
                                <span class="content_15_b">Địa điểm</span><i class="fas fa-chevron-right"></i>
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
                    <?php } ?>
                    <div class="pro_fitler">
                        <div class="pro_env">
                            <span class="content_15_b">Khoảng cách</span><i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="fitler">
                            <div class="fitler_flex">
                                <div>
                                    <input type="radio" id="10-50" name="10-50" value="10-50" checked>
                                    <label for="10-50"> 10 - 50 km</label>
                                </div>
                                <span>15</span>
                            </div>
                        </div>
                    </div>
                    <div class="pro_fitler">
                        <div class="pro_env">
                            <span class="content_15_b">Ngày đăng</span><i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="fitler">
                            <div class="fitler_flex">
                                <div>
                                    <input onclick="change_link(this)" type="radio" id="moinhat1" name="moinhat" value="very_new" data-url="<?= \common\components\ClaUrl::setLink('very_new', 'fitler') ?>" <?= isset($_GET['fitler']) && $_GET['fitler'] == 'very_new' ? 'checked' : '' ?> >
                                    <label for="moinhat1"> Mới nhất</label>
                                </div>
                            </div>

                            <div class="fitler_flex">
                                <div>
                                    <input  onclick="change_link(this)" type="radio" id="tuantruoc" name="moinhat" value="week" data-url="<?= \common\components\ClaUrl::setLink('week', 'fitler') ?>" <?= isset($_GET['fitler']) && $_GET['fitler'] == 'week' ? 'checked' : '' ?>>
                                    <label for="tuantruoc"> Tuần trước</label>
                                </div>
                            </div>
                            <div class="fitler_flex">
                                <div>
                                    <input onclick="change_link(this)" type="radio" id="thangtruoc" name="moinhat" value="month" data-url="<?= \common\components\ClaUrl::setLink('month', 'fitler') ?>" <?= isset($_GET['fitler']) && $_GET['fitler'] == 'month' ? 'checked' : '' ?>>
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
                            <h3>gói thầu</h3>
                        </div>
                        <div class="pro_select_env">
                            <?php //Menu main
                            echo frontend\widgets\packageFilter\PackageFilterWidget::widget([
                                'view' => 'view_sort'
                            ]);
                            ?>
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
                    <?php
                    if (isset($data) && $data) {
                        ?>
                        <div class="pro_flex" id="wrapper">
                            <?php
                            $i = 3;
                            foreach ($data as $key) {
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
                                                <span><?= isset($key['province_id']) && $key['province_id'] ? $provin->name : 'Đang cập nhật' ?></span>
                                                <?php if(isset($km_shop) && $km_shop){
                                                    $km_qd= explode(',',$key['latlng']);
                                                    ?>
                                                <span>
                                                    <?php
                                                    if(isset($km_qd) && $km_qd){
                                                    ?>
                                                        <?php echo  (int)ClaMeter::betweenTwoPoint($km_shop[0],$km_shop[1], $km_qd[0], $km_qd[1]) . 'km'; ?>
                                                    <?php }?>
                                                </span>
                                                <?php }?>
                                            </div>
                                            <div class="date_time">
                                                <img src="<?= yii::$app->homeUrl ?>images/time_pro.png" alt="">
                                                <span><?= date('d', $key['updated_at']) ?></span>/<span><?= date('m', $key['updated_at']) ?></span>/<span><?= date('Y', $key['updated_at']) ?></span>
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
                    <?php } else { ?>
                        <div class="default_view">
                            <i class="fas fa-bomb" style="color:#289300 "></i>
                            Rất tiếc! Không tìm thấy gói thầu mà bạn cần tìm.
                            <a href="<?= \yii\helpers\Url::to(['/package/package/index']) ?>">Quay lại</a>
                        </div>
                    <?php } ?>
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