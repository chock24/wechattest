<?php
/* @var $this UsergroupController */
/* @var $model UserGroup */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-group-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>


    <?php echo $form->errorSummary($model); ?>
    <div class="padding30">
        <div class="row">
            <?php echo $form->labelEx($model, 'name', array('class' => 'width-25')); ?><br/>
            <?php echo $form->textField($model, 'name', array('size' => 40, 'maxlength' => 55, 'class' => 'margin-top-8 margin-left-20')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row margin-top-15">
            <?php echo $form->labelEx($model, 'count'); ?><br/>
            <?php echo $form->textField($model, 'count', array('size' => 40, 'class' => 'margin-top-8 margin-left-20')); ?>
            <?php echo $form->error($model, 'count'); ?>
        </div>

        <div class="row margin-top-15">
            <?php echo $form->labelEx($model, 'sort'); ?><br/>
            <?php echo $form->textField($model, 'sort', array('size' => 40, 'class' => 'margin-top-8 margin-left-20')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </div>
    </div>

    <div class="row buttons popup-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? '确认创建' : '保存修改', array('class' => "button button-green")); ?>
        <input type="button" class="closed button" name="yt1" value="取消">
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->