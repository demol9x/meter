<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/list_packages.css">
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner-main-in',
    'group_id' => 5,
])
?>
<div class="site52_pro_col12_nhathau">
    <div class="container_fix">
        <div class="pro_flex">
            <div class="site51_profil_col3_locsanpham">
                <div class="locsanpham">
                    <div class="pro_fitler">
                        <div class="pro_env">
                            <span class="content_16_b">Địa điểm</span><i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="fitler">
                            <div>
                                <input type="checkbox" id="hanoi" name="hanoi" value="hanoi" checked>
                                <label for="hanoi"> Hà nội</label>
                            </div>
                            <div>
                                <input type="checkbox" id="nghean" name="nghean" value="nghean">
                                <label for="nghean"> Nghệ An</label>
                            </div>
                            <div>
                                <input type="checkbox" id="hanam" name="hanam" value="hanam">
                                <label for="hanam"> Hà Nam</label>
                            </div>
                            <div>
                                <input type="checkbox" id="camau" name="camau" value="camau">
                                <label for="camau"> Cà Mau</label>
                            </div>
                            <div>
                                <input type="checkbox" id="haugiang" name="haugiang" value="haugiang">
                                <label for="haugiang"> Hậu giang</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tiengiang" name="tiengiang" value="tiengiang">
                                <label for="tiengiang"> Tiền giang</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tiengiang" name="tiengiang" value="tiengiang">
                                <label for="tiengiang"> Tiền giang</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tiengiang" name="tiengiang" value="tiengiang">
                                <label for="tiengiang"> Tiền giang</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tiengiang" name="tiengiang" value="tiengiang">
                                <label for="tiengiang"> Tiền giang</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tiengiang" name="tiengiang" value="tiengiang">
                                <label for="tiengiang"> Tiền giang</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tiengiang" name="tiengiang" value="tiengiang">
                                <label for="tiengiang"> Tiền giang</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tiengiang" name="tiengiang" value="tiengiang">
                                <label for="tiengiang"> Tiền giang</label>
                            </div>
                        </div>
                    </div>
                    <div class="pro_fitler">
                        <div class="pro_env">
                            <span class="content_16_b">Vốn điều lệ</span><i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="fitler">
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="1000-1500" name="1000-1500" value="1000-1500" checked>
                                    <label for="1000-1500">1000 - 1500 tỷ</label>
                                </div>
                                <span>15</span>
                            </div>
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="1500-2500" name="1500-2500" value="1500-2500">
                                    <label for="1500-2500"> 1500 - 2500 tỷ</label>
                                </div>
                                <span>15</span>
                            </div>
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="60-100" name="60-100" value="60-100">
                                    <label for="60-100"> 60 - 100 km</label>
                                </div>
                                <span>15</span>
                            </div>
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="60-100" name="60-100" value="60-100">
                                    <label for="60-100"> 60 - 100 km</label>
                                </div>
                                <span>15</span>
                            </div>
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="60-100" name="60-100" value="60-100">
                                    <label for="60-100"> 60 - 100 km</label>
                                </div>
                                <span>15</span>
                            </div>

                        </div>
                    </div>
                    <div class="pro_fitler">
                        <div class="pro_env">
                            <span class="content_16_b">Ngày đăng</span><i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="fitler">
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="moinhat" name="moinhat" value="moinhat" checked>
                                    <label for="moinhat"> Mới nhất</label>
                                </div>
                                <span>15</span>
                            </div>

                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="tuantruoc" name="tuantruoc" value="tuantruoc">
                                    <label for="tuantruoc"> Tuần trước</label>
                                </div>
                                <span>15</span>
                            </div>
                            <div class="fitler_flex">
                                <div>
                                    <input type="checkbox" id="thangtruoc" name="thangtruoc" value="thangtruoc">
                                    <label for="thangtruoc"> Tháng trước</label>
                                </div>
                                <span>15</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site52_pro_col10_nhathau">
                <div class="pro_package">
                    <div class="pro_content">
                        <div class="content_text">
                            <h3>nhà thầu</h3>
                        </div>
                        <div class="pro_select_env">
                            <div class="pro_select">
                                <span>Sắp xếp:</span>
                                <select>
                                    <option value="">Cao - Thấp</option>
                                    <option value="">A-Z</option>
                                    <option value="">Mới nhất</option>
                                </select>
                            </div>
                            <a href="" class="sapxep_1">
                                <img src="<?= yii::$app->homeUrl ?>images/img_sapxep_1.png" alt="">
                            </a>
                            <a href="" class="sapxep_2">
                                <img src="<?= yii::$app->homeUrl ?>images/img_sapxep_2.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="pro_flex">
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="<?= Url::to(['/shop/shop/detail'])  ?>">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="<?= Url::to(['/shop/shop/detail'])  ?>">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="<?= Url::to(['/shop/shop/detail'])  ?>">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="<?= Url::to(['/shop/shop/detail'])  ?>">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="<?= Url::to(['/shop/shop/detail'])  ?>">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.3s">
                            <a href="">
                                <div class="card_img">
                                    <img src="<?= yii::$app->homeUrl ?>images/nhathau_pro.png" alt="">
                                </div>
                                <div class="card_text">
                                    <div class="title">Công ty CP Đầu tư Xây dựng Dân dụng Hà Nội</div>
                                    <div class="adress"><span>Hà Nội</span><span><i class="fas fa-star"></i>4/5</span></div>

                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= Yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="pagination">
                    <ul>
                        <li><a href="" title="">‹</a></li>
                        <li class="active"><a href="" title="">1</a></li>
                        <li><a href="" title="">2</a></li>
                        <li><a href="" title="">3</a></li>
                        <li class=""><span>...</span></li>
                        <li><a href="" title="">15</a></li>
                        <li><a href="" title="">›</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
