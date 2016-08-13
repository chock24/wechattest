<?php
/* @var $this KeywordController */
/* @var $model Keyword */

$this->breadcrumbs=array(
	'Keywords'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Keyword', 'url'=>array('index')),
	array('label'=>'Manage Keyword', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>