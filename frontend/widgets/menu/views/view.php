<?php if (isset($data) && $data) {?>

<?php foreach ($data as $key){?>
<a href="<?= isset($key['link']) && $key['link'] ? $key['link'] : '#' ?>"><?php echo $key['description']?></i></a>
<?php }?>

<?php }?>