<?php
/* @var $this WcpublicController */
/* @var $model WcPublic */

$this->breadcrumbs=array(
	'公众号中心'=>array('/publics'),
	'公众号设置',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#wc-public-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>公众号设置</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button web-menu-btn left')); ?>
<?php echo CHtml::link('添加公众号',array('create'),array('class'=>'web-menu-btn left green')); ?>
<div class="clear"></div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'wc-public-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
        'template'=>'{items} {summary} {pager}',
	'summaryText' => '筛选结果<b>(共{count}个)</b> | 第{start}行-{end}行 共{pages}页 | 当前为第{page}页',
        'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 2,
                    'value' => '$data->id',
                ),
		/*array(
                    'name' => 'headimage',
                    'type' => 'html',
                    'value' => 'CHtml::image(PublicStaticMethod::returnFile("public",$data->headimage,"","headimage"),"",array("style"=>"width:50px; height:50px;"))',
                ),*/
                array(
                    'name'=>'type',
                    'value'=>'Yii::app()->params->PUBLICTYPE[$data->type]',
                ),
		'title',
		'original',
		'wechat',
		/*
		'appid',
		'appsecret',
		'status',
		'sort',
		'isdelete',
		'time_created',
		'time_updated',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
