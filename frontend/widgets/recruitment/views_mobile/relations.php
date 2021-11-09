<?php

use yii\helpers\Url;
use common\models\recruitment\Recruitment;
use common\models\Province;
?>
<?php if (isset($data) && $data) { ?>
    <div class="bg-white pad-15 box-lg mar-shadow">
        <h2>
            <span>Công việc tương tự</span>
        </h2>
        <div class="info-level">
            <ul>
                <?php foreach ($data as $item) { ?>
                    <li>
                        <a href="<?= Url::to(['/recruitment/recruitment/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>">
                            <?= $item['title'] ?>
                            <span><?= $item['username'] ?></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
