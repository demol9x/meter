<?php if($success) { ?>
    <script type="text/javascript">
        alert('Lưu thành công');
        $('#input-send').parent().find('.error').remove();
        $('#input-send').parent().parent().children('p').html('<?= $value ?>');
        $('#input-send').val('');
    </script>
<?php } ?>