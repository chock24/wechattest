<?php
/* @var $this RuleController */
/* @var $model Rule */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rule-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

    <div class="padding30">
    <!--	<div class="row">
            <?php echo $form->labelEx($model,'admin_id'); ?>
            <?php echo $form->textField($model,'admin_id'); ?>
            <?php echo $form->error($model,'admin_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'public_id'); ?>
            <?php echo $form->textField($model,'public_id'); ?>
            <?php echo $form->error($model,'public_id'); ?>
        </div>-->

        <div class="row">
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('size'=>38,'maxlength'=>60)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>
        <div class="row margin-top-15">
            <div class="left margin-top-10">
                <?php echo $form->labelEx($model,'entire'); ?>
                <?php echo $form->checkbox($model, 'entire'); ?>
                <?php echo $form->error($model,'entire'); ?>
            </div>
            <div class="left margin-left-20">
                <?php echo $form->labelEx($model,'sort'); ?>
                <?php echo $form->textField($model,'sort'); ?>
                <?php echo $form->error($model,'sort'); ?>
            </div>
            <div class="clear"></div>
        </div>
    <!--	<div class="row">
            <?php echo $form->labelEx($model,'status'); ?>
            <?php echo $form->textField($model,'status'); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>-->


    <!--
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
    </div>

	<div class="row buttons popup-footer">
		<?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改',array('class'=>'button button-green')); ?>
        <input type="button" value="取消" name="yt1" class="closed button button-white">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->