<?php
use common\components\ClaHost;
use yii\helpers\Url;
?>
<?php if (isset($data) && $data) {?>
    <div class="slide-tin">
        <?php foreach ($data as $key => $value){
            $url = Url::to(['/news/news/detail', 'id' => $value['id'], 'alias' => $value['alias']]);?>
        <div class="tinkhac-item">
            <a class="item-img" href="<?= $url ?>"><img src="<?= ClaHost::getImageHost(). $value['avatar_path']. 's400_400/'. $value['avatar_name'] ?>" alt="<?= $value['title'] ?>"></a>
            <a class="content_16" href="<?= $url ?>"><?= $value['title'] ?></a>
        </div>
        <?php }?>
    </div>
<?php } ?>