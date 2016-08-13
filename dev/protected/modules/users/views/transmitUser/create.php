<?php
/* @var $this TransmitUserController */
/* @var $model TransmitUser */

$this->breadcrumbs=array(
	'Transmit Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransmitUser', 'url'=>array('index')),
	array('label'=>'Manage TransmitUser', 'url'=>array('admin')),
);
?>

<h1>Create TransmitUser</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>