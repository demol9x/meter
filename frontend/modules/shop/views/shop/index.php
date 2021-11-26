<?php

use yii\helpers\Url;

?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/list_packages.css">
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner-main-in',
    'group_id' => 5,
])
?>
<style>
    .hidden {
        display: none;
    }
</style>
<div class="site52_pro_col12_nhathau">
    <div class="container_fix">
        <div class="pro_flex">
            <div class="site51_profil_col3_locsanpham">
                <div class="locsanpham">
                    <?php if ($provinces) { ?>
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
                    <?php } ?>
                    <?php if ($option_price) { ?>
                        <div class="pro_fitler">
                            <div class="pro_env">
                                <span class="content_16_b">Vốn điều lệ</span><i class="fas fa-chevron-right"></i>
                            </div>
                            <div class="fitler">
                                <?php foreach ($option_price as $key => $price) {
                                    $checked = \common\components\ClaUrl::getValueFieldToUrl('id_price');
                                    $url = \common\components\ClaUrl::setLink($price['id'], 'id_price');
                                    ?>
                                    <div class="fitler_flex">
                                        <div>
                                            <input class="price_op_click" onclick="change_link(this)" type="radio"
                                                   id="price_fitler<?= $price['id'] ?>" name="price"
                                                   value="<?= $price['id'] ?>" <?= $checked && $checked == $price['id'] ? 'checked' : '' ?>
                                                   data-url="<?= $url ?>">
                                            <label class="price_op_click"
                                                   for="price_fitler<?= $price['id'] ?>"><?= $price['price_min'] . '-' . $price['price_max'] . ' Triệu' ?></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="site52_pro_col10_nhathau">
                <div class="pro_package">
                    <div class="pro_content">
                        <div class="content_text">
                            <h3>nhà thầu</h3>
                        </div>
                        <div class="pro_select_env">
                            <div class="pro_select">
                                <span>Sắp xếp:</span>
                                <select id="select_pro_option" name="sort">
                                    <option data-url="<?= \common\components\ClaUrl::setLink('name', 'sort') ?>" value="name" <?= isset($_GET['sort']) && $_GET['sort'] == 'name' ? 'selected' : '' ?>>
                                        A-Z
                                    </option>
                                    <option data-url="<?= \common\components\ClaUrl::setLink('new', 'sort') ?>" value="new" <?= isset($_GET['sort']) && $_GET['sort'] == 'new' ? 'selected' : '' ?>>
                                        Mới nhất
                                    </option>
                                    <option data-url="<?= \common\components\ClaUrl::setLink('rate', 'sort') ?>" value="rate" <?= isset($_GET['sort']) && $_GET['sort'] == 'rate' ? 'selected' : '' ?>>
                                        Đánh giá
                                    </option>
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
                    <?php
                    if (isset($users) && $users) {
                        ?>
                        <div class="pro_flex" id="wrapper">
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
                        </div>
                    <?php } else { ?>
                        <div class=""
                             style="width: 100%;color: #289300;background: #ffffff; border: 1.5px solid #289300; height: 50px; display: flex; justify-content: center;align-items: center">
                            <i class="fas fa-bomb" style="color:#289300 "></i> Rất tiếc! Không thấy doanh nghiệp mà bạn
                            cần tìm.
                            <a href="<?= \yii\helpers\Url::to(['/shop/shop/index']) ?>">Quay lại</a>
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
        var dn_id = $(this).data('id');
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/shop/shop/add-like']) ?>",
            type: "get",
            data: {"dn_id": dn_id},
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

    $(function () {
        $('#select_pro_option').change(function () {
            var sort = jQuery(this).find('option:selected');
            window.location.href = sort.data('url');
        });
    });

</script>
