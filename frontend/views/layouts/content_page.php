<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<style type="text/css">
    .page-contact {
        padding: 0px 15px;
    }
	#main-content {
	    clear: both;
	    padding-top: 10px;
	    padding-bottom: 15px;
        overflow: hidden;
	}
	.page-contact{
		margin-bottom: 20px;
	    padding-bottom: 60px;
	    clear: both;
	    background: #fff;
	}
	.title-content {
		font-size: 20px;
	}
	.share {
		clear: both;
		padding: 20px 0px;
	}
    .top-5-reason {
        background: #fff;
    }
</style>
<div id="main-content" style="background: #f7f5f5; padding-top: 15px;">
	<div class="page-contact-us">
	    <div class="container">
	        <?= $content ?>
	    </div>
	</div>
</div>
<?php $this->endContent(); ?>
