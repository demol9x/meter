<div class="item-input-form">
    <label class="bold" for="">Phí vận chuyển</label>
    <div class="group-input">
    	<div class="form-group field-product-quantity has-success">
        	<div class="full-input-checkbox">
	        	<span class="labelss">Miễn phí nội thành: </span>
	        	<input type="checkbox" name="Product[fee_ship]" value="1" <?= $model->fee_ship ? 'checked' : '' ?> id="checkbox-fee_ship" class="ios8-switch ios8-switch-small fee_ship">
	        	<label for="checkbox-fee_ship"></label>
        	</div>
		</div>

        <?= $form->fields($model, 'note_fee_ship', ['class'=> ''])->textArea(['maxlength' => true]) ?>
       
    </div>
</div>

