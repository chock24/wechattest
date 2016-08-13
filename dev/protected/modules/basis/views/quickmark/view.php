<?php
/* @var $this QuickmarkController */
/* @var $model Quickmark */

$this->breadcrumbs=array(
	'管理'=>array('/basis'),
	'二维码管理'=>array('admin'),
        '查看二维码',
);

?>

<h1>查看二维码 #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'action_name',
		//'expire_seconds',
		//'action_info',
		'scene_id',
		//'ticket',
		'url',
		'status',
		'sort',
		'time_created:datetime',
	),
)); ?>
