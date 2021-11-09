<?php if (isset($data) && $data) { ?>
    <div class="container">
        <div class="owl-item-camket">
            <?php foreach ($data as $tg) {
                $banner->setAttributeShow($tg);
                $name = $banner['name'];
                ?>
                <div class="item-camket">
                    <div class="img-item-camket">
                        <a href="<?= $banner['link'] ?>">
                            <img src="<?= $banner->src ?>" alt="<?= $name ?>">
                        </a>
                        <h2><a href="<?= $banner['link']; ?>"><?= $name ?></a></h2>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>