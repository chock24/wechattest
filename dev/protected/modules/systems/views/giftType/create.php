<?php
/* @var $this GiftTypeController */
/* @var $model GiftType */

$this->breadcrumbs=array(
	'Gift Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GiftType', 'url'=>array('index')),
	array('label'=>'Manage GiftType', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>