<?php
/* @var $this QuickmarkController */
/* @var $model Quickmark */

$this->breadcrumbs=array(
	'管理'=>array('/managers'),
	'二维码管理',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#quickmark-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>二维码管理</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button left web-menu-btn')); ?>
<?php echo CHtml::link('创建二维码',array('create'),array('class'=>'left web-menu-btn')); ?>
<?php //echo CHtml::link('生成短链接',array('create'),array('class'=>'left web-menu-btn')); ?>
<div class="clear"></div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'quickmark-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 2,
                    'value' => '$data->id',
                ),
                array(
                    'name' => 'id',
                    'value' => '$row+1',
                ),
                array(
                    'name' => 'path',
                    'type' => 'html',
                    'value' => 'CHtml::link(CHtml::image(Yii::app()->baseUrl."/".$data->path,$data->title,array("width"=>50,"title"=>"点击下载二维码")),array("download","id"=>$data->id),array("target"=>"_blank"))',
                ),
                array(
                    'name' => 'group_id',
                    'value' => array($this,'userGroupItem'),
                ),
                'title',
                array(
                    'name'=>'action_name',
                    'value'=>'Yii::app()->params->QUICKMARKTYPE[$data->action_name]',
                ),
		//'expire_seconds',
		//'action_info',
		'scene_id',
		//'ticket',
		/*
		'url',
		'status',
		'sort',
		'isdelete',
                 * 
                 */
		'time_created:datetime',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>
