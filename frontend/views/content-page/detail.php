
<div class="page-contact bg-whites content-page">
    <div style="padding: 0px 0px 40px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<h2 class="title-content"><?= $model->title ?></h2>
    	<hr/>
        <p style="margin-left: 25px"><b><?= $model->short_description ?></b></p>
        <div style="padding: 0px 10px" class="instroduce">
            <?= $model->description ?>
        </div>
    </div>
   
    <div class="share">
    	<?=
            frontend\widgets\facebookcomment\FacebookcommentWidget::widget([
            	'view' => 'share'
            ]);
        ?>
    </div>
    <div class="facebook-cm">
    	<?=
            frontend\widgets\facebookcomment\FacebookcommentWidget::widget([
            ]);
        ?>
    </div>
</div>



