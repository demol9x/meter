<?php $option = (new \common\models\product\ProductCategory())->optionsCategory(); ?>
<?= $form->fields($model, 'category_id', ['class' => '', 'arrSelect' => $option])->textSelect() ?>
<label class="lds">Danh mục phụ</label>
<div class="col-xs-12s">
	<div class="input-group-btn full-input">
		<div class="box-add-cat">
			<style type="text/css">
				.add-select-cat {
					margin-top: 10px;
					height: 32px;
					border: 1px dashed #CFCFCF;
					text-align: center;
					width: 100%;
					line-height: 32px;
					cursor: pointer;
					display: block;
					font-size: 16px;
					float: right;
					color: #000;
					background: #e5e5e5;
				}

				.item-cat {
					padding-top: 10px;
					clear: both;
				}

				.delete-cat {
					background: red;
					display: inline-block;
					text-align: center;
					color: #fff;
					font-size: 16px;
					padding: 3px 0px;
					cursor: pointer;
				}

				.item-cat select {
					height: 30px;
				}
			</style>
			<div id="box-append-cat" class="box-append-cat">
				<?php if ($model->id) {
					$rels = $model->list_category ? explode(' ', $model->list_category) : [];
					if ($rels) {
						unset($rels[0]);
						foreach ($rels as $key) { ?>
							<div class="item-cat">
								<div class="col-md-11 ">
									<?= \yii\helpers\Html::dropDownList('product_rel_cal[]', $key, $option, ['class' => 'form-control',]) ?>
								</div>
								<span class="delete-cat col-md-1">x</span>
							</div>
				<?php }
					}
				}
				?>
			</div>
			<a class="add-select-cat">+</a>
			<script type="text/javascript">
				$('.add-select-cat').click(function() {
					$('#box-append-cat').append('<div class="item-cat"><div class="col-md-11 "><select class="form-control"  name="product_rel_cal[]">' + $('#category_id').html() + ' </select></div><span class="delete-cat col-md-1">x</span></div>');
				});
				$(document).on('click', '.delete-cat', function() {
					if (confirm("Xác nhận xóa mục?")) {
						$(this).parent().remove();
					}
				});
			</script>
		</div>
	</div>
</div>