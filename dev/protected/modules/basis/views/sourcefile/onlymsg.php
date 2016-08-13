<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '素材管理' => array('/basis/sourcefile/appmsg'),
    '编辑图文',
);
?>
<div class="right content-main">
    <h2 class="content-main-title">图文消息</h2>

    <?php
    //if(confirm("你确定要保存吗？")){
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'onlymsg-form',
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    //}
    ?>


    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <ul>
                    <li class="active">
                        <?php echo CHtml::link('单图文库', array('news')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 5 && Yii::app()->request->getParam('multi') == 1 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('多图文库', array('morenews')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 2 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('图片库', array('image')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 3 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('音频库', array('voice')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 4 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('视频库', array('video')); ?>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="padding30 tabhost-center">

                <div class="left fodder add-mage-text">
                    <div class="fodder-center add-mage-text-border-bottom">
                        <h4 class="fodder-img add-mage-text-img"><a href="javascript:;">标题</a></h4>
                        <div class="fodder-img add-mage-text-img">
                            <img src="<?php echo Yii::app()->baseurl . '/upload/sourcefile/image/source/' . $model->filename . '.' . $model->ext ?>"  class="none add-image-preview-img" />
                            <i class="add-mage-text-img-background">封面图片</i>
                        </div>
                        <p class="fodder-introduce add-mage-text-title"></p>
                    </div>
                </div>

                <div class="left add-mage-text-input">
                    <div class="triangle"></div>
                    <div class="add-mage-text-compile">
                        <label>标题</label>
                        <div class="add-mage-text-compile-content title">
                            <?php echo $form->textField($model, 'title', array('size' => '82', 'placeholder' => '标题')); ?>
                            <span class="ie7margin-top20 right color-9"><em>0</em>/60</span>
                        </div>
                    </div> 
                    <div class="add-mage-text-compile">
                        <label>作者<span>(选填)</span></label>
                        <div class="add-mage-text-compile-content author">
                            <?php echo $form->textField($model, 'author', array('size' => '82', 'placeholder' => '作者')); ?>
                            <span class="right color-9"><em>0</em>/8</span>
                        </div>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>公众号名称</label>
                        <div class="add-mage-text-compile-content">
                            <?php echo $form->textField($model, 'public_name', array('size' => '88')); ?>
                        </div>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>点击公众号名称跳转页面 例如: http://www.qq.com</label>
                        <div class="add-mage-text-compile-content">
                            <?php echo $form->textField($model, 'public_url', array('size' => '88')); ?>
                        </div>
                    </div>

                    <div class="add-mage-text-compile">
                        <label>封面<span>（大图片建议尺寸：900像素 * 500像素）</span></label>
                        <?php echo CHtml::activeFileField($model, 'files', array('class' => "none add-image-preview", 'style' => 'display:none')); ?>
                        <a onclick="$(this).prev().click();" class="margin-top-8 button button-white" href="javascript:;">上传</a>
                        <?php
                        if (Yii::app()->user->hasFlash('alert')) {
                            echo '<br/>' . Yii::app()->user->getFlash('alert');
                        }
                        ?>
                        <?php echo $form->error($model, 'files'); ?>
                        <a onclick="js:return popup($(this), '从图库中选择图文', 880, 590);" class="margin-top-8 button button-white" href="<?php echo Yii::app()->createUrl('basis/sourcefile/sourcefile', array('type' => 2)); ?>">从图片库选择</a>

                        <label class="margin-top-15">
                            <?php echo $form->checkbox($model, 'show_content', array('class' => 'frm_checkbox')); ?>
                            <span>是否显示封面</span>
                        </label>
                    </div>
                    <div class="add-mage-text-compile">
                        <label>简介</label>
                        <div class="add-mage-text-compile-content textarea">
                            <?php echo $form->textarea($model, 'description'); ?>
                            <span class="right color-9"><em>6</em>/120</span>
                        </div>
                    </div>
                    <div class="add-mage-text-compile">
                        <label>内容</label>
                        <div class="textarea">
                            <?php echo $form->textarea($model, 'content'); ?>
                            <?php
                            $this->widget('ext.ueditor.Ueditor', array(
                                'getId' => 'SourceFile_content',
                                'UEDITOR_HOME_URL' => "/",
                                'options' => '
                        toolbars:[["fontfamily","fontsize","forecolor","bold","italic","underline","strikethrough","backcolor","removeformat","|","indent","|","justifyleft","justifycenter","justifyright","justifyjustify","|",
    "rowspacingtop","rowspacingbottom","lineheight","|","insertunorderedlist","insertorderedlist","blockquote","horizontal","|","insertvideo","insertimage","|",
    "link","unlink","highlightcode","|","undo","redo","source"]],
                    wordCount:true,
                    elementPathEnabled:false,
                    initialContent:"",
                    imageUrl:"' . Yii::app()->createUrl('/basis/sourcefile/imageupload') . '",
                    imagePath:"",
                    imageManagerUrl:"' . Yii::app()->createUrl('/basis/sourcefile/onlineimage') . '",
                    imageManagerPath:"",
                    ',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="add-mage-text-compile">
                        <label>点击查看全文的链接</label>
                        <div class="add-mage-text-compile-content textarea">
                            <?php echo $form->textField($model, 'content_source_url', array('size' => '88')); ?>
                            <?php echo $form->hiddenField($model, 'filename', array('id' => 'result-id')); ?>
                        </div>
                    </div>
                    <?php
                    $public_id = Yii::app()->user->getState('public_id');
                    if ($public_id == 1) {
                        ?>
                        <div class="add-mage-text-compile">
                            <label>是否作为模板 &nbsp;
                                <?php echo $form->checkBox($model, 'template', array('class' => 'margin-top-8')); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <div class="clear"></div>
                <div class="add-mage-text-submit">
                    <?php echo $form->hiddenField($model, 'public_id'); ?>
                    <?php echo CHtml::submitButton('确定', array('class' => "button button-green")); ?>
                    <?php if (!$model->isNewRecord): ?>
                        <?php echo CHtml::link('预览', array('/site/view', 'id' => $model->id), array('class' => 'button button-white', 'target' => '_blank')); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function () {
        ie7_text_count($('.title'), 60);
        ie7_text_count($('.author'), 8);
        ie7_text_count($('.textarea'), 120);
        wechat_icovw($('#SourceFile_title'), $('.fodder-img.add-mage-text-img a'), '标题');
        wechat_icovw($('#SourceFile_description'), $('.fodder-introduce.add-mage-text-title'), '');
        web_release($('.add-mage-text-submit').find('input:submit'));//关闭页面提醒
        //获取file的地址赋值给img
        $(".add-image-preview").on("change", function () {
            var objUrl = getObjectURL(this.files[0]);
            console.log("objUrl = " + objUrl);
            if (objUrl) {
                $(".add-image-preview-img").attr("src", objUrl).show();
                $(".add-image-preview-img").next().hide();
            }
        });
        //建立一個可存取到該file的url
        function getObjectURL(file) {
            var url = null;
            if (window.createObjectURL != undefined) { // basic
                url = window.createObjectURL(file);
            } else if (window.URL != undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file);
            } else if (window.webkitURL != undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file);
            }
            return url;
        }
        if ($('.add-mage-text-img').find('img').attr('src') != '/upload/sourcefile/image/source/.') {
            $('.add-mage-text-img').find('img').show();
        }
        $('.add-mage-text-mask-add-icon').live('click', function () {
            var obj = $(this).parent().prev().find('.popup-content-fodder-content').find('.items').find('.selected');
            if (obj.html() != undefined) {
                var url = obj.find('img').attr('src');
                $('.add-mage-text-img').find('img').attr('src', url).show();
            } else {
                alert('对不起！你没有选择素材，请选择素材！！');
            }
        });
        $('.add-mage-text').Header();
    })
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'diaimggroup2',
    'htmlOptions' => array(
    // 'class' => 'mydialog',
    ),
    'options' => array(
        'autoOpen' => false,
        // 'modal'=>true,
        'width' => '970',
        'height' => 'auto',
        'buttons' => array(
            array('text' => '确定', 'click' => 'js:function(){$(this).dialog("close");}'),
            array('text' => '取消', 'click' => 'js:function(){$(this).dialog("close"); cancel();$(\'.img_img_i\').show();$(\'.img_f\').hide();}'),
        ),
    ),
));
?>	

<div class="content2"></div>
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('operation', "	
  
	       $('.showimggroup').live('click',function(){
            var operationUrl = $(this).attr('href');
			$.get(operationUrl,'',function(s){
			$('#diaimggroup2').dialog({title:'选择图片'});
			$('#diaimggroup2 .content2').html(s);
			$('#diaimggroup2').dialog('open'); return true;
			
		});	
                return false;
	});
	
	      $('.showimgs').live('click',function(){
            var operationUrl = $(this).attr('href');
			$.get(operationUrl,'',function(s){
			$('#diaimggroup2 .content2').html(s);
			
		});	
                return false;
	});
		      $('.page').live('click',function(){
                var operationUrl = $(this).find('a').attr('href');
             	$.get(operationUrl,'',function(s){
			$('#diaimggroup2 .content2').html(s);
			
		});	
                return false;
	});
        $('a').each(function(){
            var ul = $(this).attr('href');
            $(this).attr({
                data_ue_src: ul,
                _href: ul
            })
        });

");
?>

