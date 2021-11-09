<?php 
use yii\helpers\Url;
use common\components\ClaHost;
?>
<style type="text/css">
    body .left-img-diamond {
         width: 100%; 
    }
</style>
<div class="content-wrap">
    <div class="page-about-us">
        <div class="container">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 hidden-xs">
                <?=
                    \frontend\widgets\menu\MenuWidget::widget([
                        'view' => 'contact_reason',
                        'group_id' => common\models\menu\MenuGroup::MENU_CONTACT
                    ]);
                ?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="content-page-detail">
                    <div class="full-text full-text-nopad">
                        <h2><?= $name = $category->name ?></h2>
                        <p>
                            <?= $category->description ?>
                        </p>
                        <img src="<?= \common\components\ClaHost::getImageHost(), $category['avatar_path'], $category['avatar_name'] ?>" alt="<?= $name ?>">
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                <div class="row multi-columns-row">
                    <?php if (isset($data) && $data) { ?>
                        <?php foreach ($data as $new) { ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="item-diamond-guide">
                                    <h2><a href="<?= $link = Url::to(['/news/news/detail', 'id' => $new['id'], 'alias' => $new['alias']]) ?>"><?= $name = $new['title'] ?></a></h2>
                                    <p>
                                        <?= $new['short_description'] ?></a>
                                    </p>
                                    <div class="img-diamond-guide">
                                        <div class="left-img-diamond">
                                            <a href="<?= $link ?>">
                                                <img src="<?= ClaHost::getImageHost(), $new['avatar_path'], $new['avatar_name'] ?>" alt="<?= $name ?>" >
                                            </a>
                                            <a class="learn-more" href="<?= $link ?>"><?= Yii::t('app', 'learn_more') ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="paginate">
                            <?=
                            yii\widgets\LinkPager::widget([
                                'pagination' => new yii\data\Pagination([
                                    'pageSize' => $limit,
                                    'totalCount' => $totalitem
                                ])
                            ]);
                            ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
