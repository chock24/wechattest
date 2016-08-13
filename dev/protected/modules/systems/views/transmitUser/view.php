<?php
/* @var $this GiftController */
/* @var $model Gift */

$this->breadcrumbs=array(
	'Gifts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Gift', 'url'=>array('index')),
	array('label'=>'Create Gift', 'url'=>array('create')),
	array('label'=>'Update Gift', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Gift', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Gift', 'url'=>array('admin')),
);
?>

<h1>View Gift #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'public_id',
		'name',
		'type_id',
		'number',
		'integral',
		'content',
		'image_src',
		'remark',
		'count_stock',
		'order_by',
		'status',
		'time_created',
		'time_updated',
	),
)); ?>
