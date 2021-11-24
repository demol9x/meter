<?php

use common\components\ClaHost;
use common\components\ClaLid;

use yii\helpers\Url;
?>
<?php
if(isset($model) && $model){
?>
<div class="container_fix">
    <?=
    \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(
            ['view'=>'view']
    );
    ?>
    <div class="chitiettintuc">
        <div class="tintuc">
            <div class="tintuc__center">
                <h2 class="title_30"><?= isset($model->title) && $model->title ? $model->title : 'Đang cập nhật'?></h2>
                <div class="gettit">
                    <div class="date_time">
                        <img src="<?= yii::$app->homeUrl?>images/time.png" alt="">
                        <span class="content_16"><?= date('d',$model->publicdate) ?></span><span class="content_16">-<?= date('m',$model->publicdate) ?></span><span class="content_16">-<?= date('Y',$model->publicdate) ?></span>
                    </div>
                    <div class="operation">
                       <?php
                       \frontend\widgets\facebookcomment\FacebookcommentWidget::widget(['view'=>'view'])
                       ?>
                    </div>
                </div>
                <p><img src="<?= yii::$app->homeUrl?>images/gt1.png" alt=""></p>
                <p class="content_16">UBND thành phố Hà Nội giao Sở Giao thông vận tải
                    phối hợp với Sở Kế hoạch và Đầu tư, các sở, ngành, các ban quản lý
                    dự án tập trung đẩy nhanh việc đầu tư phát triển đồng bộ kết cấu hạ
                    tầng giao thông theo quy hoạch.
                </p>
                <h3 class="title_18"><span class="number content_16">1</span>Đẩy nhanh đầu tư kết nối, khép kín các tuyến vành đa</h3>
                <p class="content_16">Tại công văn số 3175/UBND-ĐT ngày 22/9, UBND thành phố Hà Nội yêu cầu Sở Giao thông
                    vận tải Hà Nội cùng các sở, ngành, đơn vị của thành phố tập trung triển khai nhiều nhiệm vụ
                    quan trọng, thiết thực, hiệu quả Kết luận số 45-KL/TW ngày 1/2/2019 của Ban Bí thư Trung
                    ương Đảng về tiếp tục đẩy mạnh thực hiện có hiệu quả Chỉ thị số 18-CT/TW ngày 4/9/2012 của
                    Ban Bí thư Trung ương Đảng (khóa XI) về “Tăng cường sự lãnh đạo của Đảng đối với công tác
                    bảo đảm trật tự, an toàn giao thông đường bộ, đường sắt, đường thủy nội địa và khắc phục
                    ùn tắc giao thông”.</p>
                <p><img src="<?= yii::$app->homeUrl?>images/gt1.png" alt=""></p>
                <h3 class="title_18"><span class="number content_16">2</span>Triển khai xây dựng hệ thống “giao thông thông minh”</h3>
                <p class="content_16">Đặc biệt, UBND thành phố yêu cầu Sở Giao thông vận tải Hà Nội
                    tiếp tục nghiên cứu, đề xuất triển khai xây dựng hệ thống “giao thông thông minh”
                    trong tổng thể xây dựng thành phố thông minh, áp dụng công nghệ, kỹ thuật trong
                    tổ chức, điều hành giao thông; xây dựng hệ thống bản đồ số trong công tác tổ
                    chức, điều hành giao thông, tích hợp về Trung tâm điều hành giao thông thành
                    phố để thường xuyên cập nhật, chủ động phân tích đưa ra những cảnh báo, phương
                    án phân luồng giao thông hợp lý trên địa bàn thành phố…</p>

                <div class="tuongtac">
                    <div class="item-share">
                        <p class="content_16"><i class="fal fa-user"></i>Đăng bởi: &nbsp;<span>Admin</span></p>
                        <p class="content_16"><i class="fal fa-folder-open"></i><span>Tin tức chung</span></p>
                        <p class="content_16"><i class="fal fa-comments-alt"></i><span>Bình luận: 0</span></p>
                        <div class="share-icon">
                            <i class="fal fa-share-alt"></i>
                            <p class="content_16">Chia sẻ:</p>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-skype"></i></a>
                        </div>
                    </div>
                    <div class="item-comment">
                        <div class="comment-n">
                            <span class="content_16">Bình luận:</span>&nbsp;<span class="content_16">0 bình luận.</span>
                        </div>
                        <div class="check-cmt">
                            <span class="content_16">Sắp xếp theo:</span>
                            <div class="item-cmt">
                                <select class="content_16">
                                    <option value="news">Mới nhất</option>
                                    <option value="all">Tất cả</option>
                                    <option value="fit">Phù hợp</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="item-input-comment">
                        <span class="image_cmt"><img src="<?= yii::$app->homeUrl?>images/Vector.png" alt=""></span>
                        <textarea class="content_16" name="comment" rows="4" cols="50" placeholder="Nhập bình luận của bạn. Vui lòng nhập tiếng việt có dấu."></textarea>
                    </div>
                    <div class="comment_in_fb">
                        <a href="" title="" class="content_16"><i class="fab fa-facebook-f"></i> Plugin bình luận trên Facebook</a>
                    </div>
                </div>
                <div class="tintuclienquan">
                    <h3 class="content_16">bài viết liên quan</h3>
                    <div class="row-main">
                        <a class="item-tin">
                            <div class="item-img">
                                <img src="<?= yii::$app->homeUrl?>images/tinkhac_1.png" alt="">
                                <div class="date">
                                    <time><span>03</span><br>08/2021</time>
                                </div>
                            </div>
                            <div class="item-text">
                                <p class="content_16">Dự án Phát triển hệ thống kiểm soát giao thông cho đường cao tốc tại Hà Nội.</p>
                                <time class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span>22</span>-<span>11</span>-<span>21</span></time>
                            </div>
                        </a>
                        <a class="item-tin">
                            <div class="item-img">
                                <img src="<?= yii::$app->homeUrl?>images/tinkhac_1.png" alt="">
                                <div class="date">
                                    <time><span>03</span><br>08/2021</time>
                                </div>
                            </div>
                            <div class="item-text">
                                <p class="content_16">Dự án Phát triển hệ thống kiểm soát giao thông cho đường cao tốc tại Hà Nội.</p>
                                <time class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span>22</span>-<span>11</span>-<span>21</span></time>
                            </div>
                        </a>
                        <a class="item-tin">
                            <div class="item-img">
                                <img src="<?= yii::$app->homeUrl?>images/tinkhac_1.png" alt="">
                                <div class="date">
                                    <time><span>03</span><br>08/2021</time>
                                </div>
                            </div>
                            <div class="item-text">
                                <p class="content_16">Dự án Phát triển hệ thống kiểm soát giao thông cho đường cao tốc tại Hà Nội.</p>
                                <time class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span>22</span>-<span>11</span>-<span>21</span></time>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <div class="tintuc__left">
                <div class="tab-tintuc">
                    <nav class="van-tabs">
                        <a href=""><label id="tintucchung" class="active content_16">tin tức chung</label></a>
                        <a href=""><label id="tinthitruong" class="content_16">tin thị trường</label></a>
                        <a href=""><label id="tingoithau" class="content_16">tin gói thầu</label></a>
                        <a href=""><label id="trainghiem" class="content_16">TRẢI NGHIỆM & CHIA SẺ</label></a>
                    </nav>
                </div>
                <div class="tinkhac">
                    <h3 class="title_24">Bài viết nổi bật</h3>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="<?= yii::$app->homeUrl?>images/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="<?= yii::$app->homeUrl?>images/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="<?= yii::$app->homeUrl?>images/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="<?= yii::$app->homeUrl?>images/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                    <div class="tinkhac-item">
                        <a class="item-img" href=""><img src="<?= yii::$app->homeUrl?>images/tinkhac1.png" alt=""></a>
                        <a class="content_16" href="">Mời thầu “Gói thầu cung cấp dịch vụ tư vấn thực hiện chuyển...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>