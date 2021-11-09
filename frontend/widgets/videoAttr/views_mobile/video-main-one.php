<?php if (isset($videos) && $videos) { $video = $videos[0]; ?>
    <iframe style="width: 100%; height: 500px;" src="<?= $video['embed'] ?>" frameborder="0" allowfullscreen></iframe>
<?php } ?>
