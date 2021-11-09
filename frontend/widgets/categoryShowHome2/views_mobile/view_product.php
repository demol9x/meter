<?php

use yii\helpers\Url;
use common\components\ClaHost;
?>

<?php if (isset($data) && $data) { ?>
    <div class="box-scroll-cate">

        <div class="content-inside-cate">
            <?php $i = 1;
            foreach ($data as $menu) {
                $products = \common\models\product\Product::getProduct([
                    'category_id' => $menu['id'],
                    'limit' => 4,
                    'page' => 1,
                    'order' => 'ishot DESC, id DESC'
                ]);
                if ($products) {
                    $link = Url::to(['/product/product/category/', 'id' => $menu['id'], 'alias' => $menu['alias']]); ?>
                    <div class="product-inhome" id="cate-number<?= $menu['id'] ?>">
                        <div class="container">
                            <div class="title-standard">
                                <h2>
                                    <a href="<?= $link ?>"><?= $menu['name'] ?></a>
                                </h2>
                                <a href="<?= $link ?>" class="view-more"><?= Yii::t('app', 'view_all') ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
                            </div>
                            <div class="pad-box">
                                <div class="row flex">
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="list-product-inhome-mobile">
                                            <?php

                                            if ($products) {
                                                echo frontend\widgets\html\HtmlWidget::widget([
                                                    'input' => [
                                                        'products' => $products
                                                    ],
                                                    'view' => 'view_product_1'
                                                ]);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $i++;
                } ?>
            <?php  } ?>
        </div>
    </div>
<?php } ?>