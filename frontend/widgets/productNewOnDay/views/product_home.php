<?php

use yii\helpers\Url;
use common\components\ClaHost;

?>

<?php if (isset($data) && $data) { ?>
	<div class="product-inhome box-tabcate-index">
		<div class="container">
			<div class="tab-cate-product">
				<h2>
					<a class="chang-product-home" data=''><?= Yii::t('app', 'fresh_once_day') ?></a>
				</h2>
				<ul class="slide-tab-cate owl-carousel owl-theme">
					<?php
					foreach ($data as $menu) { ?>
						<li class="chang-product-home category-<?= $menu['id'] ?>" data='<?= $menu['id'] ?>'>
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
			<div id="box-slider-product-index">
				<div class="list-product-inhome slider-product-index owl-carousel owl-theme">
					<?php
					$products = \common\models\product\Product::getProduct([
						// 'category_id' => $data[0]['id'],
						'limit' => 18,
						'isnew' => 1,
						'order' => 'id DESC ',
						'page' => 1,
					]);
					if ($products) {
						echo frontend\widgets\html\HtmlWidget::widget([
							'input' => [
								'products' => $products
							],
							'view' => 'view_product_1nl'
						]);
					}
					?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.chang-product-home').click(function() {
			$('.chang-product-home').css('background', 'unset');
			$(this).css('background', '#ebebeb');
			var cat_id = $(this).attr('data');
			$.ajax({
				url: "<?= \yii\helpers\Url::to(['/product/product/get-product-home']) ?>",
				data: {
					cat_id: cat_id
				},
				success: function(result) {
					$('#box-slider-product-index').html('<div class="list-product-inhome slider-product-index owl-carousel owl-theme">' + result + '</div>');
					$('.slider-product-index').owlCarousel({
						items: 6,
						loop: false,
						margin: 10,
						merge: true,
						dots: false,
						nav: true,
						lazyLoad: true,
						autoWidth: true,
						autoplay: true,
						autoplayTimeout: 6000,
						autoplaySpeed: 2000,
						responsive: {
							0: {
								margin: 5,
							},
							480: {
								margin: 5,
							},
							1200: {
								margin: 10,
							},
						}
					});
					$('.lazy').Lazy({
						// your configuration goes here
						scrollDirection: 'vertical',
						effect: 'fadeIn',
						visibleOnly: true,
						effectTime: 500,
						threshold: 0,
						// called before an elements gets handled
						beforeLoad: function(element) {
							var imageSrc = element.data('src');
							console.log('image "' + imageSrc + '" is about to be loaded');
						},

						// called after an element was successfully handled
						afterLoad: function(element) {
							$('.lazy').closest('.relative').addClass('open');
							var imageSrc = element.data('src');
							console.log('image "' + imageSrc + '" was loaded successfully');
						},

						// called whenever an element could not be handled
						onError: function(element) {
							var imageSrc = element.data('src');
							console.log('image "' + imageSrc + '" could not be loaded');
						}
					});
				}
			});
		});
	})
</script>