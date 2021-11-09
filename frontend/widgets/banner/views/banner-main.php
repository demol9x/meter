<style type="text/css">
    .banner-slider-index>div>.tp-fullwidth-forcer {
        display: none;
    }
</style>
<?php if (isset($data) && $data) { ?>
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                <!-- SLIDE  -->
                <?php foreach ($data as $tg) {
                    $banner->setAttributeShow($tg); ?>
                    <li data-transition="fadetobottomfadefromtop" data-slotamount="7" data-masterspeed="1500">
                        <!-- MAIN IMAGE -->
                        <img data-lazyload="<?php echo $banner->src; ?>" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="<?= $banner['name'] ?>" data-bgfit="cover" data-bgposition="top center" data-bgrepeat="no-repeat">
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption medium_bg_orange skewfromleftshort customout" data-x="right" data-hoffset="-90" data-y="bottom" data-voffset="-50" data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;" data-speed="500" data-start="500" data-easing="Back.easeOut" data-endspeed="500" data-endeasing="Power4.easeIn" data-captionhidden="on" style="z-index: 21"><?= $banner['description'] ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>