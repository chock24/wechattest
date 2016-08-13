<?php
/* @var $this TransmitController */
/* @var $model Transmit */

$this->breadcrumbs=array(
	'Transmits'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Transmit', 'url'=>array('index')),
	array('label'=>'Create Transmit', 'url'=>array('create')),
	array('label'=>'View Transmit', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Transmit', 'url'=>array('admin')),
);
?>



<?php $this->renderPartial('_form', array('model'=>$model,'trantype'=>$trantype)); ?>