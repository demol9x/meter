<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\models\product\ProductCategory;
use common\models\affiliate\AffiliateConfig;
use common\models\affiliate\AffiliateLink;

//
$categories = ProductCategory::getAllCategory();
$dataCategory = array_column($categories, 'name', 'id');
//
$config = AffiliateConfig::getAffiliateConfig();
?>
<div class="form-create-store">
    <div class="infor-account">
        <h2>
            Lấy link affiliate
        </h2>
    </div>
    <div class="nav-donhang">
        <ul class="tab-menu">
            <li>
                <a href="<?= Url::to(['/profile/affiliate/index']) ?>" style="text-transform: uppercase"><?= Yii::t('app', 'all_product') ?></a>
            </li>
            <li class="active">
                <a href="javascript:void(0)" style="text-transform: uppercase"><?= Yii::t('app', 'product_design') ?></a>
            </li>
        </ul>
    </div>
    <div class="ctn-donhang tab-menu-read tab-menu-read-1" style="display: block;">
        <div class="item-info-donhang">
            <form method="GET" class="search-info-donhang">
                <input type="text" value="<?= isset($keyword) ? $keyword : '' ?>" name="keyword"
                       placeholder="Tìm kiếm sản phẩm">
            </form>
            <div class="table-donhang table-shop">
                <table>
                    <tbody>
                    <tr class="header-table">
                        <td>
                            <b><?= Yii::t('app', 'product') ?></b>
                        </td>
                        <td>
                            <b>Mã sản phẩm</b>
                        </td>
                        <td>
                            <b>Tác giả</b>
                        </td>
                        <td class="center">
                            <b><?= Yii::t('app', 'affiliate_percent') ?></b>
                        </td>
                        <td class="center">
                            <b>Mã ID giới thiệu</b>
                        </td>
                        <td class="center">
                            <b><?= Yii::t('app', 'create_link') ?></b>
                        </td>
                        <td class="center"><b>Click</b></td>
                        <td class="center"><b>Mua TC</b></td>
                    </tr>
                    <?php
                    $ids = array_column($links, 'object_id');
                    $data_com = array_column($links, 'link', 'object_id');
                    foreach ($products as $product) {
                        $url = Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']], true);
                        ?>
                        <tr>
                            <td class="vertical-top" width="400">
                                <div class="img">
                                    <a href="<?= $url ?>">
                                        <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>"
                                             alt="<?= $product['name'] ?>">
                                    </a>
                                </div>
                                <h2>
                                    <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                                </h2>
                                <em><?= isset($dataCategory[$product['category_id']]) ? $dataCategory[$product['category_id']] : '' ?></em>
                                <p class="price-donhang"><?= number_format($product['price'], 0, ',', '.') ?> đ</p>
                            </td>

                            <td>
                                <?= $product['code'] ?>
                            </td>

                            <td>
                                <?php
                                if(isset($product['designer_id']) && $product['designer_id']) {
                                    $user = \common\models\User::findOne($product['designer_id']);
                                    echo isset($user->username) ? $user->username : 'Bibi Gâu';
                                } else {
                                    echo 'Bibi Gâu';
                                }
                                ?>
                            </td>

                            <td class="center">
                                <div class="discout">
                                    <p>
                                        <?= $config['commission_order'] ?>%
                                    </p>
                                </div>
                            </td>

                            <td class="center">
                                <?php
                                if (in_array($product['id'], $ids)) {
                                    $affiliate_id = $links[$product['id']]['id'];
                                    echo $affiliate_id;
                                }
                                ?>
                            </td>

                            <td class="center">
                                <div class="get-link">
                                    <?php if (!in_array($product['id'], $ids)) { ?>
                                        <a onclick="createLink('<?= $url ?>', <?= $product['id'] ?>)"
                                           href="javascript:void(0)">Lấy link</a>
                                    <?php } else { ?>
                                        <a class="open-popup-link" href="#alert-getLink"
                                           data-link="<?= $links[$product['id']]['link'] ?>">Đã lấy link (Click xem)</a>
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                if (in_array($product['id'], $ids)) {
                                    $affiliate_id = $links[$product['id']]['id'];
                                    if(isset($allClick[$affiliate_id]) && $allClick[$affiliate_id]) {
                                        echo count($allClick[$affiliate_id]);
                                    } else {
                                        echo 0;
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (in_array($product['id'], $ids)) {
                                    $affiliate_id = $links[$product['id']]['id'];
                                    if(isset($allOrder[$affiliate_id]) && $allOrder[$affiliate_id]) {
                                        echo count($allOrder[$affiliate_id]);
                                    } else {
                                        echo 0;
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="paginate">
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
    <div class="ctn-donhang tab-menu-read tab-menu-read-2" style="display: none;">

    </div>

</div>

<div id="alert-getLink" class="white-popup mfp-hide">
    <div class="box-account">
        <div class="bg-pop-white">
            <div class="box-getlink">
                <span class="mfp-close"></span>
                <div class="textcopy">
                    <input id="linkcopy" value="">
                </div>
                <button onclick="copyText()">Copy Link</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function copyText() {
        /* Get the text field */
        var copyText = document.getElementById("linkcopy");

        /* Select the text field */
        copyText.select();

        /* Copy the text inside the text field */
        document.execCommand("copy");
    }

    function createLink(product_url, product_id) {
        $.getJSON(
            '<?= Url::to(['/profile/affiliate/create-link']) ?>',
            {url: product_url, type: <?= AffiliateLink::TYPE_PRODUCT ?>, object_id: product_id},
            function (data) {
                if (data.message == 'success') {
                    alert('Tạo Link thành công');
                    location.reload();
                }
            }
        );
    }

    $(document).ready(function () {
        $('.open-popup-link').click(function () {
            var link = $(this).attr('data-link');
            $('#linkcopy').val(link);
        });
        $('.open-popup-link').magnificPopup({
            type: 'inline',
            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        });
    });

</script>