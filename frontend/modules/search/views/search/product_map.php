<?php 
    $listMap = $products;
    // $listid = [];
    // foreach ($products as $product) {
    //     if(!in_array($product['shop_id'] , $listid)) {
    //         $listMap[] = $product;
    //         $listid[] = $product['shop_id'];
    //     }
    // }
?>
<div class="search-width-googlemap">
    <div class="container">
        <div class="flex">
            <div class="col-map">
                <div class="show-mobile">
                    <form>
                        <i class="fa fa-search"></i>
                        <input type="text" id="" placeholder="Tìm kiếm sản phẩm">
                    </form>
                    <button onclick="myFunction()" class="btn-show-my-address">
                        <i class="fa fa-map-marker"></i> <span>Vị trí của bạn</span>
                        <b id="show-my-address"></b>
                    </button>
                    <script>
                        function myFunction() {
                            $('.btn-show-my-address').addClass('active');
                            document.getElementById("show-my-address").innerHTML = "335 Cầu giấy - Hà Nội";
                        }
                  </script>
                </div>
                <?=
                    \frontend\widgets\html\HtmlWidget::widget([
                        'view' => 'map-search',
                        'input' => [
                            'zoom' => 12,
                            'center' => $center,
                            'listMap' => $listMap,
                            'get_range' => $get_range
                        ]
                    ])
                ?>
            </div>
            <div class="btn-show-all-address">
                <i class="fa fa-angle-up"></i>
                <p>
                    Danh sách sản phẩm
                    <span><?= count($products) ?> địa điểm</span>
                </p>
            </div>
            <div class="col-list-address">
                <div class="ds-addres" id="box-list-item-search">
                    <p id="view-all-search" class="click center"><?= Yii::t('app', 'view_all') ?></p>
                    <?php if($products) {
                        echo frontend\widgets\html\HtmlWidget::widget([
                                'input' => [
                                    'products' => $products,
                                ],
                                'view' => 'view_product_search'
                            ]);
                        echo \yii\widgets\LinkPager::widget([
                                'pagination' => new \yii\data\Pagination([
                                    'pageSize' => $limit,
                                    'totalCount' => $totalitem
                                        ])
                            ]);
                    } else { ?>
                        <p style="padding: 15px;"><?= Yii::t('app', 'product_not_found') ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".btn-show-all-address").click(function(){
           $(this).toggleClass('active');
           $('.col-list-address').toggleClass('active');
       });
    </script>
</div>