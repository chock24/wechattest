<?php
/* @var $this TransmitTypeController */
/* @var $model TransmitType */

$this->breadcrumbs=array(
	'Transmit Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TransmitType', 'url'=>array('index')),
	array('label'=>'Create TransmitType', 'url'=>array('create')),
	array('label'=>'Update TransmitType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransmitType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransmitType', 'url'=>array('admin')),
);
?>

<h1>View TransmitType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'admin_id',
		'parent_id',
		'name',
		'status',
		'time_created',
		'time_updated',
	),
)); ?>
