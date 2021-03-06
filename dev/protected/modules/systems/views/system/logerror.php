<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#system-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="background-white content">
    <div class="padding30">
        <h2 class="content-main-title">错误日志</h2>
        <div>
            <div class="tabhost">
                <div class="tabhost-title">
                    <ul>
                        <li>
                            <?php echo CHtml::link('系统设置', array('/systems/system/index')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('管理员列表', array('/systems/admin/index')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('创建管理员', array('/systems/admin/create')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('登录日志', array('/systems/system/logaccess')); ?>
                        </li>
                        <li class="active">
                            <?php echo CHtml::link('错误日志', array('/systems/system/logerror')); ?>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="tabhost-center">
                    <div class="search-form">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div><!-- search-form -->
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'system-grid',
                        'dataProvider' => $model->search(),
                        'template' => '{items} {summary} {pager}',
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
                            array(
                                'name' => 'admin_id',
                                'value' => array($this, 'admin'),
                            ),
                            'error_code',
                            array(
                                'name'=>'content',
                                'type'=>'raw',
                                'value'=> '"<span title=\'$data->content\'>".PublicStaticMethod::truncate_utf8_string($data->content, 20)."</span>"',
                            ),
                            array(
                                'name'=>'error_url',
                                'type'=>'raw',
                                'value'=> '"<span title=\'$data->error_url\'>".PublicStaticMethod::truncate_utf8_string($data->error_url, 20)."</span>"',
                            ),
                            array(
                                'name'=>'from_url',
                                'type'=>'raw',
                                'value'=> '"<span title=\'$data->from_url\'>".PublicStaticMethod::truncate_utf8_string($data->from_url, 20)."</span>"',
                            ),
                            //'content',
                            //'error_url',
                            //'from_url',
                            //'ip',
                            'time_created:datetime',
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>

    </div>
