<?php 
    $this->title = Yii::t('app','item_reviews');
?>
<style type="text/css">
    body .title-cate-product:after {
        margin-top: -45px;
    }
</style>
<div class="content-wrap">
    <div class="banner-slider-index">
        <?=
        \frontend\widgets\banner\BannerWidget::widget([
            'view' => 'banner-main',
            'group_id' => 3,
            'limit' => 5
                ]
        )
        ?>
    </div>
    <div class="camket">
        <?=
        frontend\widgets\menu\MenuWidget::widget([
            'group_id' => 3,
            'view' => 'view_policy'
        ]);
        ?>
    </div>
    <div class="review-customer">
        <div class="container">
            <div class="title-cate-product">
                <h2><a href="" class="txt-left"><?= Yii::t('app','item_reviews') ?></a></h2>
            </div>

            <div class="list-review-customer">
                <?php if (isset($data) && $data) { ?>
                    <?php foreach ($data as $item) { ?>
                        <div class="item-review-customer">
                            <div class="img-item-review-customer">
                                <a>
                                    <img src="<?= \common\components\ClaHost::getImageHost(), $item['avatar_path'], $item['avatar_name'] ?>"
                                     class="attachment-full"/>
                                </a>
                            </div>
                            <div class="title-item-review-customer">
                                <h2>
                                    <a> <?= \common\components\ClaLid::getDataByLanguage($item['title'], $item['title_en']); ?></a>
                                    <span class="mr-review">|</span>
                                    <?php for ($i = 0; $i < $item['score']; $i++) { ?>
                                        <span class="fa fa-star"></span>
                                    <?php } ?>
                                    <?php for ($i = $item['score']; $i < 5; $i++) { ?>
                                        <span class="fa fa-star-o"></span>
                                    <?php } ?>
                                </h2>
                                <p>
                                    <?= \common\components\ClaLid::getDataByLanguage($item['review'], $item['review_en']); ?>
                                </p>
                                <span>by <?= \common\components\ClaLid::getDataByLanguage($item['customer_name'], $item['customer_name_en']); ?> from <?= \common\components\ClaLid::getDataByLanguage($item['customer_address'], $item['customer_address_en']); ?> </span>
                            </div>
                        </div>
                    <?php }
                } ?>
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
            </div>
        </div>
    </div>
</div><!-- /content-wrap -->
