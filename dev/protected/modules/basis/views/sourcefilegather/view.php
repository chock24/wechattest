<?php
/* @var $this SourceFileGatherController */
/* @var $model SourceFileGather */

$this->breadcrumbs=array(
	'Source File Gathers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SourceFileGather', 'url'=>array('index')),
	array('label'=>'Create SourceFileGather', 'url'=>array('create')),
	array('label'=>'Update SourceFileGather', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SourceFileGather', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SourceFileGather', 'url'=>array('admin')),
);
?>

<h1>View SourceFileGather #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'public_id',
		'type',
		'name',
		'count',
		'status',
		'sort',
		'isdelete',
		'time_created',
		'time_updated',
	),
)); ?>
