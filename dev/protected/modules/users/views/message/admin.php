<?php
/* @var $this MessageController */
/* @var $model Message */

$this->breadcrumbs = array(
    '管理' => array('/managers'),
    '消息管理',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#message-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>消息管理</h1>

<?php echo CHtml::link('高级搜索', '#', array('class' => 'search-button web-menu-btn left')); ?>
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
    'id' => 'message-grid',
    'dataProvider' => $model->search(),
    'template' => '{items} {summary} {pager}',
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'value' => '$data->id',
        ),
        /* array(
          'name' => '头像',
          'type' => 'html',
          //'value' => '($data->users->subscribe?"<span class=\"subscribe\">".CHtml::image(Yii::app()->baseUrl."/images/subscribe.png","关注中",array("class"=>"sub_image")).CHtml::image(substr($data->users->headimgurl,0,-1)."64")."</span>":"<span class=\"unsubscribe\">".CHtml::image(Yii::app()->baseUrl."/images/unsubscribe.png","已取消关注",array("class"=>"sub_image")).CHtml::image(substr($data->users->headimgurl,0,-1)."64")."</span>")',
          'value' => '$data->user_id',
          ), */
        array(
            'name' => 'user_id',
            'type' => 'html',
            'value' => array($this, 'user'),
            'htmlOptions' => array(
                'class' => 'headimage-section',
            ),
        ),
        'lasttime:datetime',
        array(
            'class' => 'CButtonColumn',
            'htmlOptions' => array(
                'style' => 'width:120px;',
            ),
            'template' => '{message}',
            'buttons' => array(
                'message' => array(
                    'label' => '查看对话记录', // text label of the button
                    'url' => 'Yii::app()->createUrl("/users/user/view",array("id"=>$data->user_id))', // a PHP expression for generating the URL of the button
                    'imageUrl' => Yii::app()->baseUrl . '/images/comment.png',
                ),
            ),
        ),
    ),
));
?>

<?php
/* -------------------移到用户名字显示头像--------------------- */
Yii::app()->clientScript->registerScript('headimage', "
$('.show-headimage').click(function(){
        var id = $(this).attr('data-id');
        var object = $(this);
	$.get('" . Yii::app()->createUrl('/users/user/headimage') . "',{id:id},function(data){
                object.parent().prepend(data);
                object.removeClass('show-headimage');
                object.unbind();
                return false;
        });	
});

");
?>