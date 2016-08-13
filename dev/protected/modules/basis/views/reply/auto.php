<?php
/* @var $this ReplyController */
/* @var $model Reply */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '自动回复',
);
?>

<h1>自动回复</h1>



<div class="span-24 left">
    <div class="message-menu">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => '文字', 'url' => array('auto', 'type' => 'text'), 'active' => Yii::app()->request->getParam('type') == 'text'),
                array('label' => '图片', 'url' => array('auto', 'type' => 'image'), 'active' => Yii::app()->request->getParam('type') == 'image'),
                array('label' => '语音', 'url' => array('auto', 'type' => 'voice'), 'active' => Yii::app()->request->getParam('type') == 'voice'),
                array('label' => '视频', 'url' => array('auto', 'type' => 'video'), 'active' => Yii::app()->request->getParam('type') == 'video'),
            ),
        ));
        ?>
        <div class="clear"></div>
    </div><!-- mainmenu -->

    <div class="message">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'reply-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <?php echo $form->hiddenField($model,'type'); ?>
            
            <?php if(Yii::app()->request->getParam('type')=='text'): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'content'); ?>
                        <?php echo $form->textArea($model,'content', array('rows' => 10, 'cols' => 80)); ?>
                        <?php echo $form->error($model,'content'); ?>
                </div>
            <?php endif; ?>
            
            <?php if(Yii::app()->request->getParam('type')=='image'): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'source_file_id'); ?>
                        <?php echo $form->textArea($model,'source_file_id', array('rows' => 10, 'cols' => 80)); ?>
                        <?php echo $form->error($model,'source_file_id'); ?>
                </div>
            <?php endif; ?>
            
            <?php if(Yii::app()->request->getParam('type')=='voice'): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'source_file_id'); ?>
                        <?php echo $form->textArea($model,'source_file_id', array('rows' => 10, 'cols' => 80)); ?>
                        <?php echo $form->error($model,'source_file_id'); ?>
                </div>
            <?php endif; ?>
            
            <?php if(Yii::app()->request->getParam('type')=='video'): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'source_file_id'); ?>
                        <?php echo $form->textArea($model,'source_file_id', array('rows' => 10, 'cols' => 80)); ?>
                        <?php echo $form->error($model,'source_file_id'); ?>
                </div>
            <?php endif; ?>

            <?php if(Yii::app()->request->getParam('type')): ?>
                <div class="row buttons">
                    <?php echo CHtml::submitButton('保存设置'); ?>
                </div>
            <?php endif; ?>
            

            <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>
</div>