<?php
///* @var $this PosterTypeController */
///* @var $model PosterType */
///* @var $form CActiveForm */
//?>
<!---->
<!--<div class="form">-->
<!---->
<?php //$form=$this->beginWidget('CActiveForm', array(
//	'id'=>'poster-type-form',
//	// Please note: When you enable ajax validation, make sure the corresponding
//	// controller action is handling ajax validation correctly.
//	// There is a call to performAjaxValidation() commented in generated controller code.
//	// See class documentation of CActiveForm for details on this.
//	'enableAjaxValidation'=>false,
//)); ?>
<!---->
<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->
<!---->
<!--	--><?php //echo $form->errorSummary($model); ?>
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'admin_id'); ?>
<!--		--><?php //echo $form->textField($model,'admin_id'); ?>
<!--		--><?php //echo $form->error($model,'admin_id'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'col_name'); ?>
<!--		--><?php //echo $form->textField($model,'col_name',array('size'=>32,'maxlength'=>32)); ?>
<!--		--><?php //echo $form->error($model,'col_name'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'is_delete'); ?>
<!--		--><?php //echo $form->textField($model,'is_delete'); ?>
<!--		--><?php //echo $form->error($model,'is_delete'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'time_created'); ?>
<!--		--><?php //echo $form->textField($model,'time_created'); ?>
<!--		--><?php //echo $form->error($model,'time_created'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'time_updated'); ?>
<!--		--><?php //echo $form->textField($model,'time_updated'); ?>
<!--		--><?php //echo $form->error($model,'time_updated'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row buttons">-->
<!--		--><?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
<!--	</div>-->
<!---->
<?php //$this->endWidget(); ?>
<!---->
<!--</div><!-- form -->

<?php
/* @var $this giftTypeController */
/* @var $model giftType */
/* @var $form CActiveForm */
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/poster/index'); ?>">海报列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/poster/create'); ?>">新增海报</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/postertype/index'); ?>">所属栏目管理</a></li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <div class="padding20 tabhost-center">

        <div class="form marketing_add_article">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id'=>'poster-type-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>

            <?php echo $form->errorSummary($model); ?>
            <div class="row add_article_list">
                <?php echo $form->labelEx($model,'栏目名称'); ?>
                <?php echo $form->textField($model,'col_name',array('size'=>32,'maxlength'=>32)); ?>
                <?php echo $form->error($model,'col_name'); ?>
            </div>
            <div class="row buttons add_article_list">
                <label><?php echo CHtml::submitButton($model->isNewRecord ? '确定' : '保存',array('class'=>'margin-top-15 button button-green')); ?></label>
            </div>
            <?php $this->endWidget(); ?>

        </div>


    </div>
</div>