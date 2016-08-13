<?php
/* @var $this WelcomeController */
/* @var $model Welcome */

$this->breadcrumbs=array(
	'Welcomes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Welcome', 'url'=>array('index')),
	array('label'=>'Create Welcome', 'url'=>array('create')),
	array('label'=>'Update Welcome', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Welcome', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Welcome', 'url'=>array('admin')),
);
?>

<h1>View Welcome #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'admin_id',
		'public_id',
		'type',
		'content',
		'source_file_id',
		'status',
		'sort',
		'isdelete',
		'time_created',
		'time_updated',
	),
)); ?>
