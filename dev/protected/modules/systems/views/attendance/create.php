<?php
/* @var $this AttendanceController */
/* @var $model Attendance */

$this->breadcrumbs=array(
	'Attendances'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Attendance', 'url'=>array('index')),
	array('label'=>'Manage Attendance', 'url'=>array('admin')),
);
?>

<h1>Create Attendance</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>