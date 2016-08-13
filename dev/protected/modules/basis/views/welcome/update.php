<?php
/* @var $this WelcomeController */
/* @var $model Welcome */

$this->breadcrumbs=array(
	'Welcomes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Welcome', 'url'=>array('index')),
	array('label'=>'Create Welcome', 'url'=>array('create')),
	array('label'=>'View Welcome', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Welcome', 'url'=>array('admin')),
);
?>

<h1>Update Welcome <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>