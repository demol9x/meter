<?=
\frontend\widgets\productCategoryChild\productCategoryChildWidget::widget([
    'view' => 'cat_with_child',
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

<div class="cat-material">
    <div class="container">
        <div class="index_col_title white-bg">
            <div class="collection-name">
                <h3>
                    <a href="">
                         <img src="images/icon-logo.png" alt="">SHOP BY STYLE
                    </a>
                </h3>
            </div>
            <div class="collection-link">
                <a href="#">Xem tất cả</a>
            </div>
        </div>
        <div class="material-slider">
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/product1.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Stackable</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/product2.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Antique Style</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/product3.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Enternity</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/product4.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Halo</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/product5.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Religious</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/product6.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Nature</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/product7.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Heart</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/product2.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Eternity</a></h3>
            </div>
        </div>
    </div>
</div>
<div class="cat-material">
    <div class="container">
        <div class="index_col_title white-bg">
            <div class="collection-name">
                <h3>
                    <a href="">
                         <img src="images/icon-logo.png" alt="">SHOP BY STONE
                    </a>
                </h3>
            </div>
            <div class="collection-link">
                <a href="#">Xem tất cả</a>
            </div>
        </div>
        <div class="material-slider" style="margin-top: 30px;">
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/ww1.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Stackable</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/ww2.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Antique Style</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/emerald-diamond.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Enternity</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/ruby-diamond.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Halo</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/ww1.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Stackable</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/ww2.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Antique Style</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/emerald-diamond.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Enternity</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/ruby-diamond.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Halo</a></h3>
            </div>
        </div>
    </div>
</div>
<div class="cat-material">
    <div class="container">
        <div class="index_col_title white-bg">
            <div class="collection-name">
                <h3>
                    <a href="">
                         <img src="images/icon-logo.png" alt="">SHOP BY SHAPE
                    </a>
                </h3>
            </div>
            <div class="collection-link">
                <a href="#">Xem tất cả</a>
            </div>
        </div>
        <div class="material-slider" style="margin-top: 30px;">
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/round.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Stackable</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/oval.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Antique Style</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/princess.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Enternity</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/heart_shapes.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Halo</a></h3>
            </div>
            
        </div>
    </div>
</div>
<div class="cat-material">
    <div class="container">
        <div class="index_col_title white-bg">
            <div class="collection-name">
                <h3>
                    <a href="">
                         <img src="images/icon-logo.png" alt="">SHOP BY SETTING
                    </a>
                </h3>
            </div>
            <div class="collection-link">
                <a href="#">Xem tất cả</a>
            </div>
        </div>
        <div class="material-slider" style="margin-top: 30px;">
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/prong.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Prong</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/invisible.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Bezel</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/prong.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Pave</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/invisible.jpg" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">Micro Pave</a></h3>
            </div>
        </div>
    </div>
</div>
<div class="cat-material">
    <div class="container">
        <div class="index_col_title white-bg">
            <div class="collection-name">
                <h3>
                    <a href="">
                         <img src="images/icon-logo.png" alt="">SHOP BY SHAPE
                    </a>
                </h3>
            </div>
            <div class="collection-link">
                <a href="#">Xem tất cả</a>
            </div>
        </div>
        <div class="material-slider" style="margin-top: 30px;">
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/yellow-gold.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">14K White Gold</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/white-gold.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">14K Yellow Gold</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/yellow-gold.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">14K Rose Gold</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/white-gold.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">18K White Gold</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/yellow-gold.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">18K Yellow Gold</a></h3>
            </div>
            <div class="item-material">
                <div class="img-item-material">
                    <a href="#">
                        <img src="images/white-gold.png" alt="Stackable" title="Stackable">
                    </a>
                </div>
                <h3><a href="">18K Rose Gold</a></h3>
            </div>
        </div>
    </div>
</div>
<section class="row no-gutter">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 pb10">
        <?=
            \frontend\widgets\productAttr\ProductAttrWidget::widget([
                'view' => 'new_most',
                'title' => Yii::t('app','new'),
                // 'attr' => ['isnew' => 1],
                'limit' => 1
                ]
        )
        ?>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 pb10">
        <?=
            \frontend\widgets\productAttr\ProductAttrWidget::widget([
                'view' => 'new_most',
                'title' => Yii::t('app','like'),
                'order' => 'rate DESC, rate_count DESC, id DESC',
                'limit' => 1
                ]
        )
        ?>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $('.material-slider').slick({
            slidesToShow: 7,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            infinite: false,
            focusOnSelect: true,
            responsive: [
            {
              breakpoint: 1200,
              settings: {
                slidesToShow: 5,
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 4,
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            }
          ]
        });
    });
</script>