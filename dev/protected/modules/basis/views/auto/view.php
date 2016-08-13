<?php
/* @var $this AutoController */
/* @var $model Auto */

$this->breadcrumbs=array(
	'Autos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Auto', 'url'=>array('index')),
	array('label'=>'Create Auto', 'url'=>array('create')),
	array('label'=>'Update Auto', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Auto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Auto', 'url'=>array('admin')),
);
?>

<h1>View Auto #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'admin_id',
		'public_id',
		'type',
		'content',
		'source_file_id',
		'timing',
		'time_start',
		'time_end',
		'status',
		'sort',
		'isdelete',
		'time_created',
		'time_updated',
	),
)); ?>
