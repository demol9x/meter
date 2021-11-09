<?php

use yii\helpers\Url;
use common\components\ClaHost;

$this->title = 'Quản lý affiliate gian hàng';
//
?>
<style type="text/css">
    .affiliate-link-index .img {
        max-width: 100px;
        max-height: 50px;
        overflow: hidden;
    }

    .box-getlink .textcopy {
        overflow-x: auto;
        border: 1px dashed #ccc;
        padding: 7px 15px;
        background: #ebebeb;
        width: 100%;
    }

    .box-getlink .textcopy input {
        margin-bottom: 0px;
        white-space: nowrap;
        border: none;
        background: transparent;
        width: 100%;
    }

    .box-getlink button {
        white-space: nowrap;
        background: #17a349;
        border: none;
        color: #fff;
        padding: 0px 20px;
    }

    .box-getlink {
        margin: 0 auto;
        background: #fff;
        padding: 15px 0px;
        display: flex;
        position: relative;
    }
</style>
<div class="form-create-store">
    <div class="title-form">
        <h2>
            <img src="<?= Yii::$app->homeUrl ?>images/ico-bansanpham.png" alt=""> <?= $this->title ?>
        </h2>
    </div>
    <div class="ctn-form">
        <div class="affiliate-link-index">
            <div class="box-getlink">
                <span>Link giới thiệu của bạn:</span>
                <div class="textcopy">
                    <input id="linkcopy" value="<?= \yii\helpers\Url::to(['/login/login/signup', 'user_id' => Yii::$app->user->id], true); ?>">
                </div>
                <button onclick="copyText()">Copy Link</button>
                <script type="text/javascript">
                    function copyText() {
                        /* Get the text field */
                        var copyText = document.getElementById("linkcopy");

                        /* Select the text field */
                        copyText.select();

                        /* Copy the text inside the text field */
                        document.execCommand("copy");
                    }
                </script>
            </div>
            <p>ID giới thiệu của bạn: <b><?= Yii::$app->user->id ?></b></p>
            <table class="table table-bordered">
                <tbody>
                    <tr class="header-table">
                        <td>
                            <b><?= Yii::t('app', 'shop') ?></b>
                        </td>
                        <td>
                            <b>ID</b>
                        </td>
                        <td class="center">
                            <b>Ngày tham gia</b>
                        </td>
                        <td class="center">
                            <b>Phần trăm</b>
                        </td>
                    </tr>
                    <?php
                    if ($shops) foreach ($shops as $shop) {
                        $url = Url::to(['/shop/shop/detail', 'id' => $shop['id'], 'alias' => $shop['alias']]);
                    ?>
                        <tr>
                            <td class="vertical-top" width="400">
                                <div class="img">
                                    <a href="<?= $url ?>">
                                        <img src="<?= ClaHost::getImageHost(), $shop['avatar_path'], $shop['avatar_name'] ?>" alt="<?= $shop['name'] ?>">
                                    </a>
                                </div>
                                <h5>
                                    <a href="<?= $url ?>" title="<?= $shop['name'] ?>"><?= $shop['name'] ?></a>
                                </h5>
                            </td>
                            <td>
                                <?= $shop['id'] ?>
                            </td>

                            <td>
                                <?=
                                    date('d-m-Y', $shop['created_time'])
                                ?>
                            </td>
                            <td class="center">
                                <div class="discout">
                                    <p>
                                        <?= ($shop['status_affiliate'] == \common\components\ClaLid::STATUS_ACTIVED) ? $shop['affiliate_gt_shop'] : '0' ?>%
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    function copyText() {
        /* Get the text field */
        var copyText = document.getElementById("linkcopy");

        /* Select the text field */
        copyText.select();

        /* Copy the text inside the text field */
        document.execCommand("copy");
    }
</script>