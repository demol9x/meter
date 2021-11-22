<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Quản lý dự án';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Thêm mới', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 35%;">Tên dự án</th>
                                <th style="width: 30%">Địa chỉ</th>
<!--                                <th style="width: 10%">Tỉnh/ thành phố</th>-->
<!--                                <th style="width: 10%">Quận/ huyện</th>-->
<!--                                <th style="width: 10%">Phường/ xã</th>-->
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($model as $data) { ?>
                                <tr data-key="<?= $data['id'] ?>">
                                    <td><?= $data['name'] ?> </td>
                                    <td><?= $data['address'] ?></td>
<!--                                    <td>--><?//= $data['province_id'] ?><!--</td>-->
<!--                                    <td>--><?//= $data['district_id'] ?><!--</td>-->
<!--                                    <td>--><?//= $data['ward_id'] ?><!--</td>-->
                                    <td>
                                        <a href="<?php echo Url::toRoute(['project/update', 'id' => $data['id']]); ?>" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="<?php echo Url::toRoute(['project/delete', 'id' => $data['id']]); ?>" title="Delete" aria-label="Delete" data-confirm="Xóa danh mục '<?= $data['name'] ?>'?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>