<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs=array(
	'系统管理'=>array('/systems'),
	'系统管理员',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#admin-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>系统管理员</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button web-menu-btn left')); ?>
<?php echo CHtml::link('创建管理员',array('create'),array('class'=>'web-menu-btn left green')); ?>
<div class="clear"></div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-grid',
	'dataProvider'=>$model->search(),
	'template'=>'{items} {summary} {pager}',
	'summaryText' => '筛选结果<b>(共{count}人)</b> | 第{start}行-{end}行 共{pages}页 | 当前为第{page}页',
        'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 2,
                    'value' => '$data->id',
                ),
                array(
                    'name'=>'id',
                    'value'=>'$row+1',
                ),
		'username',
		'name',
                array(
                    'name'=>'role_id',
                    'value'=>'Yii::app()->params->ADMINROLE[$data->role_id]',
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>