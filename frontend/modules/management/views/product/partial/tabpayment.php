<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'payment_transfer', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'payment_transfer', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'payment_transfer'); ?>
    </div>
</div>