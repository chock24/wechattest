<?php
/* @var $this GiftTypeController */
/* @var $model GiftType */

$this->breadcrumbs=array(
	'Gift Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GiftType', 'url'=>array('index')),
	array('label'=>'Create GiftType', 'url'=>array('create')),
	array('label'=>'View GiftType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GiftType', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>