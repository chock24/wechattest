<?php
/* @var $this SourcefileController */
/* @var $model SourceFile */

$this->breadcrumbs=array(
	'Source Files'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SourceFile', 'url'=>array('index')),
	array('label'=>'Manage SourceFile', 'url'=>array('admin')),
);
?>
<?php 
 $type = Yii::app()->request->getParam('type');
 
	     $form=$this->beginWidget('CActiveForm', array(
                'id'=>'source-create-form',
                
                        'enableClientValidation'=>true,
	    				 'htmlOptions' => array( 'enctype' => 'multipart/form-data', ),
//	   					  	'clientOptions' => array(
//                                'validateOnSubmit' => true,
//                                'afterValidate'=>'js:function(form,data,hasError){
//                                        if(!hasError){
//                                         $.ajax({"type":"POST","url":"'.Yii::app()->createUrl('/basis/sourcefile/create').'","data":$("#source-create-form").serialize(),
//                                        "success":function(data){				
//                                                window.location.reload();
//                                        }
//                                });
//                        }
//                        }'
//                        ),
)); 
       
	?>
		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<?php if ($type=="3"){?>
		
	
		<div class="row">
		<?php echo $form->labelEx($model,'length'); ?>
		<?php echo $form->textField($model,'length'); ?>
		<?php echo $form->error($model,'length'); ?>
	</div>
	<div class=”row”>
		<?php echo "上传音频"; ?>
		<?php echo CHtml::activeFileField($model,'files'); ?>
		<?php if(Yii::app()->user->hasFlash('alert'))
		{
			echo '<br/>'.Yii::app()->user->getFlash('alert');
		}
		?>
		<?php echo $form->error($model,'files'); ?>
		
	</div>
	<?php } else if ($type=="4"){?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'length'); ?>
		<?php echo $form->textField($model,'length'); ?>
		<?php echo $form->error($model,'length'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>5, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	<?php echo "上传视频"; ?>
		<?php echo CHtml::activeFileField($model,'files'); ?>
		<?php if(Yii::app()->user->hasFlash('alert'))
		{
			echo '<br/>'.Yii::app()->user->getFlash('alert');
		}
		?>
		<?php echo $form->error($model,'files'); ?>
		<?php }else if ($type=="2"){?>
			<?php echo "上传图片"; ?>
		<?php echo CHtml::activeFileField($model,'files'); ?>
		<?php if(Yii::app()->user->hasFlash('alert'))
		{
			echo '<br/>'.Yii::app()->user->getFlash('alert');
		}
		?>
		<?php echo $form->error($model,'files'); ?>
		<?php }?>
	<div class="row">
		<?php echo CHtml::submitButton('确认上传'); ?>
		
	</div>
	<?php $this->endWidget(); ?>