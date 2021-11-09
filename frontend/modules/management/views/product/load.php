<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
    <div class="item-product-inhome">
        <div class="img">
            <a href="">
            </a>
        </div>
        <h3>
        </h3>
        <p class="price">
            <del>300.000đ</del>200.000đ/kg
        </p>
        <div class="review">
            <div class="star">
                <i class="fa fa-star yellow"></i>
                <i class="fa fa-star yellow"></i>
                <i class="fa fa-star yellow"></i>
                <i class="fa fa-star yellow"></i>
                <i class="fa fa-star yellow"></i>
                <span>(50)</span>
            </div>
            <div class="wishlist">
                <a href=""><i class="fa fa-heart-o"></i></a>
            </div>
            <div class="car-ship">
                <i class="fa fa-truck"></i>
            </div>
        </div>
        <div class="add-product-manager">
            <a href="<?= \yii\helpers\Url::to(['/management/product/create']) ?>">
            <button>
                <span class="plus-circle"><i class="fa fa-plus"></i></span>
                <p><?= Yii::t('app', 'add_new_product') ?></p>
            </button>
            </a>
        </div>
    </div>
</div>
<?php 
    if($products) {
        echo frontend\widgets\html\HtmlWidget::widget([
            'input' => [
                'products' => $products,
                'div_col' => '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">'
            ],
            'view' => 'view_product_tool_1'
        ]);
        ?>  
        <div class="paginate paginate-load">
            <?=
                yii\widgets\LinkPager::widget([
                    'pagination' => new yii\data\Pagination([
                        'pageSize' => $limit,
                        'totalCount' => $totalitem
                    ])
                ]);
            ?>    
        </div>
        <?php 
    }
?>