<?php

use common\components\ClaHost;
use common\models\Province;
use frontend\models\UserRecruiterInfo;
use common\models\recruitment\Skill;
use common\models\recruitment\Recruitment;
use yii\helpers\Url;
?>
<style type="text/css">
    .company-intro-requirment h1{
        color: #e81e10;
        font-size: 17px;
        font-family: 'Roboto Medium';
        text-transform: uppercase;
        max-width: 500px;
    }
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="company-intro">
        <div class="company-intro-img">
            <a href="javascript:void(0)">
                <img src="<?= ClaHost::getImageHost(), $model['avatar_path'], 's180_180/', $model['avatar_name'] ?>" />
            </a>
        </div>
        <div class="company-intro-requirment">
            <h1>
                <?= $model['title'] ?>
            </h1>
            <h4><?= $company['username'] ?></h4>
            <p><?= $company_info['address'] ?></p>
            <?php
            $provinces = Province::getNameProvince($model->locations);
            ?>
            <p>Nơi làm việc: <?= implode(', ', $provinces) ?></p>
            <div class="login-btn">
                <p>Mức lương:<a href="javascript:void(0)"><?= Recruitment::getSalaryDetail($model); ?></a></p>
            </div>
        </div>
        <div class="btn-push-cv">
            <a class="btn-cv" href="<?= Url::to(['/recruitment/apply/apply', 'id' => $model['id']]) ?>">
                Nộp Đơn
            </a>
            <!--<button class="btn-gg"><i class="fa fa-fw fa-google"></i> <span> Nộp đơn với Google</span></button>-->
<!--            <div class="show-view-i">
                <span>1635 lượt xem</span>
                <span>Đăng tuyển 3 ngày trước</span>
            </div>-->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 box-hot-job row-10">
        <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 pad-10">
            <div class="bg-white pad-15 box-lg mar-shadow">
                <h2>
                    <span>Các phúc lợi dành cho bạn</span>
                </h2>
                <?= $info->benefit ?>
            </div>
            <?php
            $skills = Skill::getSkillByIds($model->skills);
            if (isset($skills) && $skills) {
                ?>
                <div class="bg-white pad-15 box-lg mar-shadow">
                    <div class="your-skill">
                        <h2>
                            Bạn Nên Có Kỹ Năng
                        </h2>
                        <?php foreach ($skills as $skill_id => $skill_name) { ?>
                            <a href="javascript:void(0)" class="boder-btn"><?= $skill_name ?></a>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="bg-white pad-15 box-lg mar-shadow">
                <div class="your-do">
                    <h2>Bạn Sẽ Làm Gì</h2>
                    <?= $info->description ?>
                </div>
            </div>
            <div class="bg-white pad-15 box-lg mar-shadow">
                <div class="your-do">
                    <h2>Chuyên Môn Của Bạn</h2>
                    <?= $info->job_requirement ?>
                </div>
            </div>
            <div class=" bg-white pad-15">
                <div class="your-benefit">
                    <h2>
                        Về Công Ty Chúng Tôi
                    </h2>
                    <p>
                        <strong><?= $company['username'] ?></strong>
                    </p>
                    <p>Địa chỉ: <?= $company_info['address'] ?></p>
                    <p>Tên người liên hệ: <strong><?= $company_info['contact_name'] ?></strong></p>
                    <p>Qui mô công ty: <?= UserRecruiterInfo::getScaleName($company_info->scale); ?></p>
                    <p>
                        <?= nl2br($company_info['description']) ?>
                    </p>
                    <p class="push-top">
                        <a href="#"><i class="fa fa-arrow-right"></i> Việc làm khác từ Công ty này</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12  pad-10 box-job-right">
            <div class="bg-white pad-15 box-lg mar-shadow">
                <h2>
                    <span>Bạn có muốn</span>
                </h2>
                <div class="social-box">
                    <a class="social-w" href=""><i class="fa fa-envelope"></i>Gửi email việc làm tương tự</a>
                    <a class="social-w" href=""><i class="fa fa-mail-forward"></i> Giới thiệu bạn bè</a>
                    <p class="social-w"><i class="fa fa-share-alt"></i>Chia sẻ : 
                        <?php
                        $link = Url::current();
                        $title = $model->meta_title ? $model->meta_title : $model->title;
                        $share_facebook = 'http://www.facebook.com/sharer.php?u=' . $link . '&utm_source=Facebook&utm_medium=ShareButton&utm_campaign=SocialNetwork&t=' . $title;
                        $share_linkedIn = 'http://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&utm_source=LinkedIn&utm_medium=ShareButton&utm_campaign=SocialNetwork&title=' . $title;
                        $share_twitter = 'http://twitter.com/home?status=' . $link;
                        ?>
                        <a title="Chia sẻ qua Facebook" href="<?= $share_facebook ?>">
                            <i class="fa fa-lg fa-facebook-square"></i>
                        </a> 
                        <a title="Chia sẻ qua LinkedIn" href="<?= $share_linkedIn ?>">
                            <i class="fa fa-lg fa-linkedin-square"></i>
                        </a>
                        <a title="Chia sẻ qua Twitter" href="<?= $share_twitter ?>">
                            <i class="fa fa-lg fa-twitter-square"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="bg-white pad-15 box-lg mar-shadow">
                <h2>
                    <span>Tổng Quan Công Việc</span>
                </h2>
                <div class="info-level">
                    <p><strong>Cấp Bậc</strong></p>
                    <p><?= Recruitment::getLevel($model->level); ?></p>
                    <p><strong>Ngành Nghề</strong></p>
                    <?php
                    $categories = common\models\recruitment\Category::getNameCategory($model->category_id);
                    foreach ($categories as $category_id => $category_name) {
                        ?>
                        <p><?= $category_name ?></p>
                    <?php } ?>
                </div>
            </div>
            <?=
            \frontend\widgets\recruitment\RecruitmentWidget::widget([
                'limit' => 5,
                'relation' => 1,
                'view' => 'relations'
            ]);
            ?>
        </div>
    </div>
</div>