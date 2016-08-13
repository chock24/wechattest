<?php
/* @var $this AttendanceController */
/* @var $model Attendance */

$this->breadcrumbs=array(
	'Attendances'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Attendance', 'url'=>array('index')),
	array('label'=>'Create Attendance', 'url'=>array('create')),
	array('label'=>'View Attendance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Attendance', 'url'=>array('admin')),
);
?>

<h1>Update Attendance <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>