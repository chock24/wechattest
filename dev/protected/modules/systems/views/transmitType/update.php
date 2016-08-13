<?php
/* @var $this TransmitTypeController */
/* @var $model TransmitType */

$this->breadcrumbs=array(
	'Transmit Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransmitType', 'url'=>array('index')),
	array('label'=>'Create TransmitType', 'url'=>array('create')),
	array('label'=>'View TransmitType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransmitType', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'parent_id'=>$parent_id)); ?>