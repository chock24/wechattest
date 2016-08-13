<?php 
	     $form=$this->beginWidget('CActiveForm', array(
                'id'=>'source-form',
                'enableAjaxValidation'=>true,
                        'enableClientValidation'=>true,
	    				 'htmlOptions' => array( 'enctype' => 'multipart/form-data', ),
                  

        )); 
	?>
		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
		<div class="row">
		<?php echo '长度'; ?>
		<?php echo $form->textField($model,'length'); ?>
		<?php echo $form->error($model,'length'); ?>
	</div>
	<div class=”row”>
		<?php echo "上传音频;"; ?>
		<?php echo CHtml::activeFileField($model,'files'); ?>
		<?php if(Yii::app()->user->hasFlash('alert'))
		{
			echo '<br/>'.Yii::app()->user->getFlash('alert');
		}
		?>
		<?php echo $form->error($model,'files'); ?>
		
	</div>
	<div class="row">
		<?php echo CHtml::submitButton('确认上传'); ?>
		
	</div>
	<?php $this->endWidget(); ?>