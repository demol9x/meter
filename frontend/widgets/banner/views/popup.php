<?php if (isset($data) && $data) { ?>
    <div class="popup-sapphire">
        <div class="bg-shadow"></div>
        <div class="popup-ctn-sapphire">
            <div id="box-cr-popupss" class="owl-popup-sapphire">
                <?php foreach ($data as $tg) {
                    $banner->setAttributeShow($tg); ?>
                    <a <?= $banner['target'] ? 'target="_bank"' : '' ?> <?= $banner['link'] ? 'href="' . $banner['link'] . '"' : '' ?> title="<?= $banner['name'] ?>">
                        <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>" />
                    </a>
                <?php break;
                } ?>
            </div>
            <div class="close-btn-sapphire">x</div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.close-btn-sapphire').click(function() {
                $('.popup-sapphire').css('display', 'none');
            });
        });
    </script>
<?php } ?>