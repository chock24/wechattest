<?php
/* @var $this GiftOperationLogController */
/* @var $model GiftOperationLog */

$this->breadcrumbs=array(
	'Gift Operation Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GiftOperationLog', 'url'=>array('index')),
	array('label'=>'Create GiftOperationLog', 'url'=>array('create')),
	array('label'=>'View GiftOperationLog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GiftOperationLog', 'url'=>array('admin')),
);
?>

<h1>Update GiftOperationLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>