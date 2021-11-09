<?php if (isset($data) && $data) { ?>
    <style type="text/css">
        .banner-qc a {
            width: 100%;
            max-height: 300px;
            overflow: hidden;
            display: block;
        }

        .banner-qc a img {
            width: 100%;
        }
    </style>
    <div class="banner-index" style="margin-bottom: 30px">
        <div class="container">
            <div class="banner-qc">
                <?php foreach ($data as $tg) {
                    $banner->setAttributeShow($tg); ?>
                    <a <?= $banner['target'] ? 'target="_bank"' : '' ?> <?= $banner['link'] ? 'href="' . $banner['link'] . '"' : '' ?>>
                        <img src="<?= $banner->src ?>" alt="<?= $banner['name'] ?>" title="<?= $banner['name'] ?>">
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>