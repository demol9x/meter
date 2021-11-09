<?php if (isset($data) && $data) { ?>
    <div class="breadcrumb">
        <div class="container">
            <?php
            $count = count($data);
            $i = 0;
            foreach ($data as $title => $url) {
                $i++;
                ?>
                <a href="<?= $url ?>" title="<?= $title ?>"><?= $title ?></a> <?= $i != $count ? '<span><i class="fa fa-angle-right"></i></span>' : '' ?>
                <?php
            }
            ?>
        </div>
    </div>
<?php } ?>
