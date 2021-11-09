<div class="list-categories">
    <div class="container">
        <div class="row">
            <?php
            if (isset($data) && $data) { ?>
                <?php foreach ($data as $item) { 
                    $item['name'] = Trans($item['name'], $item['name_en']);
                    ?>
                    <div class="item-categories">
                        <div class="img-item-categories">
                            <a href="<?php echo $item['link']; ?>"
                               title="<?php echo $item['name']; ?>">
                                <img src="<?= \common\components\ClaHost::getImageHost(), $item['avatar_path'], 's400_400/', $item['avatar_name'] ?>"

                                     alt="<?php echo $item['name'] ?>">
                            </a>
                        </div>
                        <div class="title-item-categories">
                            <h2>
                                <a href="<?php echo $item['link']; ?>"
                                   title="<?= $item['name'] ?>">
                                    <?= $item['name'] ?>
                                </a>
                            </h2>
                            <p>
                                <?= Trans($item['description'], $item['description_en']) ?>
                            </p>
                            <a href="<?php echo $item['link']; ?>"
                               class="view-more-categories"><?= Yii::t('app', 'view_more') ?></a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else {
                echo Yii::t('app', 'list_is_null');
            } ?>
        </div>
    </div>
</div>
