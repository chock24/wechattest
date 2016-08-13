<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCss('checkbox', "		
	.checkboxarea{padding:1px;border:1px solid #a9a9a9;}
	.checkboxarea label{	display:inline;}
	.checkboxarea .firstbox{border-bottom:1px solid #E0E0E0;background:#F4F4F4;font-size:14px;padding:0 0 0 5px;margin-bottom:5px;color:#1670a7;}
	.checkboxarea .firstbox input{margin-bottom:4px;}
	.checkboxarea .group{float:left;width:200px;padding-left:5px;}			
");
?>




<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => array('view', 'id' => Yii::app()->request->getParam('id'), 'order' => Yii::app()->request->getParam('order')),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'remark'); ?>
        <?php echo CHtml::textField('remark', Yii::app()->request->getParam('remark'), array('maxlength' => 55, 'placeholder' => '信息备注')); ?>
    </div>

    <div class="row">
        <?php echo CHtml::checkBoxList('filtershow', Yii::app()->request->getParam('filtershow'), Yii::app()->params->FILTERSHOWTYPE); ?>
    </div>

    <div class="row">
        <?php echo CHtml::radioButtonList('filter', Yii::app()->request->getParam('filter'), Yii::app()->params->FILTERTYPE, array('prompt' => '不选择过滤')); ?>
    </div>



    <div class="row buttons">
        <?php echo CHtml::submitButton('筛选'); ?>
        <input type="reset" value="重置" />
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->