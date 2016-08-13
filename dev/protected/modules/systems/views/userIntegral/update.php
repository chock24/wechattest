<?php
/* @var $this GiftController */
/* @var $model Gift */

$this->breadcrumbs=array(
	'Gifts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Gift', 'url'=>array('index')),
	array('label'=>'Create Gift', 'url'=>array('create')),
	array('label'=>'View Gift', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Gift', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'gifttype'=>$gifttype)); ?>