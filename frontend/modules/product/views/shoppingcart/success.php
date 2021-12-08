<?php
$siteinfo = common\components\ClaLid::getSiteinfo();
$text_price = number_format($orders->order_total, 0, ',', '.') . Yii::t('app', 'currency');

use common\components\ClaHost;
use common\components\HtmlFormat;
use common\models\District;
use common\models\Province;
use common\models\Ward;
use yii\helpers\Url;

$province_name = Province::getNamebyId($orders->province_id);
$district_name = District::getNamebyId($orders->district_id);
$ward_name = Ward::getNamebyId($orders->ward_id);
$address = $ward_name.', '.$district_name.', '.$province_name;
?>

<div class="site51_html_col9_dathangthanhcong">
    <div class="container_fix mall">
        <div class="item_product_giohang">
            <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>

            <div class="item-title">
                <img src="<?= Yii::$app->homeUrl ?>images/icon-thanhtoan.png">
                <h2 class="title_24">Đặt hàng thành công</h2>
                <p class="content_16">Cảm ơn <span>Anh/Chị</span> đã cho BCA cơ hội được phục vụ. Trong 120’ nhân viên
                    BCA sẽ <span>gọi điện hoặc gửi tin nhắn xác nhận giao hàng</span> cho Anh/chị</p>
            </div>

            <div class="item-information-line">
                <div class="title-line">
                    <h3 class="title_18">Đơn hàng: #<?= $orders->id ?></h3>
                    <a href="" title="" class="content_16">Quản lý đơn hàng</a>
                </div>
                <ul>
                    <li class="content_16">Người nhận: <?= $orders->name ?> - <?= $orders->phone ?></li>
                    <li class="content_16">Giao đến: <?= $orders->address ?> - <?=$address?> (Nhân
                        viên sẽ gọi xác nhận trước khi giao).
                    </li>
                </ul>
                <div class="total-amount">
                    <h5 class="title_18">Tổng tiền: </h5>
                    <p class="title_18"><?= $text_price ?></p>
                </div>
            </div>
            <div class="btn-cancel">
                <a href="" title="" class="content_16">Hủy đơn hàng</a>
            </div>
        </div>

        <div class="item-delivery-time">
            <h3 class="title_21">Thời gian nhận hàng</h3>
            <div class="title-delivery">
                <p class="content_16">Giao trước 17h hôm nay (<?= date('d/m', time()) ?>)</p>
                <a href="" title="" class="content_16">Chọn ngày giờ khác</a>
            </div>
            <div class="all-sp-schedule">
                <?php
                $totals = 0;
                $count = 0;
                if (isset($order_item) && $order_item) {
                    foreach ($order_item as $key => $item) {
                        $url = Url::to([
                            '/product/product/detail',
                            'id' => $item['id'],
                            'alias' => HtmlFormat::parseToAlias($item['name'])
                        ]);
                        $item['quantity'] = (int) $item['quantity'];
                        $total = $item['price'] * $item['quantity'];
                        $totals += $total;
                        $count = $count + $item['quantity']
                        ?>
                        <a href="<?= $url ?>" title="<?= $item['name'] ?>">
                            <div class="sp-schedule">
                                <div class="image">
                                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'] . $item['avatar_name'] ?>"
                                         alt="<?= $item['name'] ?>">
                                </div>
                                <div class="tt-title-sp">
                                    <h5 class="content_16"><?= $item['name'] ?></h5>
                                    <p class="content_14">Số lượng: <?= $item['quantity'] ?></p>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="total-amount">
                <h5 class="title_21">Tổng tiền:</h5>
                <p class="title_24"><?= $text_price ?></p>
            </div>
        </div>

        <div class="item-shopping-experience">
            <div class="refund"><a href="" title="" class="content_16">Xem chính sách hoàn tiền online</a></div>
            <a href="<?=Url::to('/product/product/index')?>" title="" class="title_18 butt butt_cl2 buy_mores">Mua thêm sản phẩm khác</a>
            <div class="evaluate-experience">
                <p class="content_16">Anh/Chị có hài lòng về trải nghiệm mua hàng?</p>
                <div class="item-evaluate">
                    <label>
                        <input name="evaluate" checked="checkbox" type="radio">
                        <div class="icon-item">
                            <div class="icon">
                                <img src="<?= Yii::$app->homeUrl ?>images/happy.png">
                            </div>
                            <div class="icon">
                                <img src="<?= Yii::$app->homeUrl ?>images/happy1.png">
                            </div>
                        </div>
                        <p class="content_16">Hài lòng</p>
                    </label>
                    <label>
                        <input name="evaluate" type="radio">
                        <div class="icon-item">
                            <div class="icon">
                                <img src="<?= Yii::$app->homeUrl ?>images/smile.png">
                            </div>
                            <div class="icon">
                                <img src="<?= Yii::$app->homeUrl ?>images/smile1.png">
                            </div>
                        </div>
                        <p class="content_16">Không hài lòng</p>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>