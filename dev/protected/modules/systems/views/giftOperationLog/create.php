<?php
/* @var $this GiftOperationLogController */
/* @var $model GiftOperationLog */

$this->breadcrumbs=array(
	'Gift Operation Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GiftOperationLog', 'url'=>array('index')),
	array('label'=>'Manage GiftOperationLog', 'url'=>array('admin')),
);
?>

<h1>Create GiftOperationLog</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>