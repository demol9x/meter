<?php
\Yii::$app->session->open();
use yii\helpers\Url;
use common\models\rating\RateResponse;
?>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-danhgia.png" alt=""> <?= Yii::t('app', 'rate') ?>
        </h2>
    </div>
    <div class="review-store">
        <?php if(isset($_SESSION['create_shop'])) {?>
            <p style="color: green"><b><?= Yii::t('app', 'guide') ?>:</b> <?= Yii::t('app', 'rate_text2_0') ?></p>
        <?php } ?>
        <div class="tab-review-star">
            <ul class=" tab-menu">
                <li><a class="active" href="javascript:voi(0);" id="1"><?= Yii::t('app', 'all') ?></a></li>
                <li><a href="javascript:voi(0);" id="2">1 <?= Yii::t('app', 'star') ?></a></li>
                <li><a href="javascript:voi(0);" id="3">2 <?= Yii::t('app', 'star') ?></a></li>
                <li><a href="javascript:voi(0);" id="4">3 <?= Yii::t('app', 'star') ?></a></li>
                <li><a href="javascript:voi(0);" id="5">4 <?= Yii::t('app', 'star') ?></a></li>
                <li><a href="javascript:voi(0);" id="6">5 <?= Yii::t('app', 'star') ?></a></li>
            </ul>
        </div>
        <div class="list-review-customer tab-menu-read tab-menu-read-1" style="display: block;">
            <?php
                $tg['rate1'] =[]; 
                $tg['rate2'] =[]; 
                $tg['rate3'] =[]; 
                $tg['rate4'] =[]; 
                $tg['rate5'] =[]; 
                if($rates) foreach ($rates as $rate) {
                    $tg['rate'.$rate['rating']][]= $rate;
                    $responses = RateResponse::getByRating($rate['id']);
                    echo frontend\widgets\html\HtmlWidget::widget([
                        'input' => [
                            'rate' => $rate,
                            'responses' => $responses
                        ],
                        'view' => 'view_rate_1'
                    ]);
                } 
            ?>
        </div>
        <?php for ($i=2; $i <7 ; $i++) { ?>
            <div class="list-review-customer tab-menu-read tab-menu-read-<?= $i ?>" style="display: none;">
                <?php
                    $rateaf = $tg['rate'.($i-1)]; 
                    if($rateaf) foreach ($rateaf as $rate) {
                        $responses = RateResponse::getByRating($rate['id']);
                        echo frontend\widgets\html\HtmlWidget::widget([
                            'input' => [
                                'rate' => $rate,
                                'responses' => $responses
                            ],
                            'view' => 'view_rate_1'
                        ]);
                ?>
            <?php }?>
            </div>
        <?php } ?>
    </div>
    <?php if(isset($_SESSION['create_shop'])) {?>
        <div class="botom-form btn-tool">
            <a href="<?= Url::to(['/management/shop/update']) ?>" class="add-info"><?= Yii::t('app', 'add_info') ?></a>
            <a href="<?= Url::to(['/management/shop/remove-new']) ?>" class="end-info"><?= Yii::t('app', 'you_was_know') ?></a>
        </div>
    <?php } ?>
</div>