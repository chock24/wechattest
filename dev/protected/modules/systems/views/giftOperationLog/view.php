<?php
/* @var $this GiftOperationLogController */
/* @var $model GiftOperationLog */

$this->breadcrumbs=array(
	'Gift Operation Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GiftOperationLog', 'url'=>array('index')),
	array('label'=>'Create GiftOperationLog', 'url'=>array('create')),
	array('label'=>'Update GiftOperationLog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GiftOperationLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GiftOperationLog', 'url'=>array('admin')),
);
?>

<h1>View GiftOperationLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'gift_id',
		'admin_id',
		'genre',
		'score',
		'remark',
		'isdelete',
		'time_created',
	),
)); ?>
