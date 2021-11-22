<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Quản lý hình thức';
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
                                <th style="width: 80%;">Tên hình thức</th>
                                <th style="width: 15%">Trạng thái</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($model as $data) { ?>
                                <tr data-key="<?= $data['id'] ?>">
                                    <td><?= $data['name'] ?> </td>
                                    <td><?= ($data['status']) ? 'Hiện' : 'Ẩn' ?></td>
                                    <td>
                                        <a href="<?php echo Url::toRoute(['product-category-type/update', 'id' => $data['id']]); ?>" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="<?php echo Url::toRoute(['product-category-type/delete', 'id' => $data['id']]); ?>" title="Delete" aria-label="Delete" data-confirm="Xóa danh mục '<?= $data['name'] ?>'?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
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