
<div class="wapper">
    <div class="search-width-googlemap">
        <div class="container">
            <div class="flex">
                <div class="col-map">
                    <div class="show-mobile flex">
                        <button class="back-page">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </button>
                        <div class="ctn">
                            <form class="flex">
                                <div class="input-search-product">
                                    <i class="fa fa-search"></i>
                                    <input type="text" id="" placeholder="Tìm kiếm sản phẩm">
                                </div>
                                <button class="btn-search"><i class="fa fa-search"></i></button>
                            </form>
                            <form class="flex">
                                <div class="input-self-location">
                                    <i class="fa fa-map-marker"></i>
                                    <input type="text" placeholder="Vị trí của bạn">
                                </div>
                                <button class="btn-self-location"><img src="images/icon-sefl-location.png" alt=""></button>
                            </form>
                        </div>
                    </div>
                    <?=
                        \frontend\widgets\html\HtmlWidget::widget([
                            'view' => 'map-search',
                            'input' => [
                                'zoom' => 12,
                                'center' => $center,
                                'listMap' => $products,
                            ]
                        ])
                    ?>
                </div>
                <div class="btn-show-all-address active">
                    <i class="fa fa-angle-up"></i>
                    <p>
                        Danh sách sản phẩm
                        <span>58 địa điểm</span>
                    </p>
                </div>
                <div class="col-list-address active">
                    <div class="ds-addres">
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
                        <div class="item-address">
                            <div class="img">
                                <a href=""><img src="images/img-product4.png" alt=""></a>
                            </div>
                            <div class="title">
                                <h2>
                                    <a href="">Trang trại nuôi thỏ công nghệ cao</a>
                                </h2>
                                <div class="review">
                                    <span class="price">50.000đ</span>
                                    <div class="star">
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <i class="fa fa-star yellow"></i>
                                        <span>(50)</span>
                                    </div>
                                </div>
                                <div class="location">
                                    <i class="fa fa-map-marker"></i> Cụm công nghiệp thành phố Hồ chí minh
                                </div>
                            </div>
                            <button class="btn-distance">
                                <i class="fa fa-level-up" aria-hidden="true"></i>
                                <span>200m</span>
                            </button>
                        </div>
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
</div>