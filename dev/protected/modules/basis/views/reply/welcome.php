<?php
/* @var $this ReplyController */
/* @var $model Reply */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '欢迎语',
);
?>

<h1>欢迎语</h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('success'); ?>
</div>

<?php elseif(Yii::app()->user->hasFlash('error')): ?>

<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<div class="span-100">
    <div class="message-menu">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => '文字信息', 'url' => array('welcome', 'type' => 1), 'active' => Yii::app()->request->getParam('type') == 1),
                array('label' => '图片信息', 'url' => array('welcome', 'type' => 2), 'active' => Yii::app()->request->getParam('type') == 2),
                array('label' => '语音信息', 'url' => array('welcome', 'type' => 3), 'active' => Yii::app()->request->getParam('type') == 3),
                array('label' => '视频信息', 'url' => array('welcome', 'type' => 4), 'active' => Yii::app()->request->getParam('type') == 4),
                array('label' => '图文信息', 'url' => array('welcome', 'type' => 5), 'active' => Yii::app()->request->getParam('type') == 5),
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
            
            <?php if(Yii::app()->request->getParam('type')==1): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'content'); ?>
                        <?php echo $form->textArea($model,'content', array('rows' => 10, 'cols' => 80)); ?>
                        <?php echo $form->error($model,'content'); ?>
                </div>
            <?php endif; ?>
            
            <?php if(Yii::app()->request->getParam('type')==2): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'source_file_id'); ?>
                        <?php echo $form->fileField($model,'source_file_id'); ?>
                        <?php echo $form->error($model,'source_file_id'); ?>
                </div>
            <?php endif; ?>
            
            <?php if(Yii::app()->request->getParam('type')==3): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'source_file_id'); ?>
                        <?php echo $form->fileField($model,'source_file_id'); ?>
                        <?php echo $form->error($model,'source_file_id'); ?>
                </div>
            <?php endif; ?>
            
            <?php if(Yii::app()->request->getParam('type')==4): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'source_file_id'); ?>
                        <?php echo $form->fileField($model,'source_file_id'); ?>
                        <?php echo $form->error($model,'source_file_id'); ?>
                </div>
            <?php endif; ?>
            
            <?php if(Yii::app()->request->getParam('type')==5): ?>
                <div class="row">
                        <?php echo $form->labelEx($model,'source_file_id'); ?>
                        <?php echo $form->fileField($model,'source_file_id'); ?>
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