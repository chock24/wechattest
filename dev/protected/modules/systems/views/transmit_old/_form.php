<?php
/* @var $this TransmitController */
/* @var $model Transmit */
/* @var $form CActiveForm */
?>

<div class="padding30 form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transmit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	
	<?php echo $form->errorSummary($model); ?>

<!--	<div class="row">
		<?php /* echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_id'); ?>
		<?php echo $form->textField($model,'admin_id'); ?>
		<?php echo $form->error($model,'admin_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'public_id'); ?>
		<?php echo $form->textField($model,'public_id'); ?>
		<?php echo $form->error($model,'public_id');*/ ?>
	</div>-->

	<div class="row">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;标题：
		<?php echo $form->textField($model,'title',array('size'=>46,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

<!--	<div class="row">
		<?php /*echo $form->labelEx($model,'time_start'); ?>
		<?php echo $form->textField($model,'time_start'); ?>
		<?php echo $form->error($model,'time_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_end'); ?>
		<?php echo $form->textField($model,'time_end'); ?>
		<?php echo $form->error($model,'time_end');*/ ?>
	</div>-->

	<div class="margin-top-15 row">
		详细描述：
		<?php echo $form->textField($model,'description',array('size'=>46,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="margin-top-15 row">
		&nbsp;&nbsp;&nbsp;关键字：
		<?php echo $form->textField($model,'keyword',array('size'=>46,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'keyword'); ?>
	</div>

<!--	<div class="row">
		<?php /*echo $form->labelEx($model,'multi'); ?>
		<?php echo $form->textField($model,'multi'); ?>
		<?php echo $form->error($model,'multi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_file_id'); ?>
		<?php echo $form->textField($model,'source_file_id'); ?>
		<?php echo $form->error($model,'source_file_id');*/ ?>
	</div>-->

	<div class="margin-top-15 row">
		转发积分：
		<?php echo $form->textField($model,'integral'); ?>
		<?php echo $form->error($model,'integral'); ?>
	</div>
<!--
	<div class="row">
		<?php /* echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sort'); ?>
		<?php echo $form->textField($model,'sort'); ?>
		<?php echo $form->error($model,'sort'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isdelete'); ?>
		<?php echo $form->textField($model,'isdelete'); ?>
		<?php echo $form->error($model,'isdelete'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_created'); ?>
		<?php echo $form->textField($model,'time_created'); ?>
		<?php echo $form->error($model,'time_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_updated'); ?>
		<?php echo $form->textField($model,'time_updated'); ?>
		<?php echo $form->error($model,'time_updated'); */?>
	</div>-->

	<div class="row buttons popup-footer">
		<?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存',array('class'=>'button button-green')); ?>
        <input type="button" value="取消" name="yt2" class="closed button">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->