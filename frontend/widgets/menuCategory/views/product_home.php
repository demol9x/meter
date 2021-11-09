<?php
use yii\helpers\Url;
use common\components\ClaHost;

?>
<?php if (isset($data) && $data) { ?>
	<div class="product-inhome">
	    <div class="container">
	        <div class="title-standard">
	            <h2>
	                <a href="#">Sản phẩm hot</a>
	            </h2>
	            <!--<a href="#" class="view-more"><?= Yii::t('app', 'view_all') ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>-->
	        </div>
	        <div class="tab-cate-product">
			    <ul>
			        <?php $kt= 1; foreach ($data as $menu) { ?>
			            <li style="<?php if($kt) {echo "background: #ebebeb"; $kt=0;} ?>" class="chang-product-home category-<?= $menu['id'] ?>" data='<?= $menu['id'] ?>'>
		                    <div class="img">
		                        <div class="vertical">
		                            <div class="middle">
		                                <a>
		                                    <img src="<?= ClaHost::getImageHost(), $menu['icon_path'], $menu['icon_name'] ?>" alt="<?= $menu['name'] ?>" alt="<?= $menu['name'] ?>">
		                                </a>
		                            </div>
		                        </div>
		                    </div>
		                    <h2>
		                        <a><?= $menu['name'] ?></a>
		                    </h2>
		                </li>
			        <?php } ?>
			    </ul>
	        </div>
	        <div class="list-product-inhome slider-product-index" id="box-slider-product-index">
	           <?php 
           		$products = \common\models\product\Product::getProduct([
					                    'category_id' => $data[0]['id'],
					                    'limit' => 12,
					                    'page' => 1,
					        ]);
				if($products)
					foreach ($products as $product) {
						echo frontend\widgets\html\HtmlWidget::widget([
                            'input' => [
                                'product' => $product
                            ],
                            'view' => 'view_product_1'
                        ]);
					}
	           ?>
	        </div>
	    </div>
	</div>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('.chang-product-home').click(function() {
			$('.chang-product-home').css('background','unset');
			$(this).css('background','#ebebeb');
			var cat_id = $(this).attr('data');
			$.ajax({
				url: "<?= \yii\helpers\Url::to(['/product/product/get-product-home']) ?>",
				data:{cat_id: cat_id},
				success: function(result){
		        	$('#box-slider-product-index').slick('unslick').slick('reinit');
		        	$('#box-slider-product-index').html(result);
		        	$('.item-product-inhome .img a').height($('.item-product-inhome .img').width() * 0.9);
		        	$('#box-slider-product-index').slick({
				        slidesToShow: 6,
				        slidesToScroll: 2,
				        dots: false,
				        arrows: true,
				        // autoplay: true,
				        // infinite: true,
				        speed: 1500,
				        // autoplaySpeed: 2000,
				        focusOnSelect: true,
				         onInit: function() {
				            console.log('slider was initialized');
				        },
				        responsive: [
				        {
				          breakpoint: 1200,
				          settings: {
				            slidesToShow: 4,
				          }
				        },
				        {
				          breakpoint: 767,
				          settings: {
				            slidesToShow: 3,
				          }
				        },
				        {
				          breakpoint: 600,
				          settings: {
				            slidesToShow: 3,
				            slidesToScroll: 3,
				            speed: 500,
				            variableWidth: true
				          }
				        },
				        {
				          breakpoint: 400,
				          settings: {
				            slidesToShow: 2,
				            slidesToScroll: 1,
				            speed: 500,
				            variableWidth: true
				          }
				        }
				      ]
				    });
			    }
			});
		});
	})
</script>