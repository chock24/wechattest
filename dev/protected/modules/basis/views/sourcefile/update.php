<?php
/* @var $this SourcefileController */
/* @var $model SourceFile */

$this->breadcrumbs=array(
	'Source Files'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SourceFile', 'url'=>array('index')),
	array('label'=>'Create SourceFile', 'url'=>array('create')),
	array('label'=>'View SourceFile', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SourceFile', 'url'=>array('admin')),
);
?>



<?php $this->renderPartial('_form', array('model'=>$model,'sourceFileGather'=>$sourceFileGather)); ?>