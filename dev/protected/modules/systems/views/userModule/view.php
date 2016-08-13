<?php
/* @var $this UserModuleController */
/* @var $model UserModule */

$this->breadcrumbs=array(
	'User Modules'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List UserModule', 'url'=>array('index')),
	array('label'=>'Create UserModule', 'url'=>array('create')),
	array('label'=>'Update UserModule', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserModule', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserModule', 'url'=>array('admin')),
);
?>

<h1>View UserModule #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'public_id',
		'title',
		'bg_img',
		'url',
		'order_by',
		'time_created',
		'time_updated',
	),
)); ?>
