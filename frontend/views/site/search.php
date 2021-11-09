<?php 
use common\components\ClaHost;
$this->title = strlen($_GET['tag']) > 15 ? $_GET['tag'] : $_GET['tag'].' trên ocopmart.org';
$tag = (isset($_GET['tag'])) ? $_GET['tag'] : '';
$type = (isset($_GET['type']) && $_GET['type']) ? $_GET['type'] : 1;
?>
<style type="text/css">
	.text img {
		float: left;
		margin-right: 10px;
	}
	.form-text-searchs{
		margin: 20px 0px;
	}

	.form-text-searchs input, .form-text-searchs select, .form-text-searchs button {
		height: 40px;
		width: 100%;
		border: 1px solid #ebebeb;
	}

	.form-text-searchs button {
	    border: 1px solid #304fa0;
	    background: #304fa0;
	    color: #fff;
	}

	.ul-search li {
		float: left;
	    min-width: 150px;
	    list-style: none;
	}

	.ul-search li a {
		display: block;
	    padding: 10px 15px;
	    text-align: center;
	    font-size: 18px;
	    /*border-right: 1px solid #ebebeb;*/
	}

	.ul-search {
		border: 1px solid #ebebeb;
    	padding-left: 0px;
    	overflow: hidden;
    	border-right: 0px;
	}

	.ul-search li a:hover {
		background: #304fa0;
		color: #fff;
	}

	.ul-search .active a {
		background: #304fa0;
		color: #fff;
	}
	/*se*/

	h2 {
		padding: 30px 0px;
	}	
	.content-search h3 {
		margin-bottom: 0px;
		font-size: 18px;
	}
	.content-search .item >i {
		padding-bottom: 10px;
	}
	.content-search .item {
		margin-top: 20px;
	    clear: both;
	    overflow: hidden;
	}
	.content-search p {
		margin-bottom: 0px;
	}
	#main-content {
	    clear: both;
	    padding-top: 10px;
	    padding-bottom: 15px;
	}
	.title-content {
		font-size: 20px;
	}
	.share {
		clear: both;
		padding: 20px 0px;
	}
	.form-text-searchs > *{
		float: left;
	}
	@media  screen and (max-width: 500px) {
	    .form-text-searchs > *{
			width: 100%;
			padding-top: 10px;
			clear: both;
			float: unset;
		}
	}
	.title-content {
		clear: both;
	}
	.page-search {
		background: #fff;
		padding-bottom: 40px;
	}
	.col-xs-2 .nice-select, .col-xs-2 .nice-select ul, .col-xs-2 .nice-select li {
		width: 100%;
	}
	input  {
		padding: 10px;
	}
</style>
<div id="main-content" style="background: #f7f5f5;">
    <div class="page-search container ">
    	<form action="" class="form-text-searchs">
			<div class="col-xs-5">
				<input type="text" name="tag" placeholder="<?= Yii::t('app', 'search') ?> ..." class="st-input-text" value="<?= $tag ?>">
			</div>
            <div class="col-xs-2">
	            <select name="type">
	            	<?php foreach ($list_type as $key => $value) { ?>
	            		<option value="<?= $key ?>" <?= ($key == $type) ? 'selected' : ''  ?> ><?= $value ?></option>
	            	<?php } ?>
	            </select>
	        </div>
	        <div class="col-xs-2">
	        	<button><?= Yii::t('app', 'search') ?></button>
	        </div>
        </form>
    	<div class="col-lg-12 col-md-12 bg-whites">
	    	<h2 class="title-content"><?= Yii::t('app', 'search_results') ?> "<b><?=(isset($_GET['tag'])) ? $_GET['tag'] : '' ?></b>" :</h2>
	    	<ul class="ul-search">
	    		<?php foreach ($list_type as $key => $value) if($key) { ?>
	    			<li <?= ($key == $type) ? 'class="active"' : ''  ?>><a href="?tag=<?= $tag ?>&type=<?= $key ?>"><?= $value ?></a></li>
	    		<?php } ?>
	    	</ul>
	    	<div class="content-search job-cate-index">
	    		<?php
	    			$data = (isset($datas['data'])) ? $datas['data'] : null;
	    			if($data) {
	    			$paginate = $datas['pagination'];
	    			foreach ($data as $item) {?>
			    		<div class="item item-job-index">
			    			<h3 style=""><a target="_blank" href="<?= (isset($item['link'])) ? $item['link'] : '#'; ?>"><?= (isset($item['title'])) ? $item['title'] : 'Cần trả về "title"'; ?></a></h3>

			    			<i style="padding-bottom: 10px;">(<?=(isset($item['type'])) ? $item['type'] : 'Cần trả về "type"'; ?>)</i>
			    			<div class="text">
			    				<?php if(isset($item['avatar_name']) && $item['avatar_name']) { ?>
			    					<img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's100_100/', $item['avatar_name'] ?>" alt="<?= $item['title'] ?>">
			    				<?php } ?>
			    				<p><?= $item['content'] ?></p>
			    			</div>
			    			

			    			<div class="hastag">
						        <div class="tags"><i class="fa fa-tags" aria-hidden="true"></i>Thẻ</div>
						        <div class="tags_product">
		    						<?php if(isset($item['meta_keywords']) && $item['meta_keywords']) { 
		    							$ltags = explode(',', $item['meta_keywords']);
		    							for ($i=0; $i < count($ltags) ; $i++) {
		    							?>
						                <a  class="tag_title" title="Cẩm nang hướng dẫn sử dụng trang sức" href="?tag=<?= $ltags[$i] ?>&type=<?= $type ?>"> <?= $ltags[$i] ?></a>
						            <?php }
						        		} else { ?>
						            	<a  class="tag_title" title="Cẩm nang hướng dẫn sử dụng trang sức" href="?tag=<?= $item['title'] ?>&type=<?= $type ?>"> <?= $item['title'] ?></a>
						            <?php } ?>
						    	</div>
						    </div>
			    		</div>
		    		<?php } ?>
		    		<div class="paginate">
	                    <?=
	                    \yii\widgets\LinkPager::widget(['pagination' =>$paginate ]);
	                    ?>
	                </div>
	    		<?php } ?>
	    	</div>
	    </div>
	    <div class="page-contact col-lg-3 col-md-3">
	    	<div class=" bg-whites">
	    		<?= ''
		            //nhóm banner gần chân trang
		            //frontend\widgets\banner\BannerWidget::widget([
		                    //     'view' => 'view_qc',
		                    //     'group_id' => 4,
		                    //     'limit' => 3
		                    // ])
		        ?>
	    	</div>
	   	</div>
   	</div>
</div>
