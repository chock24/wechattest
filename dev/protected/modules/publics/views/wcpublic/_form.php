<?php
/* @var $this WcpublicController */
/* @var $model WcPublic */
/* @var $form CActiveForm */
?>



<div class="form form-compile">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'wc-public-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', Yii::app()->params->PUBLICTYPE, array('class' => 'margin-top-8')); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'original'); ?>
        <?php echo $form->textField($model, 'original', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'original'); ?>
    </div>

    <!--<div class="row form-compile-list">
    <?php echo $form->labelEx($model, 'headimage'); ?>
    <?php echo $form->fileField($model, 'headimage', array('size' => 60, 'maxlength' => 200)); ?>
    <?php echo $form->error($model, 'headimage'); ?>
    </div>-->

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'wechat'); ?>
        <?php echo $form->textField($model, 'wechat', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'wechat'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'appid'); ?>
        <?php echo $form->textField($model, 'appid', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'appid'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'appsecret'); ?>
        <?php echo $form->textField($model, 'appsecret', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'appsecret'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'watermark'); ?>
        <?php echo $form->textField($model, 'watermark', array('size' => 60, 'maxlength' => 20)); ?>
        <span class="color-9">*添加/修改水印文字后，需要退出才能即时生效。</span>
        <?php echo $form->error($model, 'watermark'); ?>
    </div>

    <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'change'); ?>
        <?php echo $form->checkBox($model, 'change', array('class' => 'margin-top-8')); ?>
        <?php echo $form->error($model, 'change'); ?>
    </div>
       <div class="row form-compile-list">
        <?php echo $form->labelEx($model, 'trust'); ?>
        <?php echo $form->checkBox($model, 'trust', array('class' => 'margin-top-8')); ?>
        <?php echo $form->error($model, 'trust'); ?>
    </div>
    <div class="row form-compile-list">
        <label>所属客服</label>


        <?php //echo $form->checkBoxList($model, 'all_kefu', $kefulist, array('template' => '<span class="check prent-label-width-auto">{input}{label}</span>', 'separator' => ' ')); 
        ?>
        <span class="prent-label-width-auto">
            <?php /* echo $form->radioButtonList($model,'all_kefu',$kefulist); */ ?>
            <?php 
            foreach ($kefulist as $key => $v) {
                ?>
            <input id="WcPublic_all_kefu_0" type="radio" name="WcPublic[all_kefu]" value="<?php echo  $key;?>" <?php if($model->all_kefu==$key){?>checked="checked"<?php } ?>>
                <label for="<?php echo  $key;?>"><?php echo $v; ?></label>
            <?php } ?>
        </span>

        <div class="clear"></div>
    </div>
    <div class="row form-compile-list buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? '创建公众号' : '保存修改', array('onclick' => 'js:return confirm("如果您当前未选择公众号，或者您修改了当前的公众号，您将会自动退出，修改设置即时生效。")', 'class' => 'button')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<style type="text/css">
    .prent-label-width-auto input {margin: 8px 2px 0 0;float: left;}
    .prent-label-width-auto label {width: auto;}
</style>