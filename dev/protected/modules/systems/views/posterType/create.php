<?php
/* @var $this PosterTypeController */
/* @var $model PosterType */

$this->breadcrumbs=array(
	'Poster Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PosterType', 'url'=>array('index')),
	array('label'=>'Manage PosterType', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>