<?php
/* @var $this PosterTypeController */
/* @var $model PosterType */

$this->breadcrumbs=array(
	'Poster Types'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PosterType', 'url'=>array('index')),
	array('label'=>'Create PosterType', 'url'=>array('create')),
	array('label'=>'Update PosterType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PosterType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PosterType', 'url'=>array('admin')),
);
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'admin_id',
		'col_name',
		'is_delete',
		'time_created',
		'time_updated',
	),
)); ?>
