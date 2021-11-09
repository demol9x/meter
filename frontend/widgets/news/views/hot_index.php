<?php

use common\components\ClaHost;
use yii\helpers\Url;
if (isset($data) && $data) { ?>
    <div class="col-left-news2">
        <div class="layout-cln layout-cln1">
            <div class="col-left-lcln">
                <?php if($data) { 
                    $item = $data[0];
                    unset($data[0]);
                    ?>
                    <div class="box-news2">
                        <div class="box-images">
                            <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>">
                                <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's700_700/', $item['avatar_name'] ?>" atl="<?= $item['title'] ?>" />
                            </a>
                        </div>
                        <div class="box-info">
                            <h3>
                                <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                            </h3>
                            <div class="desc-news2">
                                <?= $item['short_description'] ?>
                            </div>
                            <div class="date-news2">
                                <span class="date1">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    <?= date('d/m/Y', $item['publicdate']) ?>
                                </span>
                                <span>|</span>
                                <span class="date2">
                                    <?= Yii::t('app', 'author') ?>: <?= $item['author'] ? $item['author'] : Yii::t('app', 'admin') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-right-lcln">
                <div class="box-news3">
                    <div class="list-box-news3">
                        <?php 
                            $i=1;
                            if(count($data)) { 
                            foreach ($data as $item) { 
                                if($i > 2) {
                                    break;
                                } else {
                                    unset($data[$i]);
                                    $i++;
                                }
                            ?>
                                <div class="item-box-new3">
                                    <div class="box-images">
                                        <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>">
                                            <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's300_300/', $item['avatar_name'] ?>" atl="<?= $item['title'] ?>" />
                                        </a>
                                    </div>
                                    <div class="box-info">
                                        <h3>
                                            <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                                        </h3>
                                        <div class="date-news2">
                                            <span class="date1">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                <?= date('d/m/Y', $item['publicdate']) ?>
                                            </span>
                                            <span>|</span>
                                            <span class="date2">
                                                <?= Yii::t('app', 'author') ?>: <?= $item['author'] ? $item['author'] : Yii::t('app', 'admin') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <?=
            \frontend\widgets\banner\BannerQcWidget::widget([
                'view' => 'banner_qc_in_new',
                'group_id' => \common\components\ClaLid::getIdQc('index'),
                'limit' => 1,
                'stt' => 6,
            ])
        ?>
        <div class="layout-cln layout-cln2">
            <div class="box-news4">
                <div class="list-box-news4">
                    <?php 
                         if(count($data)) { 
                            foreach ($data as $item) { 
                            ?>
                            <div class="item-box-new4">
                                <div class="box-images">
                                    <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>">
                                        <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's300_300/', $item['avatar_name'] ?>" atl="<?= $item['title'] ?>" />
                                    </a>
                                </div>
                                <div class="box-info">
                                    <h3>
                                        <a href="<?= Url::to(['/news/news/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
                                    </h3>
                                    <div class="desc-news2">
                                        <?= $item['short_description'] ?>
                                    </div>
                                    <div class="date-news2">
                                    <span class="date1">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <?= date('d/m/Y', $item['publicdate']) ?>
                                    </span>
                                        <span>|</span>
                                        <span class="date2">
                                        <?= Yii::t('app', 'author') ?>: <?= $item['author'] ? $item['author'] : Yii::t('app', 'admin') ?>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>