<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app','gold_price');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .bottom-gold {
        padding-bottom: 40px;
        clear: both;
        overflow: hidden;
    }
    .collection-name {
        padding-left: 0px;
    }
    .bg-f1 {
        background: #f1f2f2;
    }
    .table {
        clear: both;
        padding-top: 25px;
    }
    th {
        background: #213468;
        color: #fff;
        padding: 20px;
    }
    body .collection-name:after {
        top: 20px;
    }
    .table-gold {
        padding: 30px 0px;
    }
    .gc {
        font-size: 18px;
        position: relative;
        margin-bottom: 25px;
    }
    .gc:before {
        content: '';
        position: absolute;
        display: block;
        width: 100%;
        height: 2px;
        background: #20346836;
        bottom: -8px;
    }
    .gc:after {
        content: '';
        position: absolute;
        display: block;
        width: 40%;
        height: 2px;
        background: #203468;
        bottom: -8px;
    }
    .gold-name .gc:after, .gold-name .gc:before{
        height: 4px;
        bottom: -23px;
    }
    .gold-name .gc:after {
        width: 200px;
    }
    .gold-name h2 {
        font-size: 18px;
        font-weight: bold;
    }
    .gold-name h2 span{
        font-weight: normal;
    }
</style>
<div id="main-content" style=" padding-top: 15px;">
    <div class="container">
        <div class="row mar-10">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-10 mar-bottom-15">
                <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>
            </div>
        </div>
        <div class="img-gold">
            <?=
                \frontend\widgets\banner\BannerWidget::widget([
                    'view' => 'banner-main-one',
                    'group_id' => \common\models\banner\BannerGroup::BANNER_MAIN_GOLD,
                    'limit' => 1
                ])
            ?>
        </div>
        <div class="table-gold">
            <div class="index_col_title white-bg">
                <div class="gold-name">
                    <h2 class="gc">
                        <a><?= $this->title ?> <span>(đơn vị đồng/chỉ)</span></a>
                    </h2>
                </div>
                <div class="table">
                <table style="width:100%" class="giavang table-hover" value="10">
                    <tbody>
                        <tr class="table-heading">
                            <th class="al-center">LOẠI</th>
                            <td class="al-center bg-f1" >MUA VÀO</td>
                            <td class="al-center bg-f1">BÁN RA</td>
                        </tr>
                        <?php foreach ($data as $item) {?>
                            <tr class="table-cell">
                                <td  class="al-left"><?= $item['name'] ?></td>
                                <td  class="al-right"><?= number_format($item['price_buy'], 0, ',', '.') ?></td>
                                <td  class="al-right"><?= number_format($item['price_sell'], 0, ',', '.') ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <p><?= Yii::t('app', 'update_at').': '.date('h:i d/m/Y',time()) ?></p>
                </div>
            </div>
        </div>
        <div class="bottom-gold row">
            <div class="col-1 col-md-3 col-sm-6 col-xs-12">
                <?=
                    frontend\widgets\newAttr\NewAttrWidget::widget([
                        'view' => 'news_sales',
                        'title' => Yii::t('app','news_sales'),
                        'attr' => ['category_id' => \common\models\news\NewsCategory::NEWS_SALES],
                        'limit' => 4
                    ]);
                ?>
            </div>
            <div class="col-2 col-md-3 col-sm-6 col-xs-12">
                <h3 class="gc"><?= Yii::t('app','follow_DH') ?></h3>
                <?=
                    \frontend\widgets\facebookcomment\FacebookcommentWidget::widget([
                            'view' => 'fanpage',
                        ]);
                ?>
            </div>
            <div class="col-3 col-md-3 col-sm-6 col-xs-12">
                <h3 class="gc"><?= Yii::t('app','item_reviews') ?></h3>
                <?= \frontend\widgets\review\ReviewWidget::widget([
                        'view' => 'view_gold'
                    ]) ?>
            </div>
            <div class="col-4 col-md-3 col-sm-6 col-xs-12">
                <h3 class="gc"><?= Yii::t('app','event') ?></h3>
                <?=
                    \frontend\widgets\banner\BannerWidget::widget([
                            'view' => 'banner-main-one',
                            'group_id' => \common\models\banner\BannerGroup::BANNER_EVENT_GOLD,
                            'limit' => 1
                        ]);
                ?>
            </div>
        </div>
    </div>
</div>