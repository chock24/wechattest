<?php
/* @var $this GiftTypeController */
/* @var $model GiftType */

$this->breadcrumbs=array(
	'Gift Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List GiftType', 'url'=>array('index')),
	array('label'=>'Create GiftType', 'url'=>array('create')),
	array('label'=>'Update GiftType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GiftType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GiftType', 'url'=>array('admin')),
);
?>

<h1>View GiftType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'admin_id',
		'name',
		'status',
		'time_created',
		'time_updated',
	),
)); ?>
