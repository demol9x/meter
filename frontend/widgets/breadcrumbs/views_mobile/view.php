
<?php if (isset($data) && $data) { ?>
    <div class="breadcrumb">
        <?php
        $count = count($data);
        $i = 0;
        foreach ($data as $title => $url) {
            $i++;
            ?>
            <a href="<?= $url ?>" title="<?= $title ?>" class="main title4"><?= $title ?></a>
            <?php
        }
        ?>
    </div>
<?php } ?>
