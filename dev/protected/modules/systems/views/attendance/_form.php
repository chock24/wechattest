<?php
/* @var $this AttendanceController */
/* @var $model Attendance */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attendance-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
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
		<?php echo $form->error($model,'public_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'integral'); ?>
		<?php echo $form->textField($model,'integral'); ?>
		<?php echo $form->error($model,'integral'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
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
		<?php echo $form->error($model,'time_updated'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->