<?php

use yii\helpers\Html;
use yii\helpers\Url;

$datas = (new \common\models\product\ProductCategory())->getDataProvider();

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý danh mục sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .category-right {
        float: right;
        margin-right: 5px;
        cursor: pointer;
    }

    .category-change {
        cursor: pointer;
    }

    tr:hover {
        background: #0080001c;
    }

    .save-order {
        width: 50px;
    }

    .fixed {
        position: fixed;
        z-index: 1;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100vh;
    }

    .flex {
        display: flex;
        width: 100%;
        height: 100%;
    }

    .child-flex {
        margin: auto;
        background: #0000009e;
        padding: 30px;
        border-radius: 5px;
    }
</style>
<div class="product-category-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?= Html::a('Tạo danh mục', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                    <?= Html::a('Xuất exel', ['exel'], ['class' => 'btn btn-success pull-right', 'target' => '_blank']) ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Stt</th>
                                <th style="width: 350px;">Tên danh mục</th>
                                <th>Mô tả</th>
                                <th>Sắp xếp</th>
                                <th>Hiện thị trang chủ</th>
                                <th>Hiện thị danh mục</th>
                                <th>Danh mục hot</th>
                                <th>Chỉ Admin</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($datas as $data) { ?>
                                <tr data-key="<?= $data['id'] ?>">
                                    <td><?= $i ?></td>
                                    <td style="width: 350px;" class="category-change category-<?= $data['parent'] ?>" data-parent="input-<?= $data['parent'] ?>" data-id="<?= $data['id'] ?>"><?= trim($data['name'], '.| _ _ '); ?> <i class="fa fa-caret-down category-right" aria-hidden="true"></i></td>
                                    <td><?= $data['description'] ?></td>
                                    <td><input data-id="<?= $data['id'] ?>" class="save-order" type="number" value="<?= $data['order'] ?>"></td>
                                    <td><?= ($data['show_in_home']) ? 'Hiện' : 'Ẩn' ?></td>
                                    <td><?= ($data['show_in_home_2']) ? 'Hiện' : 'Ẩn' ?></td>
                                    <td><?= ($data['isnew']) ? 'Hiện' : 'Ẩn' ?></td>
                                    <td><?= ($data['frontend_not_up']) ? 'Bật' : 'Tắt' ?></td>
                                    <td><?= ($data['status']) ? 'Hiện' : 'Ẩn' ?></td>
                                    <td style="display: none;"><input type="" id="input-<?= $data['id'] ?>" value="close" class="input-change-cat" data-id="<?= $data['id'] ?>"></td>
                                    <td>
                                        <a href="<?php echo Url::toRoute(['product-category/update', 'id' => $data['id']]); ?>" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="<?php echo Url::toRoute(['product-category/delete', 'id' => $data['id']]); ?>" title="Delete" aria-label="Delete" data-confirm="Xóa danh mục '<?= $data['name'] ?>'?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
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
<script>
    $(document).ready(function() {
        // menu category
        var cat = $(".category-change");
        for (var i = 0; i < cat.length; i++) {
            var item = $(cat[i]);
            var id = item.attr('data-id');
            var iten_child = $('.category-' + id);
            if (item.attr('data-parent') != 'input-0') {
                item.parent().css('display', 'none');
            }
            if (iten_child.length == 0) {
                $(item).children('.category-right').css('display', 'none');
            }
        }

        $(".category-change").click(function() {
            var id = $(this).attr("data-id");
            if ($("#input-" + id).val() == 'open') {
                $(this).children('.category-right').css('transform', 'rotate(0deg)');
                $("#input-" + id).val("close");
                var cat = $(".category-change");
                for (var i = 0; i < cat.length; i++) {
                    var item = $(cat[i]);
                    var item_parent = item.attr('data-parent');
                    var input = item.attr('data-id');
                    console.log($('#' + item_parent).val());
                    if ($('#' + item_parent).val() == 'close') {
                        $('#input-' + input).val('close');
                        item.parent().css('display', 'none');
                    }
                }
            } else {
                $("#input-" + id).val("open");
                $(this).children('.category-right').css('transform', 'rotate(-90deg)');
                $('.category-' + id).parent().css('display', 'table-row');
            }
        });
        $(".save-order").change(function() {
            var id = $(this).attr("data-id");
            $('body').append('<div id="fixed-loading-img" class="fixed"><div class="flex"><div class="child-flex"><img style="padding:5px 10px;" src="' + baseUrl + 'images/ajax-loader.gif" /></div></div></div>');
            $.ajax({
                url: '<?= Url::to(['save-order']) ?>',
                data: {
                    id: id,
                    order: $(this).val()
                },
                success: function(result) {
                    $('#fixed-loading-img').remove();
                }
            });
        });
    });
</script>