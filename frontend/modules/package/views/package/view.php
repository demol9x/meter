<?php
use common\components\ClaHost;
use common\models\Province;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<div class="site52_pro_col12_nhathau">
    <div class="container_fix">
        <div class="pro_flex">
            <?php //gói thầu
            echo frontend\widgets\packageFilter\PackageFilterWidget::widget([
                'view'=>'view',
            ]);
            ?>

            <div class="site52_pro_col10_nhathau">
                <div class="pro_package">
                    <div class="pro_content">
                        <div class="content_text">
                            <h3>gói thầu</h3>
                        </div>
                        <div class="pro_select_env">
                            <?php //Menu main
                            echo frontend\widgets\packageFilter\PackageFilterWidget::widget([
                                'view'=>'view_sort'
                            ]);
                            ?>
                            <a href="<?= Url::to(['/package/package/index'])?>" class="sapxep_1">
                                <img src="<?= yii::$app->homeUrl?>images/img_sapxep_1.png" alt="">
                            </a>
                            <a href="<?= Url::to(['/package/package/view'])?>" class="sapxep_2">
                                <img src="<?= yii::$app->homeUrl?>images/img_sapxep_2.png" alt="">
                            </a>
                        </div>
                    </div>
                    <?php
                    if(isset($data) && $data){
                        ?>
                        <div class="pro_flex grid">
                            <?php
                            $i=1;
                            foreach ($data as $key ){
                                $i+2;
                                $link = \yii\helpers\Url::to(['/package/package/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                                ?>
                                <div class="pro_card wow fadeIn"  data-wow-delay="0.<?= $i?>s">
                                    <a href="<?= $link ?>">
                                        <div class="card_img">
                                            <img src="<?= ClaHost::getImageHost(), $key['avatar_path']. $key['avatar_name'] ?>" alt="<?= $key['name'] ?>">
                                        </div>
                                        <div class="card_text">
                                            <div class="title"><?= $key['name'] ?></div>

                                            <?php  $provin= Province::findOne(['id'=>$key['province_id']])?>
                                            <div class="adress"><span><?= $provin->name ?></span><span>60km</span></div>
                                            <div class="date_time"><img src="<?= yii::$app->homeUrl?>images/time_pro.png" alt=""><span><?= date('d',$key['updated_at'])?> </span>/<span><?= date('m',$key['updated_at'])?></span>/<span><?= date('Y',$key['updated_at']) ?></span></div>
                                        </div>
                                    </a>
                                    <div class="heart">
                                        <a href="" class="add_tim active"><img class="img_add_tim" src="<?= yii::$app->homeUrl?>images/tim.png" alt=""></a>
                                        <a href="" class="add_tim_1"><i class="fas fa-heart"></i></a>
                                    </div>
                                    <?php if(isset($key['ishot']) && $key['ishot']==1){?>
                                        <div class="hot_product"><img src="<?= yii::$app->homeUrl?>images/hot_product.png" alt=""></div>
                                    <?php }?>
                                </div>
                            <?php }?>
                        </div>
                    <?php } ?>
                </div>
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
