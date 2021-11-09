<?php

use common\components\ClaHost;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<div class="banner-inpage">
    <div class="container">
        <?php
        if (!$category->bgr_name) {
            echo \frontend\widgets\banner\BannerWidget::widget([
                'view' => 'aimg',
                'limit' => 1,
                'group_id' => 3,
                'category_id' => $category->id
            ]);
        } else { ?>
            <a title="banner-trong">
                <img src="<?= ClaHost::getImageHost(), $category['bgr_path'], $category['bgr_name'] ?>" alt="<?= $category->name ?>">
            </a>
        <?php } ?>
    </div>
</div>
<div class="section-product">
    <div class="container">
        <div class="left-filter">
            <div class="option-filter">
                <?= \frontend\widgets\menuCategory\MenuCategoryWidget::widget([
                    'view' => 'menu_product_left_all',
                    'parent' => $category->id,
                    'cat_parent' => $category->parent,
                ])
                ?>
            </div>
            <?= \frontend\widgets\html\HtmlWidget::widget([
                'view' => 'search_advance_category',
            ])
            ?>
        </div>
        <div class="product-in-store">
            <div class="row-5-flex multi-columns-row">
                <?php if (isset($data) && $data) { ?>
                    <?= frontend\widgets\html\HtmlWidget::widget([
                        'input' => [
                            'products' => $data,
                            'div_col' => '<div class="col-lg-5-12-item">'
                        ],
                        'view' => 'view_product_1'
                    ]);
                    ?>
                <?php } else { ?>
                    <div class="" style="padding: 20px;">
                        <?= $allow ? Yii::t('app', 'havent_product') : 'Bạn không thuộc nhóm người dùng có thể mua sản phẩm danh mục này.' ?>
                    </div>
                <?php } ?>
            </div>
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