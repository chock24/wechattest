<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs=array(
	'公众号中心'=>array('/publics'),
	'多客服管理'=>array('admin'),
        '查看客服信息',
);

?>

<h1>查看客服信息 #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'account',
		'nickname',
		'password',
		'kf_id',
                array(
                    'name' => 'kf_headimg',
                    'type' => 'html',
                    'value' => CHtml::image(PublicStaticMethod::returnFile("service",$model->kf_headimg,"","headimage"),"",array("style"=>"width:50px; height:50px;")),
                ),
		'auto_accept',
		'accepted_case',
		'time_created:datetime',
	),
)); ?>
