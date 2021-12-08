<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Giới thiệu';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner-main-in',
    'group_id' => 3,
])
?>
<div class="site51_html_col0_gioithieu">
    <div class="container_fix">
        <?php //Menu main
        echo frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget([])
        ?>

        <div class="gioithieu">
            <div class="gioithieu__left wow fadeIn" data-wow-delay="0.3s">
                <h2 class="title_30"><?= $this->title ?></h2>
                <ul class="content_16">
                    <li>
                        <?= $model->short_description ?>
                    </li>
                    <li>
                        <?= $model->description ?>
                    </li>
                </ul>
                <a href="<?= \yii\helpers\Url::to(['/site/contact'])?>" class="content_16 btn-gioithieu btn-animation2">Liên hệ ngay</a>
            </div>
            <div class="gioithieu__right wow fadeRight" data-wow-duration="2s" data-wow-delay="0.4s">
                <div class="gioithieu__right--img">
                    <?php //Menu main
                    echo frontend\widgets\banner\BannerWidget::Widget([
                            'view'=>'banner_contact_in',
                            'group_id'=>2,
                            'limit'=>4,
                    ])
                    ?>
                    <div class="item-video wow flipInX" data-wow-delay="0.7s">
                        <div id="open-modal" class="video modal__button">
                            <img src="<?= common\components\ClaHost::getImageHost(), $model['avatar_path'], $model['avatar_name'] ?>" alt="<?= $model->title?>">
                            <div class="play-video">
                                <span><i class="fas fa-play"></i></span>
                            </div>
                        </div>
                        <div class="modal__container" id="modal-container">
                            <div class="modal__close close-modal" title="Close">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="modal__content">

                                <iframe src="<?= $model->link?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php //Menu main
    echo frontend\widgets\menu\MenuWidget::widget([
        'view' => 'introduce_view_1',
        'group_id' => 6,
    ])
    ?>
    <?php //Menu main
    echo frontend\widgets\menu\MenuWidget::widget([
        'view' => 'introduce_view_2',
        'group_id' => 7,
    ])
    ?>
    <div class="slogan">
        <div class="container_fix">
            <p class="content_40"><span><img src="<?= yii::$app->homeUrl?>images/nhaykep1.png" alt=""></span> Hãy gọi đến công ty của chúng tôi
                , quý khách sẽ luôn nhận được sự tư vấn miễn phí, tận tình và sử dụng những sản phẩm chất
                lượng tiêu chuẩn quốc tế và dịch vụ chăm sóc khách hàng hoàn hảo. Bạn “cần” chúng tôi
                “có “ rất hân hạnh được phục vụ quý khách hàng. <span><img src="<?= yii::$app->homeUrl?>images/nhaykep2.png" alt=""></span></p>
        </div>
    </div>
</div>

