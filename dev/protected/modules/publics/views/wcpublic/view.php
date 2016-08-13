<?php
/* @var $this WcpublicController */
/* @var $model WcPublic */

$this->breadcrumbs=array(
	'公众号中心'=>array('/publics'),
	'公众号设置'=>array('admin'),
        '查看公众号信息'
);

?>

<h1>查看公众号信息 #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'title',
		'original',
                /*array(
                    'name' => 'headimage',
                    'type' => 'html',
                    'value' => CHtml::image(PublicStaticMethod::returnFile("public",$model->headimage,"","headimage"),"",array("style"=>"width:50px; height:50px;")),
                ),*/
		'wechat',
		'appid',
		'appsecret',
                'watermark',
		'time_created:datetime',
		//'time_updated',
	),
)); ?>
