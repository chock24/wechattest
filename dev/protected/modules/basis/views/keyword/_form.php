<?php
/* @var $this KeywordController */
/* @var $model Keyword */
/* @var $form CActiveForm */
?>

<div class="form">



    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'keyword-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?> 
    <?php echo $form->errorSummary($model); ?>
    <div class="padding30">
        <div class="row margin-top-15">
            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo $form->textField($model, 'title', array('size' => 30, 'maxlength' => 30)); ?>
            <?php echo $form->error($model, 'title'); ?>
        </div>
        <div class="row margin-top-15">
            <?php echo $form->labelEx($model, 'type'); ?>
            <?php echo $form->checkbox($model, 'type'); ?>
            <?php echo $form->error($model, 'type'); ?>
        </div>

    </div>

    <div class="row buttons popup-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改', array('class' => 'button button-green')); ?>
        <input type="button" class="closed button" name="yt1" value="取消">
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->