<?php
/* @var $this AdminPublicController */
/* @var $model AdminPublic */

$this->breadcrumbs=array(
	'Admin Publics'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AdminPublic', 'url'=>array('index')),
	array('label'=>'Create AdminPublic', 'url'=>array('create')),
	array('label'=>'Update AdminPublic', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AdminPublic', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AdminPublic', 'url'=>array('admin')),
);
?>

<h1>View AdminPublic #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'admin_id',
		'public_id',
		'sort',
		'status',
		'isdelete',
		'time_created',
		'time_updated',
	),
)); ?>
