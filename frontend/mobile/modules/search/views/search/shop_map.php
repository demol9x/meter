<?php 
    $listMap = $shops;
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
                        'view' => 'map-search-shop',
                        'input' => [
                            'zoom' => 12,
                            'center' => $center,
                            'listMap' => $listMap
                        ]
                    ])
                ?>
            </div>
            <div class="btn-show-all-address">
                <i class="fa fa-angle-up"></i>
                <p>
                    Danh sách sản phẩm
                    <span><?= count($shops) ?> địa điểm</span>
                </p>
            </div>
            <div class="col-list-address">
                <div class="ds-addres ds-addres-shop" id="box-list-item-search">
                    <p id="view-all-search" class="click center"><?= Yii::t('app', 'view_all') ?></p>
                    <?php if($shops) {
                        echo frontend\widgets\html\HtmlWidget::widget([
                                'input' => [
                                    'shops' => $shops,
                                ],
                                'view' => 'view_shop_search'
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