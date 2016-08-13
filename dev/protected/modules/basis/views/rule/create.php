<?php
/* @var $this RuleController */
/* @var $model Rule */

$this->breadcrumbs=array(
	'Rules'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Rule', 'url'=>array('index')),
	array('label'=>'Manage Rule', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>