<?php
use common\components\ClaHost;
use common\models\Province;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<div class="site52_pro_col12_nhathau">
    <div class="container_fix">
        <div class="pro_flex">
            <div class="site51_profil_col3_locsanpham">
                <div class="locsanpham">
                    <?php if (isset($provinces) && $provinces): ?>
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
                    <?php endif; ?>

                    <?php if (isset($category_product) && $category_product): ?>
                        <div class="pro_fitler">
                            <div class="pro_env">
                                <span class="content_15_b">Loại</span><i class="fas fa-chevron-right"></i>
                            </div>
                            <div class="fitler">
                                <?php foreach ($category_product as $key => $cat):
                                    $checked = \common\components\ClaUrl::getValueFieldToUrl('category_id');
                                    $url = \common\components\ClaUrl::setLink($cat['id'], 'category_id');
                                    ?>
                                    <div class="fitler_flex">
                                        <div>
                                            <input onclick="change_link(this)" type="radio" id="category_id<?= $cat['id'] ?>"
                                                   name="category_id" value="<?= $cat['id'] ?>"
                                                   data-url="<?= $url ?>" <?= $checked && $checked == $cat['id'] ? 'checked' : '' ?>>
                                            <label for="category_id<?= $cat['id'] ?>"><?= $cat['name'] ?></label>
                                        </div>
                                        <span>15</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($brands) && $brands): ?>
                        <div class="pro_fitler">
                            <div class="pro_env">
                                <span class="content_15_b">Thương hiệu</span><i class="fas fa-chevron-right"></i>
                            </div>
                            <div class="fitler">
                                <?php foreach ($brands as $key => $brand):
                                    $checked = \common\components\ClaUrl::getValueFieldToUrl('brand');
                                    $url = \common\components\ClaUrl::setLink($key, 'brand');
                                    ?>
                                    <div class="fitler_flex">
                                        <div>
                                            <input onclick="change_link(this)" type="radio" id="brands<?= $key ?>"
                                                   name="brand_id" value="<?= $key ?>"
                                                   data-url="<?= $url ?>" <?= $checked && $checked == $key ? 'checked' : '' ?>>
                                            <label for="brands<?= $key ?>"><?= $brand ?></label>
                                        </div>
                                        <span>15</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($option_price) && $option_price) { ?>
                        <div class="pro_fitler">
                            <div class="pro_env">
                                <span class="content_15_b">Khoảng giá</span><i class="fas fa-chevron-right"></i>
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
                                                   for="price_fitler<?= $price['id'] ?>"><?= \common\components\ClaMeter::genMoneyText($price['price_min'],$price['price_max']) ?></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

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
                            <h3>THIẾT BỊ CÔNG NGHIỆP</h3>
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
                    if(isset($data) && count($data)) {
                        echo frontend\widgets\html\HtmlWidget::widget([
                            'input' => [
                                'products' => $data
                            ],
                            'view' => 'view_product_1'
                        ]);
                    }
                    else { ?>
                    <div class="default_view">
                        <i class="fas fa-bomb" style="color:#289300"></i>
                        Rất tiếc! Không tìm thấy sản phẩm mà bạn cần tìm.
                        <a href="<?= \yii\helpers\Url::to(['/product/product/index']) ?>">Quay lại</a>
                    </div>
                    <?php } ?>
                </div>
                <?=
                yii\widgets\LinkPager::widget([
                    'pagination' => new yii\data\Pagination([
                        'pageSize' => $limit,
                        'totalCount' => $totalitem
                    ])
                ]);
                ?>

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
