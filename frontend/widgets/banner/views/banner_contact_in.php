<?php if (isset($data) && $data) {
    $i=6;
    foreach ($data as $key){ $i+3;?>
<div class="item-img wow flipInX" data-wow-delay="0.<?= $i ?>s">
    <a data-fancybox="gallery" href="<?= $key['src']?>">
        <img class="rounded" src="<?= $key['src']?>" alt="<?= $key['name']?>" />
    </a>
</div>
    <?php }?>
<?php } ?>