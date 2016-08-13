<?php
/* @var $this UsergroupController */
/* @var $model UserGroup */

$this->breadcrumbs = array(
    '管理' => array('/mamagers'),
    '用户分组管理',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-group-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>用户分组管理</h1>

<!--导入提示-->
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php elseif (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<!--导入提示-->

<?php echo CHtml::link('高级搜索', '#', array('class' => 'search-button web-menu-btn left')); ?>
<?php echo CHtml::link('用户分组导入', array('import'), array('class' => 'web-menu-btn left red')); ?>
<?php echo CHtml::link('创建用户分组', array('create'), array('class' => 'web-menu-btn left green')); ?>
<div class="clear"></div>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-group-grid',
    'dataProvider' => $model->search(),
    'template' => '<div class="shadow"></div> {items} {summary} {pager}',
    'summaryCssClass' => 'left',
    'loadingCssClass' => 'modimy-grid-view-loading',
    'summaryText' => '筛选结果<b>(共{count}条)</b> | 第{start}行-{end}行 共{pages}页 | 当前为第{page}页',
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'value' => '$data->id',
        ),
        array(
            'name' => 'id',
            'value' => '$row+1',
        ),
        'name',
        'count',
        'status',
        'sort',
        /*
          'isdelete',
          'time_created',
          'time_updated',
         */
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
