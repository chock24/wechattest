<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>
<h1>登录网站</h1>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username'); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <div class="clear"></div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="clear"></div>
    <div class="row">
        <?php echo $form->labelEx($model, 'captcha'); ?>
        <?php echo $form->textField($model, 'captcha'); ?>
        <?php
            $this->widget('CCaptcha', array(
                'showRefreshButton' => false,
                'clickableImage' => true,
                'imageOptions' => array('class'=>'captcha','alt' => '点击切换验证吗', 'title' => '点击切换验证吗'),
            ));
        ?>	
        <div class="clear"></div>
        <?php echo $form->error($model, 'captcha', array('class'=>'errorMessage captcha-error')); ?>
    </div>

    <div class="clear"></div>

    <div class="row rememberMe">
        <?php //echo $form->label($model, 'rememberMe'); ?>
        <?php //echo $form->checkBox($model, 'rememberMe',array('class'=>'remember')); ?>
        <?php echo CHtml::submitButton('确认登录',array('class'=>'login-btn')); ?>
    </div>

    <div class="clear"></div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
