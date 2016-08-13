<?php
/* @var $this TransmitUserController */
/* @var $model TransmitUser */

$this->breadcrumbs=array(
	'Transmit Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransmitUser', 'url'=>array('index')),
	array('label'=>'Create TransmitUser', 'url'=>array('create')),
	array('label'=>'View TransmitUser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransmitUser', 'url'=>array('admin')),
);
?>

<h1>Update TransmitUser <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>