<?php 
	use yii\helpers\Html;
	use common\components\ClaHost;
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl ?>gentelella/bootstrap-daterangepicker/daterangepicker.css">
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>gentelella/moment/min/moment.min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>gentelella/bootstrap-daterangepicker/daterangepicker.js"></script>

<div class="item-input-form">
    <label class="bold" for=""></label>
    <div class="group-input" >
    	<?php $model->start_time = $model->start_time ? date('d-m-Y', $model->start_time) : ''; ?>
        <?= 
            $form->field($model, 'type', [
                'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
            ])->dropDownList($model->getType(), [
                'class' => 'form-control',
            ])->label($model->getAttributeLabel('type'), [
                'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
            ]);
        ?>
        <div class="boxss" id="show-type" style="<?= ($model->type < 2) ? 'display: none' : ''; ?>">
	        <div class="start_time">
                <?=
                    $form->field($model, 'start_time', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'class' => 'form-control date-picker',
                        'placeholder' => $model->getAttributeLabel('start_time')
                    ])->label($model->getAttributeLabel('start_time'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])
                ?>
		    </div>
		    <div class="number_time">
		        <?=
                    $form->field($model, 'number_time', [
                        'template' => '{label}<div class="col-md-10 col-sm-10 col-xs-12">{input}{error}{hint}</div>'
                    ])->textInput([
                        'class' => 'form-control',
                        'placeholder' => $model->getAttributeLabel('number_time')
                    ])->label($model->getAttributeLabel('number_time'), [
                        'class' => 'control-label col-md-2 col-sm-2 col-xs-12'
                    ])
                ?>
	        </div>
        </div>
       
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#product-type').change(function() {
			var type = parseInt($(this).val());
			if(type < 2) {
				$('#show-type').css('display', 'none');
			} else {
				$('#show-type').css('display', 'block');
			}
		});
        $('.date-picker').daterangepicker({
            timePickerIncrement: 5,
            locale: {
                format: 'DD-MM-YYYY',
                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
            singleDatePicker: true,
            calender_style: "picker_4"
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>


