<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <div id="main-content" style="background: #f7f5f5; padding-top: 15px;">
        <div class="container">
            <div class="row mar-10">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-10 mar-bottom-15">
                    <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>
                </div>
                <?= $content ?>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>