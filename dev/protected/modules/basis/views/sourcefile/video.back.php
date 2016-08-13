<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '微信素材' => array('/basis/appmsg'),
    '视频素材'
);
?>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/common.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/video.css");
?>



<h1>视频管理</h1>


<div class="span-100">
    <?php $this->renderPartial('header'); ?>

    <div class="message img_message">




        <input type="button" value="上传视频" class="shangchuan" href="<?php echo Yii::app()->createURL('/basis/sourcefile/create/', array('type' => '4')); ?>"  />
        大小: 不超过20M,    格式: rm, rmvb, wmv, avi, mpg, mpeg, mp4

        <div class="video_bd" id="voice">
            <div class="content" id="voice">
                <?php
                $number = Yii::app()->request->getParam('number');
                if (!empty($number)) {

                    echo $number;
                } else {
                    ?>
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_video',
                        'id' => 'videoListview',
                    ));
                    ?>
<?php } ?>
            </div>
        </div>
        <div class="sidebar">
            <dl>
                <dd>
                <?php echo CHtml::link('显示全部', array('/basis/sourcefile/video')); ?>
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
<?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create/', 'type' => 4), array('class' => 'create-gather-item')); ?>
                </dd>
            </dl>
        </div>
    </div>
</div>
<script type="text/javascript">
    if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE7.0" || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE8.0") {
        $(".video_info a").find('video').replaceWith("<img src='<?php echo Yii::app()->baseUrl . "/images/" ?>video_slt.jpg' />");
        $(".video_info a").find('.time').css({background: '#fff', color: '#000', textDecoration: 'none'});
    }
</script>

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
		
			$('#mydialog').dialog({title:'修改视频信息'});
			$('#mydialog .content').html(s);
			$('#mydialog').dialog('open'); return false;
		});	
                return false;
	});
	       $('.shangchuan').live('click',function(){
                var operationUrl = $(this).attr('href');
			$.get(operationUrl,'',function(s){
			$('#mydialog').dialog({title:'上传视频文件'});
			$('#mydialog .content').html(s);
			$('#mydialog').dialog('open'); return true;
		});	
                return false;
	});
	 $('.todelete').live('click',function(){
            var operationUrl = $(this).attr('href');
            var data =  $('.operation-form').serialize();
			$.post(operationUrl,'',function(s){
			$.fn.yiiListView.update('videoListview');
			return true;
			
		});	
                return false;
	});

");
?>
