<?php
/* @var $this TransmitController */
/* @var $model Transmit */
$this->breadcrumbs=array(
	'Poster'=>array('index'),
//	$model->title=>array('view','id'=>$model->id),
//	'Update',
);

$this->menu=array(
	array('label'=>'List Poster', 'url'=>array('index')),
	array('label'=>'Create Poster', 'url'=>array('create')),
	array('label'=>'View Poster', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Poster', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model'=>$model,'postertype'=>$postertype,'dataprovider'=>$dataprovider,'postername'=>$postername)); ?>