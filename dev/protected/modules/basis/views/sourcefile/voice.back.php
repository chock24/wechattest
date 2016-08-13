<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '微信素材' => array('/basis/appmsg'),
    '音频素材'
);
?>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/common.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/voice.css");
?>
<!--<link href="<?php /* echo Yii::app()->baseUrl."/css/" */ ?>voice.css" rel="stylesheet" type="text/css" />-->
<h1>音频管理</h1>


<div class="span-100">
    <?php $this->renderPartial('header'); ?>

    <div class="message whole_message">

        <input type="button" value="上传音频" class="shangchuan" href="<?php echo Yii::app()->createURL('/basis/sourcefile/create/', array('type' => '3')); ?>"  /> 大小不超过5M，超度不超过60秒，格式mp3,wma,wav,amr

        <div class="voice_bd content" id="voice">
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_view',
            ));
            ?>

        </div>
        <div class="sidebar">
            <dl>
                <dd>
                    <?php echo CHtml::link('显示全部', array('/basis/sourcefile/voice')); ?>
                </dd>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $sourceFileGather,
                    'itemView' => '/public/_gather',
                    'id' => 'gatherListView',
                    'template' => '{items}',
                ));
                ?>
                <dd>
                    <?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create/', 'type' => 3), array('class' => 'create-gather-item')); ?>

                </dd>
            </dl>
          
       </div>
    </div>


    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'mydialog',
        'options' => array(
            'autoOpen' => false,
            'modal' => true,
            'width' => 'auto',
            'height' => 'auto',
            'buttons' => array(
                array('text' => '确定', 'click' => 'js:function(){operationSubmit()}'),
                array('text' => '取消', 'click' => 'js:function(){$(this).dialog("close");}'),
            ),
        ),
    ));
    ?>
    <div class="content"></div>
    <?php $this->endWidget(); ?>

    <?php
    Yii::app()->clientScript->registerScript('operation2', "	
         $('.update-item').live('click',function(){
                var operationUrl = $(this).attr('href');
			$.get(operationUrl,'',function(s){
		
			$('#mydialog').dialog({title:'修改音频信息'});
			$('#mydialog .content').html(s);
			$('#mydialog').dialog('open'); return false;
		});	
                return false;
	});
	       $('.shangchuan').live('click',function(){
                var operationUrl = $(this).attr('href');
			$.get(operationUrl,'',function(s){
			$('#mydialog').dialog({title:'上传音频文件'});
			$('#mydialog .content').html(s);
			$('#mydialog').dialog('open'); return true;
		});	
                return false;
	});
        
	 
");
    ?>
