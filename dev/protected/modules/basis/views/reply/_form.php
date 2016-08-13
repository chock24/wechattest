<?php
/* @var $this ReplyController */
/* @var $model Reply */
/* @var $form CActiveForm */
?>

<div class="form margin-top-15">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reply-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <?php
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/reset.css");
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.qqFace.js");
        Yii::app()->clientScript->registerScript('qqfaceInput', "
        $('.emotion').qqFace({
            id: 'facebox',
            assign: 'Reply_content',
            path: '" . Yii::app()->baseUrl . "/images/arclist/',
        });
    ");
    ?>

	<?php echo $form->errorSummary($model); ?>

        <div class="row padding10">
            <?php echo $form->labelEx($model,'content',array('class'=>'font-14')); ?>
            <div>
                <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50,'class'=>'margin-top-15 width-100','onchange' => 'js:return popupConfirm($(this),$("#result-id"),$("#result-multi"),$("#result-type"),1)')); ?>
                <?php echo $form->error($model,'content'); ?>
            </div>
            <div class="margin-top-5">
                <p><span class="emotion">表情</span> </p>
                <?php echo $form->error($model, 'content'); ?>
            </div>
	</div>
<!--    <div class="row">
		<?php echo $form->labelEx($model,'sort'); ?>
		<?php echo $form->textField($model,'sort'); ?>
		<?php echo $form->error($model,'sort'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
         <div class="row">
		<?php echo $form->labelEx($model,'source_file_id'); ?>
		<?php echo $form->textField($model,'source_file_id'); ?>
		<?php echo $form->error($model,'source_file_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'isdelete'); ?>
		<?php echo $form->textField($model,'isdelete'); ?>
		<?php echo $form->error($model,'isdelete'); ?>
	</div>

       
	<div class="row">
		<?php echo $form->labelEx($model,'time_created'); ?>
		<?php echo $form->textField($model,'time_created'); ?>
		<?php echo $form->error($model,'time_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_updated'); ?>
		<?php echo $form->textField($model,'time_updated'); ?>
		<?php echo $form->error($model,'time_updated'); ?>
	</div>-->

	<div class="row buttons popup-footer">
		<?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改',array('class'=>'button button-green')); ?>
                
        <input type="button" value="取消" name="yt1" class="closed button button-white">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->