<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <style type="text/css">
        .top-5-reason, .news-hot {
            margin-bottom: 30px;
            background: #fff;
        }
        .blog-page, .blog-detail-content {
            background: #fff;
            padding: 15px;
            min-height: 100vh;
            margin-bottom: 40px;
        }
    </style> 
    <div id="main-content" style="background: #f7f5f5; padding-top: 15px;">
        <div class="container">
            <div class="row mar-10">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-10 mar-bottom-15">
                    <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>
                </div>
                <div class="content-wrap">
                    <div class="page-about-uss">
                        <div class="container">
                            <div class="control-tab-767">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 new-menu tab-767">
                                <?=
                                frontend\widgets\news\NewsMenuWidget::widget([
                                    'id' => 0,
                                    'view' => 'view_menu'
                                ]);
                                ?>
                                <?=
                                    \frontend\widgets\menu\MenuWidget::widget([
                                        'view' => 'contact_reason',
                                        'group_id' => common\models\menu\MenuGroup::MENU_5_REASON
                                    ]);
                                ?>
                                <?=
                                    \frontend\widgets\newAttr\NewAttrWidget::widget([
                                    'view' => 'new',
                                    'title' =>  Yii::t('app','new_view_most'),
                                    'order' => ' viewed DESC ',
                                    'limit' => 5
                                        ]
                                )
                                ?>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function () {
            $('.control-tab-767').click(function() {
                if($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('.tab-767').removeClass('tab-767-open');
                } else {
                    $(this).addClass('active');
                    $('.tab-767').addClass('tab-767-open');
                }
            });
        });
    </script>
<?php $this->endContent(); ?>