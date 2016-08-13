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
                <li><a href="<?php echo Yii::app()->createUrl('systems/gift/index'); ?>">礼品商城</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/gift/create'); ?>">新增礼品</a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('systems/giftType/index'); ?>">分类管理</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/giftExchange/index'); ?>">兑换记录</a></li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <div class="padding20 tabhost-center">

        <div class="form marketing_add_article">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'gift-type-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>

            <?php echo $form->errorSummary($model); ?>
            <div class="row add_article_list">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <div class="row buttons add_article_list">
                <label><?php echo CHtml::submitButton($model->isNewRecord ? '确定' : '保存',array('class'=>'margin-top-15 button button-green')); ?></label>
            </div>
            <?php $this->endWidget(); ?>

        </div>


    </div>
</div>

