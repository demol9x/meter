<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl ?>gentelella/bootstrap-daterangepicker/daterangepicker.css">
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>gentelella/moment/min/moment.min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>gentelella/bootstrap-daterangepicker/daterangepicker.js"></script>
<div class="item-input-form">
    <label class="bold" for=""></label>
    <div class="group-input" >
    	<?php $model->start_time = $model->start_time ? date('d-m-Y', $model->start_time) : ''; ?>
        <?= $form->fields($model, 'type', ['class'=> '', 'arrSelect' => $model->getType()])->textSelect() ?>
        <div class="box" id="show-type" style="<?= ($model->type < 2) ? 'display: none' : ''; ?>">
	        <div class="start_time">
		        <?= $form->fields($model, 'start_time')->textInput(['class' => 'form-control date-picker']) ?>
		    </div>
		    <div class="number_time">
		        <?= $form->fields($model, 'number_time')->textInput() ?>
	        </div>
        </div>
       
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#type').change(function() {
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


