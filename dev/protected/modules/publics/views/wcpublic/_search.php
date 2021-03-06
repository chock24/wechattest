<?php
/* @var $this WcpublicController */
/* @var $model WcPublic */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',Yii::app()->params->PUBLICTYPE,array('prompt'=>'请选择')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wechat'); ?>
		<?php echo $form->textField($model,'wechat',array('size'=>60,'maxlength'=>200)); ?>
	</div>
    
        <div class="row">
        <?php echo $form->label($model, 'time_created'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language' => 'zh_cn',
            'model' => $model,
            'attribute' => 'time_start',
            'options' => array(
                'showOn' => 'button', // 'focus', 'button', 'both'  
                'buttonImage' => Yii::app()->request->baseUrl . '/images/cal.png',
                'buttonImageOnly' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'mode' => 'datetime',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly'=>'readonly',
                'maxlength' => 10,
                'style'=>'margin:0; margin-right:5px;',
            )
        ));
        ?>
        
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language' => 'zh_cn',
            'model' => $model,
            'attribute' => 'time_end',
            'options' => array(
                'showOn' => 'button', // 'focus', 'button', 'both'  
                'buttonImage' => Yii::app()->request->baseUrl . '/images/cal.png',
                'buttonImageOnly' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'mode' => 'datetime',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly'=>'readonly',
                'maxlength' => 10,
                'style'=>'margin:0; margin-right:5px;',
            )
        ));
        ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('搜索'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->