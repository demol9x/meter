<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\components\ClaHost;
use common\models\affiliate\AffiliateLink;

/* @var $this yii\web\View */
/* @var $searchModel common\models\affiliate\search\AffiliateLinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thêm link giới thiệu';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .get-link a {
        display: inline-block;
        padding: 5px 5px;
        width: 75px;
        background: #17a349;
        color: #fff;
        border-radius: 3px;
    }

    .get-link a:hover {
        opacity: 0.8;
    }

    .affiliate-link-index .img {
        max-width: 100px;
        max-height: 50px;
        overflow: hidden;
    }

    .box-getlink .textcopy {
        overflow-x: auto;
        border: 1px dashed #ccc;
        padding: 7px 15px;
        background: #ebebeb;
        width: 100%;
    }

    .box-getlink .textcopy input {
        margin-bottom: 0px;
        white-space: nowrap;
        border: none;
        background: transparent;
        width: 100%;
    }

    .box-getlink button {
        white-space: nowrap;
        background: #17a349;
        border: none;
        color: #fff;
        padding: 0px 20px;
    }

    .box-getlink {
        max-width: 500px;
        margin: 0 auto;
        background: #fff;
        padding: 15px;
        display: flex;
        position: relative;
    }

    .box-getlink .mfp-close {
        background: #17a349 !important;
        top: -30px !important;
        opacity: 1;
        right: -30px !important;
        border-radius: 50%;
        cursor: pointer;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <div class="ctn-form">
        <div class="form">
            <form action="">
                <input type="" name="keyword" placeholder="Nhập tên sản phẩm" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                <button>Tìm kiếm</button>
            </form>
            <br />
        </div>
        <div class="affiliate-link-index">
            <table class="table table-bordered">
                <tbody>
                    <tr class="header-table">
                        <td>
                            <b><?= Yii::t('app', 'product') ?></b>
                        </td>
                        <td>
                            <b>Mã sản phẩm</b>
                        </td>
                        <td>
                            <b>Gian hàng</b>
                        </td>
                        <td class="center">
                            <b><?= Yii::t('app', 'affiliate_percent') ?></b>
                        </td>
                        <td class="center">
                        </td>
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
                                        <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
                                    </a>
                                </div>
                                <h5>
                                    <a href="<?= $url ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                                </h5>
                                <em><?= isset($dataCategory[$product['category_id']]) ? $dataCategory[$product['category_id']] : '' ?></em>
                                <p class="price-donhang"><?= number_format(\common\models\product\Product::getPriceStaticC1($product, MAX_QUANTITY_PRODUCT), 0, ',', '.') ?> <?= Yii::t('app', 'currency') ?></p>
                            </td>

                            <td>
                                <?= $product['id'] ?>
                            </td>

                            <td>
                                <?php
                                if (isset($product['shop_id']) && $product['shop_id']) {
                                    $shop = \common\models\shop\Shop::findOne($product['shop_id']);
                                    echo isset($shop->name) ? $shop->name : 'OCOP';
                                } else {
                                    echo 'OCOP';
                                }
                                ?>
                            </td>

                            <td class="center">
                                <div class="discout">
                                    <p>
                                        <?php
                                        if ($product['status_affiliate'] == \common\components\ClaLid::STATUS_ACTIVED && $product['shop_status_affiliate'] == \common\components\ClaLid::STATUS_ACTIVED && $product['affiliate_gt_product'] > 0) {
                                            echo $product['affiliate_gt_product'] . '%';
                                        } else {
                                            echo '<span class="red">0%</span>';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </td>

                            <td class="center">
                                <div class="get-link">
                                    <?php if (!in_array($product['id'], $ids)) { ?>
                                        <a onclick="createLink('<?= $url ?>', <?= $product['id'] ?>)" href="javascript:void(0)">Thêm link</a>
                                    <?php } else { ?>
                                        <a class="open-popup-link" href="#alert-getLink" data-link="<?= $links[$product['id']]['link'] ?>">Đã lấy link (Click xem)</a>
                                    <?php } ?>
                                </div>
                            </td>
                        <?php } ?>
                </tbody>
            </table>
            <div class="paginate">
                <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => new yii\data\Pagination([
                            'defaultPageSize' => $limit,
                            'totalCount' => $totalitem
                        ])
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div id="alert-getLink" class="white-popup mfp-hide">
    <div class="box-account">
        <div class="bg-pop-whites">
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
            '<?= Url::to(['/affiliate/affiliate-link/create-link']) ?>', {
                url: product_url,
                type: <?= AffiliateLink::TYPE_PRODUCT ?>,
                object_id: product_id
            },
            function(data) {
                if (data.message == 'success') {
                    alert('Tạo Link thành công');
                    location.reload();
                }
            }
        );
    }

    $(document).ready(function() {
        $('.open-popup-link').click(function() {
            var link = $(this).attr('data-link');
            $('#linkcopy').val(link);
        });
        $('.open-popup-link').magnificPopup({
            type: 'inline',
            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        });
    });
</script>