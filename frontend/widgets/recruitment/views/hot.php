<?php

use yii\helpers\Url;
use common\models\recruitment\Recruitment;
use common\models\Province;
?>
<?php if (isset($data) && $data) { ?>
    <div class="col-lg-9 col-sm-7 col-md-8 col-xs-12 box-hot-job">
        <div class="bg-white pad-15">
            <h2><?= count($data) ?> việc làm hot</h2>
            <div class="table-job">
                <table class="rwd-table">
                    <tbody>
                        <tr class="header-title">
                            <th><h3>Vị trí đang tuyển</h3></th>
                            <th width="120"><h3>Mức lương</h3></th>
                            <th width="120"><h3>Số lượng</h3> </th>
                            <th><h3>Nơi làm việc</h3></th>
                        </tr>
                        <?php foreach ($data as $item) { ?>
                            <tr>
                                <td data-th="Vị trí đang tuyển">
                                    <span class="label-hot">HOT</span>
                                    <a class="name-job" href="<?= Url::to(['/recruitment/recruitment/detail', 'id' => $item['id'], 'alias' => $item['alias']]) ?>">
                                        <?= $item['title'] ?>
                                    </a>
                                </td>
                                <td data-th="Mức lương"><?= Recruitment::getSalaryDetail($item); ?></td>
                                <td data-th="Số lượng"><?= $item['quantity'] ?> người</td>
                                <td class="boder-btn" data-th="Nơi làm việc">
                                    <?php
                                    $provinces = Province::getProvincesByIds($item['locations']);
                                    if (count($provinces)) {
                                        foreach ($provinces as $province) {
                                            ?>
                                            <a href="javascript:void(0)"><?= $province['name'] ?></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="view-more-job">
                    <a href="<?= Url::to(['/recruitment/recruitment/index']) ?>">
                        Xem thêm việc làm 
                        <i class="fa fa-angle-right"></i>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>