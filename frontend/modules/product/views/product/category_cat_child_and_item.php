<div class="camket">
    <?=
    frontend\widgets\menu\MenuWidget::widget([
        'group_id' => 3,
        'view' => 'view_policy'
    ]);
    ?>
</div>
<div class="sort-by-tool">
    <h2>Sort by:</h2>
    <div class="container">
        <div class="item-sort-by">
            <select name="" id="">
                <option value="Material">Material</option>
                <option value="Material">Material 1</option>
                <option value="Material">Material 2</option>
                <option value="Material">Material 3</option>
                <option value="Material">Material 4</option>
            </select>
        </div>
        <div class="item-sort-by">
            <select name="" id="">
                <option value="Collection">Collection</option>
                <option value="Collection">Collection 1</option>
                <option value="Collection">Collection 2</option>
                <option value="Collection">Collection 3</option>
                <option value="Collection">Collection 4</option>
            </select>
        </div>
        <div class="item-sort-by">
            <select name="" id="">
                <option value="Product type">Product type</option>
                <option value="Product type">Product type</option>
                <option value="Product type">Product type</option>
                <option value="Product type">Product type</option>
                <option value="Product type">Product type</option>
            </select>
        </div>
        <div class="item-sort-by">
            <select name="" id="">
                <option value="Theme">Theme</option>
                <option value="Theme">Theme 1</option>
                <option value="Theme">Theme 2</option>
                <option value="Theme">Theme 3</option>
                <option value="Theme">Theme 4</option>
            </select>
        </div>
        <div class="item-sort-by">
            <select name="" id="">
                <option value="Other">Other</option>
                <option value="Other">Other 1</option>
                <option value="Other">Other 2</option>
                <option value="Other">Other 3</option>
                <option value="Other">Other 4</option>
            </select>
        </div>
    </div>
</div>
<?=
\frontend\widgets\productCategoryChild\productCategoryChildWidget::widget([
    'view' => 'cat_with_child_items',
    'getItems' => true,
    'category_id' => $category['id'],
])
?>
<?php
$this->registerJs(
    " $(\".owl-product-trangsuc\").owlCarousel({
            items: 4,
            lazyLoad: true,
            navigation: true,
            pagination: false,
            autoPlay: false,
            paginationSpeed: 500,
            navigationText: [\"<span class='fa fa-angle-left'></span>\", \"</span><span class='fa fa-angle-right'></span>\"],
            scrollPerPage: true,
            itemsDesktop: [1200, 4],
            itemsDesktopSmall: [992, 3],
            itemsTablet: [767, 2],
            itemsMobile: [560, 1],
        });",
    \yii\web\View::POS_END,
    'my-button-handler'
);
?>