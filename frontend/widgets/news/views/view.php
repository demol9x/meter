<?php
use common\components\ClaHost;
use yii\helpers\Url;
?>
<?php if (isset($data) && $data) {?>
    <div class="slide-tin">
        <?php foreach ($data as $key ){
            $url = Url::to(['/news/news/detail', 'id' => $key['id'], 'alias' => $key['alias']]);?>
        <div class="tinkhac-item">
            <a class="item-img" href="<?= $url ?>"><img src="<?= ClaHost::getImageHost(). $key['avatar_path']. 's400_400/'. $key['avatar_name'] ?>" alt="<?= $key['title'] ?>"></a>
            <a class="content_16" href=""><?= $key['title'] ?></a>
        </div>
        <?php }?>
    </div>
<?php } ?>