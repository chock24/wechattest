<?php
/* @var $this AdminPublicController */
/* @var $model AdminPublic */

$this->breadcrumbs=array(
	'Admin Publics'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AdminPublic', 'url'=>array('index')),
	array('label'=>'Manage AdminPublic', 'url'=>array('admin')),
);
?>

<h1>Create AdminPublic</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>