<?php
/* @var $this AttendanceController */
/* @var $data Attendance */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->admin_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('public_id')); ?>:</b>
	<?php echo CHtml::encode($data->public_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('integral')); ?>:</b>
	<?php echo CHtml::encode($data->integral); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sort')); ?>:</b>
	<?php echo CHtml::encode($data->sort); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('isdelete')); ?>:</b>
	<?php echo CHtml::encode($data->isdelete); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_created')); ?>:</b>
	<?php echo CHtml::encode($data->time_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_updated')); ?>:</b>
	<?php echo CHtml::encode($data->time_updated); ?>
	<br />

	*/ ?>

</div>