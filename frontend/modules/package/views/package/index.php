<?php
use common\components\ClaHost;
use common\models\Province;
use yii\helpers\Url;
use common\components\ClaLid;
?>
<?php //Menu main
echo frontend\widgets\banner\BannerWidget::widget([
    'view' => 'banner-main-in',
    'group_id' => 5,
])
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
                            <div class="buttons">
                                <div class="list active">
                                    <img src="<?= yii::$app->homeUrl ?>images/img_sapxep_1.png" alt="">
                                </div>
                                <div class="grid">
                                    <img src="<?= yii::$app->homeUrl ?>images/img_sapxep_2.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(isset($data) && $data){
                    ?>
                    <div class="pro_flex" id="wrapper">
                    <?php
                    $i=3;
                    foreach ($data as $key ){
                        $i+3;
                        $link = \yii\helpers\Url::to(['/package/package/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                        ?>
                        <div class="pro_card wow fadeIn"  data-wow-delay="0.<?= $i ?>s">
                            <a href="<?= $link ?>">
                                <div class="card_img">
                                    <img src="<?= ClaHost::getImageHost(), $key['avatar_path']. $key['avatar_name'] ?>" alt="<?= $key['name'] ?>">
                                </div>
                                <div class="card_text">
                                    <div class="title"><?= $key['name'] ?></div>
                                    <?php
                                    if(isset($key['province_id']) && $key['province_id']){
                                        $provin= Province::findOne(['id'=>$key['province_id']]);
                                    }
                                    ?>
                                    <div class="adress"><span><?= isset($key['province_id']) && $key['province_id'] ? $provin->name  : 'Đang cập nhật'?></span><span>60km</span></div>
                                    <div class="date_time"><img src="<?= yii::$app->homeUrl ?>images/time_pro.png" alt=""><span><?= date('d',$key['updated_at'])?></span>-<span><?= date('m',$key['updated_at'])?></span>-<span><?= date('Y',$key['updated_at']) ?></span></div>
                                </div>
                            </a>
                            <label class="heart">
                                <input class="Dashboard" name="" type="checkbox">
                                <div class="check">
                                    <span class="iuthik1 active"><img class="img_add_tim" src="<?= yii::$app->homeUrl ?>images/tim.png" alt=""></span>
                                    <span class="iuthik2"><i class="fas fa-heart"></i></span>
                                </div>
                            </label>
                            <?php if(isset($key['ishot']) && $key['ishot']==1){?>
                                <div class="hot_product"><img src="<?= yii::$app->homeUrl?>images/hot_product.png" alt=""></div>
                            <?php }?>
                        </div>
                    <?php } ?>
                    </div>
                    <?php } else {?>
                            <div class="" style="width: 100%;color: #289300;background: #ffffff; border: 1.5px solid #289300; height: 50px; display: flex; justify-content: center;align-items: center">
                                <i class="fas fa-bomb" style="color:#289300 "></i> Rất tiếc! Không tìm thấy sản phẩm mà bạn cần tìm.
                                <a href="<?=\yii\helpers\Url::to(['/package/package/index'])?>">Quay lại</a>
                            </div>
                        <?php }?>
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
