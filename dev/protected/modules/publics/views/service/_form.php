<?php
/* @var $this ServiceController */
/* @var $model Service */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'service-form',
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    ?>

    <p class="note">带有 <span class="required">*</span> 号的为必填项。</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'account'); ?>
        <?php echo $form->textField($model, 'account', array('size' => 55, 'maxlength' => 55));?> 
        <span>客服帐号@公众号的微信号</span>
        <?php echo $form->error($model, 'account'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'nickname'); ?>
        <?php echo $form->textField($model, 'nickname', array('size' => 55, 'maxlength' => 55)); ?>
        <?php echo $form->error($model, 'nickname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 55, 'maxlength' => 55, 'value' => '')); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'repeat'); ?>
        <?php echo $form->passwordField($model, 'repeat', array('size' => 55, 'maxlength' => 55, 'value' => '')); ?>
        <?php echo $form->error($model, 'repeat'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'kf_headimg'); ?>
        <?php echo $form->fileField($model, 'kf_headimg'); ?>
        <?php echo $form->error($model, 'kf_headimg'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? '确定创建' : '保存修改'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->