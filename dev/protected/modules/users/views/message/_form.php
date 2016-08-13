<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>

<div class="padding30 form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'message-form',
        'htmlOptions' => array(
            'class' => 'operation-form',
        ),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'remark'); ?>
        <?php echo $form->textField($model, 'remark'); ?>
        <?php echo $form->error($model, 'remark'); ?>
        <?php echo $form->hiddenField($model, 'view_id', array('value' => @Yii::app()->request->getParam('view_id'))); ?>
    </div>
    <div class="row"></div>
    <div class="row popup-footer">

        <?php echo CHtml::submitButton('确认提交', array('class' => 'button button-green confirm establish')); ?>
        <?php echo CHtml::button('取消', array('class' => 'closed button')); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->