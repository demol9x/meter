<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use common\models\product\ProductCategory;
use common\components\ClaHost;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý danh mục sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>
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
                    <?php
                    $model = new ProductCategory();
                    $provider = new ArrayDataProvider([
                        'allModels' => $model->getDataProvider(),
                        'sort' => [
                            'attributes' => ['id', 'name', 'parent'],
                        ],
                        'pagination' => [
                            'pageSize' => 1000,
                        ],
                    ]);
                    ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $provider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name' => [
                                'header' => Yii::t('app', 'menu'),
                                'content' => function ($model) {
                                    return $model['name'];
                                }
                            ],
                            [
                                'header' => Yii::t('app', 'Icon'),
                                'content' => function ($model) {
                                    return $model['icon_name'] ? '<img src="' . ClaHost::getImageHost() . $model['icon_path'] . 's100_100/' . $model['icon_name'] . '" />' : '';
                                }
                            ],
                            [
                                'header' => Yii::t('app', 'Avatar'),
                                'content' => function ($model) {
                                    return $model['avatar_name'] ? '<img src="' . ClaHost::getImageHost() . $model['avatar_path'] . 's100_100/' . $model['avatar_name'] . '" />' : '';
                                }
                            ],
                            [
                                'header' => Yii::t('app', 'Backgruond'),
                                'content' => function ($model) {
                                    return $model['bgr_name'] ? '<img src="' . ClaHost::getImageHost() . $model['bgr_path'] . 's100_100/' . $model['bgr_name'] . '" />' : '';
                                }
                            ],
                            'isnew' => [
                                'header' => Yii::t('app', 'fresh'),
                                'content' => function ($model) {
                                    return $model['isnew'] ? Yii::t('app', 'yes') : Yii::t('app', 'no');
                                }
                            ],
                            'show_in_home' => [
                                'header' => Yii::t('app', 'show_in_home'),
                                'content' => function ($model) {
                                    return $model['show_in_home'] ? Yii::t('app', 'yes') : Yii::t('app', 'no');
                                }
                            ],
                            'order' => [
                                'header' => Yii::t('app', 'order'),
                                'content' => function ($model) {
                                    return $model['order'];
                                }
                            ],
                            'point_percent' => [
                                'header' => Yii::t('app', 'point_percent'),
                                'content' => function ($model) {
                                    return $model['point_percent'];
                                }
                            ],
                            // 'level',
                            'status' => [
                                'header' => Yii::t('app', 'status'),
                                'content' => function ($model) {
                                    return $model['status'] ? Yii::t('app', 'view') : Yii::t('app', 'dont_view');
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        $url = \yii\helpers\Url::to(['/product/product-category/update-point', 'id' => $model['id']]);
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'title' => 'Cập nhật',
                                        ]);
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
