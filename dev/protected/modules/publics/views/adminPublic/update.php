<?php
/* @var $this AdminPublicController */
/* @var $model AdminPublic */

$this->breadcrumbs=array(
	'Admin Publics'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdminPublic', 'url'=>array('index')),
	array('label'=>'Create AdminPublic', 'url'=>array('create')),
	array('label'=>'View AdminPublic', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AdminPublic', 'url'=>array('admin')),
);
?>

<h1>Update AdminPublic <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>