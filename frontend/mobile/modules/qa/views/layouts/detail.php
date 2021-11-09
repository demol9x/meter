<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<? //= $this->render('@frontend/views/layouts/partial/header_not_filter'); ?>
    <div class="content-wrap">
        <div class="page-about-us">
            <div class="container">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 hidden-xs">
                    <div class="news-hot">
                        <div class="title-top-reason">
                            <h2>Bài viết xem nhiều nhất</h2>
                        </div>
                        <ul>
                            <li>
                                <div class="item-hot-news">
                                    <div class="img-item-hot-news">
                                        <a href="">
                                            <img src="images/wedding-rings.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="title-item-hot-news">
                                        <h2><a href="">Lorem ipsum dolor sit amet, consectetur</a></h2>
                                        <span>06/12/2017</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-hot-news">
                                    <div class="img-item-hot-news">
                                        <a href="">
                                            <img src="images/wedding-rings.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="title-item-hot-news">
                                        <h2><a href="">Lorem ipsum dolor sit amet, consectetur</a></h2>
                                        <span>06/12/2017</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-hot-news">
                                    <div class="img-item-hot-news">
                                        <a href="">
                                            <img src="images/wedding-rings.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="title-item-hot-news">
                                        <h2><a href="">Lorem ipsum dolor sit amet, consectetur</a></h2>
                                        <span>06/12/2017</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-hot-news">
                                    <div class="img-item-hot-news">
                                        <a href="">
                                            <img src="images/wedding-rings.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="title-item-hot-news">
                                        <h2><a href="">Lorem ipsum dolor sit amet, consectetur</a></h2>
                                        <span>06/12/2017</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-hot-news">
                                    <div class="img-item-hot-news">
                                        <a href="">
                                            <img src="images/wedding-rings.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="title-item-hot-news">
                                        <h2><a href="">Lorem ipsum dolor sit amet, consectetur</a></h2>
                                        <span>06/12/2017</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>