<style type="text/css">
    .owl-testimonial-single {
        background: #203468;
    }
    .owl-buttons {
        position: absolute;
        top: 65px;
        width: 100%;
        height: 0px;
        color: #fff;
    }
    .owl-prev {
        float: left;
        margin-left: 50px;
        font-size: 26px;
    }
    .owl-next {
        float: right;
        margin-right: 50px;
        font-size: 26px;
    }
    .item-testimonial-quote p {
        max-height: 67px;
        overflow: hidden;
    }
    .item-testimonial-quote {
        padding-bottom: 10px;
    }
</style>
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
                        <h5><?= Trans($item['customer_name'], $item['customer_name_en']); ?> - <?= Trans($item['customer_address'], $item['customer_address_en']); ?></h5>
                    </div>
                    <p><?= Trans($item['review'], $item['review_en']); ?></p>
                    
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".owl-testimonial-single").owlCarousel({
            items: 1,
            slideSpeed: 1000,
            pagination: false,
            navigation: true,
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        });
    });
</script>
