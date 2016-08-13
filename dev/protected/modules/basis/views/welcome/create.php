<?php
/* @var $this WelcomeController */
/* @var $model Welcome */

$this->breadcrumbs=array(
	'Welcomes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Welcome', 'url'=>array('index')),
	array('label'=>'Manage Welcome', 'url'=>array('admin')),
);
?>

<h1>Create Welcome</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>