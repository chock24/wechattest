<?php if (Yii::app()->user->hasFlash('notify')): ?>
    <div class="popup-body">
        <div class="create-edit-add-nav">
            <?php echo Yii::app()->user->getFlash('notify'); ?>
        </div>
    </div>
<?php else: ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'menu-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="popup-body">
        <div class="create-edit-add-nav">
            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo $form->textField($model, 'title', array('class' => 'nav_user', 'size' => 60, 'placeholder' => '输入菜单')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </div>
    </div>
    <div class="popup-footer">
        <?php echo CHtml::submitButton('确认提交', array('class' => 'button button-green confirm establish')); ?>
        <?php echo CHtml::button('取消', array('class' => 'closed button')); ?>
    </div>
    <?php $this->endWidget(); ?>
<?php endif; ?>