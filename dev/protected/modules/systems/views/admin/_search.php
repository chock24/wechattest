<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    <table class="wechat-table-seek margin-top-15">
        <tbody>
        <tr>
            <td class="tdl"><?php echo $form->label($model,'username'); ?></td>
            <td><?php echo $form->textField($model,'username',array('size'=>45,'maxlength'=>55)); ?></td>

            <td class="tdl"><?php echo $form->label($model,'name'); ?></td>
            <td><?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>55)); ?></td>
            
            <td class="tdl"><?php echo $form->label($model,'company'); ?></td>
            <td><?php echo $form->textField($model,'company',array('size'=>45,'maxlength'=>55)); ?></td>
        </tr>
        <tr>
            <td class="tdl"><?php echo $form->label($model,'role_id'); ?></td>
            <td><?php echo $form->dropDownList($model,'role_id',Yii::app()->params->ADMINROLE,array('prompt'=>'请选择')); ?></td>

            <td class="tdl"><?php echo $form->label($model,'group_id'); ?></td>
            <td><?php echo $form->dropDownList($model,'group_id',Yii::app()->params->ADMINROLE,array('prompt'=>'请选择')); ?></td>

            <td class="tdl"></td>
            <td></td>

        </tr>
        <tr>
            <td colspan="6">
                <div class="row buttons">
                    <?php echo CHtml::submitButton('确认搜索',array('class'=>'button')); ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

<?php $this->endWidget(); ?>

</div><!-- search-form -->