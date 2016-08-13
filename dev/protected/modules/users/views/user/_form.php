<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form user-control-popup-body">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'htmlOptions' => array(
            'class' => 'operation-form',
        ),
        'enableClientValidation' => true,
    ));
    ?>
    <?php if ($action == 'level'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'level'); ?>
            <?php echo $form->dropDownList($model, 'level', CHtml::listData(UserLevel::model()->findAll('isdelete=:isdelete', array(':isdelete' => 0)), 'id', 'title')); ?>
            <?php echo $form->error($model, 'level'); ?>
        </div>
    <?php endif; ?>

    <?php if ($action == 'tag'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'tag'); ?>
            <div class="checkboxarea">
                <div class="firstbox">
                    <?php echo $form->checkBoxList($model, 'tag', CHtml::listData(UserTag::model()->findAll('isdelete=:isdelete', array(':isdelete' => 0)), 'id', 'title'), array('checkAll' => '全选/不选', 'separator' => '</div><div class="group">')); ?>
                </div>
                <div class="clear"></div>
            </div>
            <?php echo $form->error($model, 'tag'); ?>
        </div>
    <?php endif; ?>

    <?php if ($action == 'integral'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'value'); ?>
            <?php echo $form->textField($model, 'value'); ?>
            <span>例如：1、2或-1，可以是负数</span>
            <?php echo $form->error($model, 'value'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'notify'); ?>
            <?php echo $form->checkBox($model, 'notify'); ?>
            <?php echo $form->error($model, 'notify'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'cause'); ?>
            <?php echo $form->textArea($model, 'cause', array('rows' => 6, 'cols' => 40)); ?>
            <?php echo $form->error($model, 'cause'); ?>
        </div>
    <?php endif; ?>

    <?php if ($action == 'remark'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'remark'); ?>
            <?php echo $form->textField($model, 'remark'); ?>
            <?php echo $form->error($model, 'remark'); ?>
        </div>
    <?php endif; ?>

    <?php if ($action == 'mobile'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'mobile'); ?>
            <?php echo $form->textField($model, 'mobile'); ?>
            <?php echo $form->error($model, 'mobile'); ?>
        </div>
    <?php endif; ?>

    <?php if ($action == 'sex'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'sex'); ?>
            <?php echo $form->dropDownList($model, 'sex', Yii::app()->params->SEX); ?>
            <?php echo $form->error($model, 'sex'); ?>
        </div>
    <?php endif; ?>
    <?php if ($action == 'language'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'language'); ?>
            <?php echo $form->dropDownList($model, 'language', Yii::app()->params->LANGUAGE); ?>
            <?php echo $form->error($model, 'language'); ?>
        </div>
    <?php endif; ?>

    <?php if ($action == 'age'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'age'); ?>
            <?php echo $form->textField($model, 'age'); ?>
            <?php echo $form->error($model, 'age'); ?>
        </div>
    <?php endif; ?>

    <?php if ($action == 'group'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'group_id'); ?>
            <?php echo $form->dropDownList($model, 'group_id', CHtml::listData(UserGroup::model()->findAll('public_id=:public_id AND isdelete=:isdelete', array(':public_id' => Yii::app()->user->getState('public_id'), ':isdelete' => 0)), 'id', 'name'), array('prompt' => '请选择')); ?>
            <?php echo $form->error($model, 'group_id'); ?>
        </div>
    <?php endif; ?>

    <div class="popup-footer">
        <?php echo CHtml::submitButton('确认提交', array('class' => 'button button-green confirm establish')); ?>
        <?php echo CHtml::button('取消', array('class' => 'closed button')); ?>
    </div>   

    <?php $this->endWidget(); ?>

</div><!-- form -->