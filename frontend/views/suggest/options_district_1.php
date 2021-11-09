<?php
if (isset($options) && $options) {
    foreach ($options as $key => $value) {
        ?>
         <li data-value="<?= $value ?>" data-key="<?= $key ?>" class="option-<?= $province_id ?>">
         	>> <?= $value ?>
         </li>
        <?php
    }
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.option-<?= $province_id ?>').click(function () {
	        $('#input-province').attr('data-provine', $(this).parent().parent().attr('data-key'));
	        $('#input-province').attr('data-provine-name', $(this).parent().parent().attr('data-value'));
	        $('#input-province').attr('data-district', $(this).attr('data-key'));
	        $('#input-province').attr('data-district-name', $(this).attr('data-value'));
	        $('#input-province').html($(this).attr('data-value')+' - '+$(this).parent().parent().attr('data-value'));
	        getCostTransport();
	        setTimeout(function(){
				$('.nice-selects').removeClass('open2');
	        	$('.nice-selects').removeClass('open');
	        }, 100);
	    });
	})
	
</script>	
