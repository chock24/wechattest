<?php
/* @var $this TransmitTypeController */
/* @var $model TransmitType */
/* @var $form CActiveForm */
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmit/index');?>">活动列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmit/index');?>">文章列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/transmit/create');?>">新建文章</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/transmitType/admin');?>">分类管理</a></li>
            </ul>

            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">


            <div class="form marketing_add_article">

                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'transmit-type-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation'=>false,
                )); ?>

                <?php echo $form->errorSummary($model); ?>
                <!--	<div class="row">
                    <?php echo $form->labelEx($model,'admin_id'); ?>
                    <?php echo $form->textField($model,'admin_id'); ?>
                    <?php echo $form->error($model,'admin_id'); ?>
                </div>-->

                <div class="row add_article_list" style="display: none">
                    <?php echo $form->labelEx($model,'parent_id'); ?>
                    <?php echo $form->textField($model,'parent_id',array('value'=>$parent_id)); ?>
                    <?php echo $form->error($model,'parent_id'); ?>
                </div>

                <div class="row add_article_list">
                    <?php echo $form->labelEx($model,'name'); ?>
                    <?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
                    <?php echo $form->error($model,'name'); ?>
                </div>

                <!--	<div class="row">
                    <?php echo $form->labelEx($model,'status'); ?>
                    <?php echo $form->textField($model,'status'); ?>
                    <?php echo $form->error($model,'status'); ?>
                </div>-->



                <div class="row buttons add_article_list">
                    <label></label>
                    <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存',array('class'=>'button button-green')); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->


        </div>
    </div>
</div>


