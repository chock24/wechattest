<?php
/* @var $this TransmitController */
/* @var $data Transmit */
?>

<!--<div class="view">-->

<?php /* echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_start')); ?>:</b>
	<?php echo CHtml::encode($data->time_start); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_end')); ?>:</b>
	<?php echo CHtml::encode($data->time_end); */?>
	
         <tr>
                                <td><?php echo CHtml::encode($data->title); ?></td>
                                <td><?php echo CHtml::encode(date('Y-m-d',$data->time_start)); ?>/<?php echo CHtml::encode(date('Y-m-d',$data->time_end)); ?></td>
                                <td><?php echo CHtml::encode($data->integral); ?></td>
                                <td><?php echo CHtml::encode($data->description); ?></td>
                                <td><a href="<?php echo Yii::app()->createUrl('/systems/transmit/update',array('id'=>@$data->id)); ?>"  onclick = 'js:return popup($(this),"修改转发信息",450,290);'))>修改</a></td>
                                <td><a href="<?php echo Yii::app()->createUrl('/systems/transmit/view',array('id'=>@$data->id)); ?>">查看</a></td>
                            </tr>


	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('keyword')); ?>:</b>
	<?php echo CHtml::encode($data->keyword); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('multi')); ?>:</b>
	<?php echo CHtml::encode($data->multi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_file_id')); ?>:</b>
	<?php echo CHtml::encode($data->source_file_id); ?>
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

<!--</div>-->