<style type="text/css">
/*    .homeBlockTitle-center {
        background: url(../images/icon-logo-w.png);
        width: 100%;
        height: 38px;
        background-repeat: no-repeat;
        background-position: center;
        text-align: center;
    }
    .homeBlockTitle-center::after {
        content: '';
        width: Calc(50% - 21px);
        height: 1px;
        float: left;
        margin-top: 19px;
        display: inline-block;
        background: #fff;
    }
    .homeBlockTitle-center::before {
        content: '';
        width: Calc(50% - 21px);
        height: 1px;
        float: right;
        margin-top: 19px;
        display: inline-block;
        background: #fff;
    }*/
</style>
<div class="testimonialsWrap">
    <div class="row-30">
        <div class="container">
            <div class="title-cate-product">
                <h2><a href="javascript:void(0)" title="Cảm nhận của khách hàng">Cảm nhận của khách hàng</a></h2>
            </div>
            <div class="owl-testimonial-single">
                <?php if (isset($data) && $data) { ?>
                    <?php foreach ($data as $item) { ?>
                        <div class="item-testimonial">
                            <div class="item-testimonial-author">
                                <img src="<?= \common\components\ClaHost::getImageHost(), $item['avatar_path'], $item['avatar_name'] ?>"
                                     class="attachment-full"/>
                            </div>
                            <div class="item-testimonial-quote">
                                <div class="testimonialAuthor">
                                    <?php if ($item['score']) {
                                        echo '<div class="star-author">';
                                    }
                                    for ($i = 1; $i <= $item['score']; $i++) {
                                        echo ' <i class="fa fa-star"></i>';
                                    }
                                    echo '</div>';
                                    ?>
                                    <strong><?= Trans($item['customer_name'], $item['customer_name_en']); ?></strong>
                                </div>
                                <p><?= Trans($item['review'], $item['review_en']); ?></p>
                                <em>
                                    <?= Trans($item['customer_address'], $item['customer_address_en']); ?>
                                </em>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="view-more center">
                <a href="<?= \yii\helpers\Url::to(['/review']) ?>"><?= Yii::t('app', 'view_more') ?></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".owl-testimonial-single").owlCarousel({
            items: 3,
            slideSpeed: 1000,
            pagination: true,
            navigation: true,
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            itemsDesktop: [992, 2],
            itemsDesktopSmall: [600, 2],
            itemsTablet: [560, 1]
        });
    });
</script>
