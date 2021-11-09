<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\models\recruitment\Recruitment;
use common\models\Province;
?>
<div id="main-content" class="bg-list-page">
    <div class="container">
        <div class="list-job">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 box-hot-job  awe-check">
                    <div class="bg-white pad-15">
                        <div class="row">
                            <?=
                            frontend\widgets\recruitmentFilterLeft\RecruitmentFilterLeftWidget::widget([
                            ]);
                            ?>
                            <?php if (isset($data) && $data) { ?>
                                <div class="col-lg-7 col-md-7 col-sm-8 col-xs-12">
                                    <div class="list-item-job">
                                        <h2>
                                            <span><?= $totalitem ?></span> công việc được tìm thấy
                                        </h2>
                                        <?php foreach ($data as $item) { ?>
                                            <div class="item-job-company">
                                                <div class="logo-company">
                                                    <a href="<?= Url::to(['/recruitment/recruitment/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>">
                                                        <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's200_200/', $item['avatar_name'] ?>" />
                                                    </a>
                                                </div>
                                                <div class="content-requirment">
                                                    <h3>
                                                        <a href="<?= Url::to(['/recruitment/recruitment/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>"><?= $item['title'] ?></a>
                                                    </h3>
                                                    <p><?= $item['username'] ?></p>
                                                    <p>
                                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                        <?php
                                                        $provinces = Province::getProvincesByIds($item['locations']);
                                                        ?>
                                                        <?= implode(', ', array_column($provinces, 'name')) ?>
                                                    </p>
                                                    <a href="javascript:void(0)">
                                                        <i class="fa fa-money" aria-hidden="true"></i>
                                                        <?= Recruitment::getSalaryDetail($item) ?>
                                                    </a>
                                                    <p>Cập nhật: <?= date('d-m-Y', $item['updated_at']); ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="paginate">
                                        <?=
                                        \yii\widgets\LinkPager::widget([
                                            'pagination' => new yii\data\Pagination([
                                                'totalCount' => $totalitem,
                                                'pageSize' => $limit
                                                    ])
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?=
                            \frontend\widgets\banner\BannerWidget::widget([
                                'group_id' => 2,
                                'view' => 'ads_in'
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>