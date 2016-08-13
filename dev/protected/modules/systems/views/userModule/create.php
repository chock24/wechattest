<?php
/* @var $this UserModuleController */
/* @var $model UserModule */

$this->breadcrumbs=array(
	'User Modules'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserModule', 'url'=>array('index')),
	array('label'=>'Manage UserModule', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>