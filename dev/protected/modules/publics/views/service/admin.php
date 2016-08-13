<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs=array(
	'公众号中心'=>array('/publics'),
	'多客服管理',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#service-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>多客服管理</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button web-menu-btn left')); ?>
<?php echo CHtml::link('添加客服', array('service/create'),array('class'=>'web-menu-btn left')); ?>
<div class="clear"></div>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
	'model'=>$model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'service-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'account',
		'nickname',
		'kf_id',
		'kf_headimg',
		'auto_accept',
		'accepted_case',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>
