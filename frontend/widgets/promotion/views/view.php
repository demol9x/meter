<?php
date_default_timezone_set("Asia/Bangkok");
use yii\helpers\Url;
use common\components\ClaHost;
$list_time = explode(' ', $promotion->time_space);
$hour_next = count($list_time) > 1 ? $promotion->getHourAfter($promotion->getHourNow()) : $promotion->enddate;
if (isset($products) && $products) {
    ?>
    <div class="product-inhome">
        <div class="container">
            <div class="title-standard">
                <h2>
                    <a>
                        <img src="<?= Yii::$app->homeUrl ?>images/flas.png" alt="">
                    </a>
                </h2>
                <div class="time" id="countdown"></div>
                <a href="<?= Url::to(['/product/product-promotion/detail', 'id' => $promotion->id, 'alias' => $promotion->alias]) ?>" class="view-more"><?= Yii::t('app', 'view_all') ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
            </div>
            <div class="list-product-inhome slider-product-index owl-carousel owl-theme">
                <?= frontend\widgets\html\HtmlWidget::widget([
                                'input' => [
                                    'products' => $products
                                ],
                                'view' => 'view_product_promotion_index'
                            ]);
                ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
                var myDate = new Date();
                myDate.setSeconds(myDate.getSeconds() + <?= $hour_next - time() ?>);
                $("#countdown").countdown(myDate, function (event) {
                    $(this).html(
                        event.strftime(
                            '<span><b>%D</b></span><span><b>%H</b></span><span><b>%M</b></span><span><b>%S</b></span>'
                        )
                    );
                });
            });
    </script>
<?php } ?>

