<?php if (isset($data) && $data) { ?>
    <div class="banner-index">
        <div class="item-banner-index">
            <div class="img-banner">
                <div class="tp-banner-container">
                    <div class="tp-banner">
                        <ul>
                            <!-- SLIDE  -->
                            <?php foreach ($data as $tg) {
                                $banner->setAttributeShow($tg); ?>
                                <li data-transition="fade" data-slotamount="7" data-masterspeed="1000" data-delay="13000">
                                    <!-- MAIN IMAGE -->
                                    <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tp-bannertimer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>