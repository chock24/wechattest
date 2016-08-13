<?php
/* @var $this SourceFileGatherController */
/* @var $model SourceFileGather */

$this->breadcrumbs=array(
	'Source File Gathers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SourceFileGather', 'url'=>array('index')),
	array('label'=>'Manage SourceFileGather', 'url'=>array('admin')),
);
?>



<?php $this->renderPartial('_form', array('model'=>$model)); ?>