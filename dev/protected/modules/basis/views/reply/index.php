<?php
/* @var $this WelcomeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '欢迎语',
);
?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />
<?php
if (Yii::app()->request->getParam('type') == 1):
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/reset.css");
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.qqFace.js");
    Yii::app()->clientScript->registerScript('qqfaceInput', "	
        $('.emotion').qqFace({
            id: 'facebox',
            assign: 'Reply_content',
            path: '" . Yii::app()->baseUrl . "/images/arclist/',
        });
    ");
else:
    Yii::app()->clientScript->registerScript('selectItem', "	
        $('.select-item').click(function(){
            $('.select-item').removeClass('current');
            if($(this).hasClass('current')){
                $(this).removeClass('current');
                $('input[class=\'source_file_id\']').val();
            }else{
                $(this).addClass('current');
                var data_id = $(this).attr('data-id');
                $('input[class=\'source_file_id\']').val(data_id);
            }
            
        })
    ");
endif;
?>


<?php if (Yii::app()->user->hasFlash('success')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>

<?php elseif (Yii::app()->user->hasFlash('error')): ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<div class="span-100">

    <div class="message">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'reply-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <?php echo $form->hiddenField($model, 'type'); ?>
            <?php if (Yii::app()->request->getParam('type') == 1): ?>
                <div class="padding10">
                    <div class="preview">
                        预览：
                        <p>
                            <?php echo nl2br(PublicStaticMethod::replaceNickname(PublicStaticMethod::replaceQqFace($model->content), '用户昵称')); ?>
                        </p>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'content'); ?>
                        <div class="editing">
                            <div class="editing-tab">
                                <ul class="editing-tab-nav">
                                    <li>
                                        <?php echo CHtml::link('<i class="icon icon-text"></i>', array('index','id' => $model->id, 'rule_id' => Yii::app()->request->getParam('rule_id'),  'type' => 1), array('title' => '文本', 'onclick' => 'js:$("#news-section").hide();$("#text-section").show();$("#text-section").find("textarea").val("");return false;')); ?>
                                    </li>
                                    <li>
                                    <?php echo CHtml::link('<i class="icon icon-img"></i>', array('sourcefile', 'type' => 2), array('title' => '图片','onclick' => 'js:return popup($(this),"图片文库",850,500);')); ?>
                                    </li>
                                   <!-- <li>
                                    <?php echo CHtml::link('<i class="icon icon-voice"></i>', array('index', 'type' => 3), array('title' => '音频','onclick' => 'js:return popup($(this),"音频文库",850,500);')); ?>
                                    </li>
                                    <li>
                                    <?php echo CHtml::link('<i class="icon icon-video"></i>', array('index', 'type' => 4), array('title' => '视频','onclick' => 'js:return popup($(this),"视频文库",850,500);')); ?>
                                    </li>-->
                                    <li><?php
                                        $id = Yii::app()->request->getParam('id');
                                        if ($id > 0) {
                                            
                                        } else {
                                            ?>
                                        </li>
                                        <li>
                                            <?php echo CHtml::link('<i class="icon icon-single-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 0), array('title' => '单图文', 'onclick' => 'js:return popup($(this),"单图文库",850,500);')); ?>
                                        </li>
                                        <li>
                                            <?php echo CHtml::link('<i class="icon icon-more-graphic"></i>', array('sourcefile', 'type' => 5, 'multi' => 1), array('title' => '多图文', 'onclick' => 'js:return popup($(this),"多图文库",850,500);')); ?>
                                        </li>
                                        <li>
                                        <?php } ?>
                                    </li>
                                    <li>
                                    <?php echo CHtml::link('<i class="icon icon-voice"></i>', array('sourcefile', 'type' => 3), array('title' => '音频','onclick' => 'js:return popup($(this),"音频文库",850,500);')); ?>
                                    </li>
                                    <li>
                                        <?php echo CHtml::link('<i class="icon icon-video"></i>', array('sourcefile', 'type' => 4), array('title' => '视频','onclick' => 'js:return popup($(this),"视频文库",850,500);')); ?>
                                    </li>
                                </ul>
                                <div class="relative popup-fodder popup-fodder-teletext" id="news-section"></div>
                                <div class="clear"></div>
                                <div class="editing-tab-input" id="text-section">
                                    <?php echo $form->textArea($model, 'content', array('rows' => 10, 'cols' => 80,'data-id' => 0, 'data-type' => 1, 'onchange' => 'js:return popupConfirm($(this),$("#result-id"),$("#result-multi"),$("#result-type"),1)')); ?>
                                    <?php // $form->textArea($model, 'content', array('id' => 'operationText', 'data-id' => 0, 'data-multi' => 0, 'data-type' => 1, 'onchange' => 'js:return popupConfirm($(this),$("#result-id"),$("#result-multi"),$("#result-type"),1)')); ?>
                                </div>
                                <div class="editing_toolbar">
                                    <!--<a class="left" href="javascript:;"><i class="icon icon-face"></i></a>
                                    <p class="right">还可以输入<em>500</em>字</p>-->
                                    <p><span class="emotion">表情</span> </p>
                                    <?php echo $form->error($model, 'content'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (Yii::app()->request->getParam('type') == 5): ?>
                    <div class="popup_RContent">
                        <?php
                        $this->renderPartial('news', array(
                            'dataProvider' => $dataProvider,
                            'modelDataProvider' => $modelDataProvider,
                            'sourceFileGather' => $sourceFileGather,
                        ));
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (Yii::app()->request->getParam('type')): ?>
                    <div class="row buttons margin-top-15">
                        <?php echo $form->hiddenField($model, 'type', array('id' => 'result-type')); ?>
                        <?php echo $form->hiddenField($model, 'source_file_id', array('id' => 'result-id')); ?>
                        <?php echo $form->hiddenField($model, 'multi', array('id' => 'result-multi')); ?>
                        <?php echo $form->hiddenField($model, 'rule_id', array('value' => Yii::app()->request->getParam('rule_id'))); ?>
                        <?php echo $form->labelEx($model, 'sort'); ?>
                        <?php echo $form->textField($model, 'sort'); ?>
                        <?php echo $form->error($model, 'sort'); ?>
                    </div>
                </div>
                <div class="row buttons margin-bottom-20 padding-top-10 reply">
                    <?php echo CHtml::submitButton('确定', array('class' => 'button button-green')); ?>
                    <input type="button" value="取消" name="yt1" class="button button-white keyword-list-modify-list-cancel">
                </div>
            <?php endif; ?>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('operation', "
        
        $('.delete-gather-item').live('click',function(){
            if(!confirm('您确定要删除这个分组吗?')){return false;}
            var operationUrl = $(this).attr('href');
            var object = $(this);
            $.post(operationUrl,'',function(s){
                object.parent().remove();
            });	
            return false;
	});


");
?>