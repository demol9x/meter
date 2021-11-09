<div class="hastag">
    <div class="tags"><i class="fa fa-tags" aria-hidden="true"></i><?= Yii::t('app', 'tag') ?></div>    
    <div class="tags_product">
        <?php 
        if($data && is_array($data)) {
	        foreach ($data as $meta_keyword) if($meta_keyword){ ?>
	            <a class="tag_title" title="<?= $meta_keyword ?>" href="<?= "$link?type=$type&tag=$meta_keyword" ?>"><?= $meta_keyword ?></a>
	        <?php }
	    } ?>
    </div>
</div>