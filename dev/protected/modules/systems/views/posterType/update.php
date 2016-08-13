<?php
/* @var $this PosterTypeController */
/* @var $model PosterType */

$this->breadcrumbs=array(
	'Poster Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PosterType', 'url'=>array('index')),
	array('label'=>'Create PosterType', 'url'=>array('create')),
	array('label'=>'View PosterType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PosterType', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>