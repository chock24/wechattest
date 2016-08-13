<?php
/* @var $this TransmitUserController */
/* @var $model TransmitUser */

$this->breadcrumbs=array(
	'Transmit Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransmitUser', 'url'=>array('index')),
	array('label'=>'Create TransmitUser', 'url'=>array('create')),
	array('label'=>'Update TransmitUser', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransmitUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransmitUser', 'url'=>array('admin')),
);
?>

<h1>View TransmitUser #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'transmit_id',
		'user_id',
		'remark',
		'status',
		'time_created',
	),
)); ?>
