<?php
/* @var $this UserModuleController */
/* @var $model UserModule */

$this->breadcrumbs=array(
	'User Modules'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserModule', 'url'=>array('index')),
	array('label'=>'Create UserModule', 'url'=>array('create')),
	array('label'=>'View UserModule', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserModule', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>