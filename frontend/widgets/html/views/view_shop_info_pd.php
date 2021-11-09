<?php

use yii\helpers\Url;
use common\components\ClaHost;
?>
<style type="text/css">
    .item-level a img{
        width: 30px;
        height: 30px;
    }
    .item-level a span{
        font-weight: normal;
        color: #000;
    }
    .item-level a {
        margin-bottom: 7px;
        display: block;
    }
    .yser-shop {
        font-size: 18px;
        color: #17a349 !important;
        font-weight: bold;
        position: relative;
        padding: 3px 36px 3px 14px;
        background: #ffe4004d;
        border-radius: 20px;
        margin-right: 12px;
    }
    .yser-shop span {
        position: absolute;
        top: 2px;
        left: 26px;
        font-size: 13px;
        font-weight: normal;
        color: #17a349 !important;
    }
</style>
<div class="banner-store visible-xs visible-sm visible-md hidden-lg">
    <img src="<?= ($model->image_name) ? ClaHost::getImageHost().$model->image_path . $model->image_name : ClaHost::getImageHost().'/imgs/df.png' ?>" alt="<?= $model->name ?>">
</div>
<div class="img-store">
    <div class="img">
        <a href="<?= Url::to(['/shop/shop/detail', 'alias' => $model->alias, 'id'=> $model->id]) ?>">
            <img src="<?= ($model->avatar_name) ? ClaHost::getImageHost().$model->avatar_path .'s100_100/'. $model->avatar_name : ClaHost::getImageHost().'/imgs/df.png' ?>" alt="<?= $model->name ?>" alt="<?= $model->name ?>">
        </a>
    </div>
    <h2>
        <a href="<?= Url::to(['/shop/shop/detail', 'alias' => $model->alias, 'id'=>$model->id]) ?>"><?= $model->name ?></a>
    </h2>
    <span id="online-desu">
    </span>
</div>
<div class="star">
    <span class="yser-shop">
        <?= 1 + date('Y',time()) - date('Y', $model->created_time) ?> 
        <span><?= Yii::t('app', 'year') ?></span>
    </span>
    <spam><?= Yii::t('app', 'rate') ?>:</spam>
    <a title="<?= $model['rate'] ?>" href="">
    <?php for ($i=1; $i <6 ; $i++) { ?>
        <i class="fa fa-star<?= ($model['rate'] >= $i) ? '' : '-o' ?> yellow"></i>
    <?php } ?>
    </a>
    <span><?= $model['rate_count'] ? '('.$model['rate_count'].')' : '' ?></span>
</div>
<!-- <p>
    <i class="fa fa-map-marker"></i> <?= Yii::t('app','address')  ?>: <?php //($model->address ? $model->address.', ' : '').$model->ward_name.', '.$model->district_name.', '.$model->province_name ?>
</p> -->
<?php if($model->level) { 
    $list_level = $model->getListLevel();
    ?>
    <div class="box-level">
        <?php if($list_level) foreach ($list_level as $level) { ?>
            <div class="item-level">
                <a  target="_blank" <?= $level->link ? 'href="'.$level->link.'"' : '' ?> >
                    <img src="<?= ($level->avatar_name) ? ClaHost::getImageHost().$level->avatar_path .'s100_100/'. $level->avatar_name : ClaHost::getImageHost().'/imgs/df.png' ?>" alt="<?= $level->name ?>" >
                    <span>
                        <?= $level->name ?>
                    </span>
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<div class="member-active">
    <?php 
        if($model->status == 1) {
            echo  \frontend\widgets\menu\MenuWidget::widget([
                        'view' => 'qc_dt',
                        'group_id' => 7,
                        'orther' => ['type' => $model->type]
                    ]);
        } else { 
            echo '<span class="non-active"><i class="fa fa-times"></i>'.Yii::t('app', 'shop_non_active').'</span>';
        }
    ?>
</div>
<div class="btn-member-active">
   <a href="<?= Url::to(['/shop/shop/detail', 'id' =>$model->id, 'alias' => $model->alias]) ?>" class="comment-store" style="color: #fff; width: auto; padding: 0px 10px;"><?= Yii::t('app', 'go_to_shop') ?></a>
</div>
<!-- <script type="text/javascript">
    function OnlineDesu(id) {
        href = '<?= Url::to(['/online/online']) ?>';
        $.ajax({
            url: href,
            data: {id:id},
            success: function(result){
                $('#online-desu').html(result);
            }
        });
    }
    OnlineDesu(<?= $model->id ?>);
    setInterval(function(){ OnlineDesu(<?= $model->id ?>); }, <?= \common\models\User::SPACE_REQUEST_TIME ?>);
</script> -->