<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\models\product\ProductCategory;
use common\models\affiliate\AffiliateConfig;
use common\models\affiliate\AffiliateLink;
use common\models\product\Product;

//
$categories = ProductCategory::getAllCategory();
$dataCategory = array_column($categories, 'name', 'id');
//
$config = AffiliateConfig::getAffiliateConfig();
?>

<div class="form-create-store">
    <div class="infor-account">
        <h2>
            Danh sách Link
        </h2>
    </div>
    <div class="ctn-donhang tab-menu-read tab-menu-read-1" style="display: block;">
        <div class="item-info-donhang">
            <div class="table-donhang table-shop">
                <table>
                    <tbody>
                        <tr class="header-table">
                            <td>
                                <b>Ảnh</b>
                            </td>
                            <td class="center nowrap">
                                <b>Link</b>
                            </td>
                            <td class="center nowrap">
                                <b>Thống kê</b>
                            </td>
                        </tr>
                        <?php
                        foreach ($data as $item) {
                            $product = Product::findOne($item['object_id']);
                            ?>
                            <tr>
                                <td>
                                    <p>
                                        <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's100_100/', $product['avatar_name'] ?>" alt="<?= $product['name'] ?>" />
                                    </p>
                                </td>
                                <td class="center" width="40%">
                                    <p>
                                        <?= $item['link'] ?>
                                    </p>
                                </td>
                                <td class="center" width="40%">
                                    <p>
                                        <b>Xem</b>
                                    </p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>