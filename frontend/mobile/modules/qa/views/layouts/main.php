<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
   <div id="main">
        <?= \frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget() ?>
        <div class="fag-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?=
                            frontend\widgets\qa\QAMenuWidget::widget([
                                'id' => 0,
                                'view' => 'view_menu'
                            ]);
                        ?>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>