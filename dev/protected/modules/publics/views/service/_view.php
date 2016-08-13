<?php
/* @var $this ServiceController */
/* @var $data Service */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->admin_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('public_id')); ?>:</b>
	<?php echo CHtml::encode($data->public_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account')); ?>:</b>
	<?php echo CHtml::encode($data->account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nickname')); ?>:</b>
	<?php echo CHtml::encode($data->nickname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kf_id')); ?>:</b>
	<?php echo CHtml::encode($data->kf_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('kf_headimg')); ?>:</b>
	<?php echo CHtml::encode($data->kf_headimg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auto_accept')); ?>:</b>
	<?php echo CHtml::encode($data->auto_accept); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accepted_case')); ?>:</b>
	<?php echo CHtml::encode($data->accepted_case); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sort')); ?>:</b>
	<?php echo CHtml::encode($data->sort); ?>
	<br />

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