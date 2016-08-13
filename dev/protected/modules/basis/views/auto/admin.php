<?php
/* @var $this AutoController */
/* @var $model Auto */

$this->breadcrumbs=array(
	'Autos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Auto', 'url'=>array('index')),
	array('label'=>'Create Auto', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#auto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Autos</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'auto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'admin_id',
		'public_id',
		'type',
		'content',
		'source_file_id',
		/*
		'timing',
		'time_start',
		'time_end',
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
