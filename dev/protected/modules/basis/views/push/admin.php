<?php
/* @var $this PushController */
/* @var $model Push */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '群发功能',
    '发送列表',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#push-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="right content-main">
    <h2 class="content-main-title">发送列表</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="padding10 tabhost-center">

        <?php echo CHtml::link('高级搜索', '#', array('class' => 'button search-button web-menu-btn left')); ?>
        <?php echo CHtml::link('群发信息', array('create','genre'=>1), array('class' => 'button web-menu-btn left')); ?>
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
            'id' => 'push-grid',
            'dataProvider' => $model->search(),
            'template' => '<div class="shadow"></div> {items} {summary} {pager}',
            'summaryCssClass' => 'right',
            'itemsCssClass' => 'wechat-table',
            'loadingCssClass' => 'modimy-grid-view-loading',
            'summaryText' => '筛选结果<b>(共{count}条)</b> | 第{start}行-{end}行 共{pages}页 | 当前为第{page}页',
            'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 2,
                    'value' => '$data->id',
                ),
                'id',
                array(
                    'name'=>'genre',
                    'value'=>'Yii::app()->params->PUSHGENRE[$data->genre]',
                ),
                'count',
                array(
                    'name'=>'type',
                    'value'=>'Yii::app()->params->TYPE[$data->type]',
                ),
                array(
                    'name'=>'multi',
                    'value'=>'Yii::app()->params->WHETHER[$data->multi]',
                ),
                'time_created:datetime',
                array(
                    'name'=>'status',
                    'value'=>'Yii::app()->params->PUSHSTATUS[$data->status]',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{view} {delete}',
                ),
            ),
        ));
        ?>



    </div>
</div>





