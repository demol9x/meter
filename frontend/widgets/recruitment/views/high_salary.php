<?php

use yii\helpers\Url;
?>
<?php if (isset($data) && $data) { ?>
    <div class="location-hot-job money-bag bg-white">
        <h2>
            <a href="javascript:void(0)">
                <img src="<?= Yii::$app->homeUrl ?>images/money-bag.png">Việc làm lương cao
            </a>
        </h2>
        <ul>
            <?php foreach ($data as $item) { ?>
                <li>
                    <a href="<?= Url::to(['/recruitment/recruitment/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?> <span>> $<?= $item['salary_min'] ?></span></a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>