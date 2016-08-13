<?php
/* @var $this SourceFileGatherController */
/* @var $model SourceFileGather */

$this->breadcrumbs=array(
	'Source File Gathers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SourceFileGather', 'url'=>array('index')),
	array('label'=>'Create SourceFileGather', 'url'=>array('create')),
	array('label'=>'View SourceFileGather', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SourceFileGather', 'url'=>array('admin')),
);
?>



<?php $this->renderPartial('_form', array('model'=>$model)); ?>