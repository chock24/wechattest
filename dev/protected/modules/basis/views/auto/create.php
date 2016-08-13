<?php
/* @var $this AutoController */
/* @var $model Auto */

$this->breadcrumbs=array(
	'Autos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Auto', 'url'=>array('index')),
	array('label'=>'Manage Auto', 'url'=>array('admin')),
);
?>

<h1>Create Auto</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>