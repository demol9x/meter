<?php
use yii\helpers\Url;
use common\components\ClaHost;
$banners = \common\models\banner\Banner::getBannerGroupId(7);
?>

<?php if (isset($data) && $data) { ?>
    <style>
        .list-product-inhome .item-product-inhome {
            width: 200px;
        }
    </style>
    <div class="box-scroll-cate">
        <div class="side-bar-cate leftSidebar">
            <div id="mainNav">
                <ul class="list-icon-cate">
                    <?php $kt= 1; foreach ($data as $menu) if($menu['icon_name']) {  ?>
                        <li class="" title="<?= $menu['name'] ?>">
                            <a href="#cate-number<?= $menu['id'] ?>" class="nav-link js-scroll-trigger <?php if($kt) {echo "active"; $kt=0;} ?>">
                                <span>
                                    <img src="<?= ClaHost::getImageHost(), $menu['icon_path'], $menu['icon_name'] ?>" alt="<?= $menu['name'] ?>">
                                </span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="content-inside-cate">
            <?php $i= 1; foreach ($data as $menu) { 
                $products = \common\models\product\Product::getProduct([
                                        'category_id' => $menu['id'],
                                        'limit' => 4,
                                        'page' => 1,
                                        'order' => 'ishot DESC, id DESC'
                                    ]);
                $categorys = \common\models\product\ProductCategory::getItemChildLimit($menu['id'], 5);
                if($products) {
                    $link = Url::to(['/product/product/category/', 'id' => $menu['id'], 'alias' => $menu['alias']]);
                    
                    $linkb ='';
                    $src = '';
                    if($banners) {
                        if(isset($banners[$menu['id']])) {
                            $linkb = $banners[$menu['id']]['link'];
                            $src = $banners[$menu['id']]['src'];
                        } else {
                            foreach ($banners as $banner) {
                                $linkb = $banner['link'];
                                $src = $banner['src'];
                                break;
                            }
                        }
                    } 
                    ?>
                    <div class="product-inhome" id="cate-number<?= $menu['id'] ?>">
                        <div class="container">
                            <div class="title-standard <?= $categorys ? 'border' : '' ?>">
                                <h2>
                                    <a href="<?= $link ?>"><?= $menu['name'] ?></a>
                                </h2>
                                <a href="<?= $link ?>" class="view-more"><?=  Yii::t('app', 'view_all') ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
                                <?php if($categorys) { ?>
                                    <ul class="cate-sub-index">
                                        <?php foreach ($categorys as $cati) { ?>
                                            <li>
                                                <a href="<?= Url::to(['/product/product/category', 'id' => $cati['id'], 'alias' => $cati['alias']]) ?>"><?= $cati['name'] ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                            <div class="pad-box">
                                <div class="row flex">
                                    <?php if($i%2 && $src) { ?>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 border-right hidden-xs hidden-sm">
                                            <div class="banner-cate-inhome relative">
                                                <a class="hidden-loading-content" <?= $linkb ? 'href="'. $linkb.'"' : '' ?>>
                                                    <img  class="lazy" alt="<?= $menu['name'] ?>"  data-src="<?= $src ?>" />
                                                </a>
                                                <div class="loading-content-gca">
                                                    <div class="box-thumbnail"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="list-product-inhome">
                                           <?php 
                                                
                                                if($products) {
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
                                    <?php if(!($i%2) && $src) { ?>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 border-left  hidden-xs hidden-sm">
                                            <div class="banner-cate-inhome relative">
                                                <a class="hidden-loading-content" <?= $linkb ? 'href="'. $linkb.'"' : '' ?>>
                                                    <img class="lazy" alt="<?= $menu['name'] ?>"  data-src="<?= $src ?>" />
                                                </a>
                                                <div class="loading-content-gca">
                                                    <div class="box-thumbnail"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?=
                        \frontend\widgets\banner\BannerQcWidget::widget([
                            'view' => 'banner_qc',
                            'group_id' => \common\components\ClaLid::getIdQc('index-cat'),
                            'limit' => 1,
                            'stt' => $i,
                        ])
                    ?>
                <?php $i++; }
            } ?>
        </div>
    </div>
<?php } ?>