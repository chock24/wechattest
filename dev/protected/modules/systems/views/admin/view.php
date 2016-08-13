<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs=array(
	'系统管理'=>array('/systems'),
	'系统管理员'=>array('/systems/admin/admin'),
        '查看管理员信息'
);

?>

<h1>查看管理员信息 #<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'name',
                array(
                    'name'=>'role_id',
                    'value'=>  Yii::app()->params->ADMINROLE[$model->role_id],
                ),
		'time_created:datetime',
		'time_updated:datetime',
	),
)); ?>
