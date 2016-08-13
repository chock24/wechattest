<?php
/* @var $this TransmitController */
/* @var $model Transmit */

$this->breadcrumbs=array(
	'Transmits'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Transmit', 'url'=>array('index')),
	array('label'=>'Create Transmit', 'url'=>array('create')),
	array('label'=>'Update Transmit', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Transmit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Transmit', 'url'=>array('admin')),
);
?>

<h1>View Transmit #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type_id',
		'admin_id',
		'public_id',
		'title',
		'time_start',
		'time_end',
		'description',
		'content',
		'number',
		'integral',
		'status',
		'order_by',
		'time_created',
		'time_updated',
	),
)); ?>
