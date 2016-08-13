<div class="background-white auto login">
    <h2 class="login-title">用户登录</h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="row field">
        <?php echo $form->label($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('size' => 42)); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <div class="row field">
        <?php echo $form->label($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 42)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="row field">
        <?php echo $form->labelEx($model, 'captcha'); ?>
        <?php echo $form->textField($model, 'captcha', array('size' => 20)); ?>
        <?php
        $this->widget('CCaptcha', array(
            'showRefreshButton' => false,
            'clickableImage' => true,
            'imageOptions' => array(
                'class' => 'captcha', 
                'alt' => '点击切换验证吗', 
                'title' => '点击切换验证吗',
            ),
        ));
        ?>	
        <div class="clear"></div>
        <?php echo $form->error($model, 'captcha', array('class' => 'errorMessage captcha-error')); ?>
    </div>
    <div class="clear"></div>
    <div class="row field">
        <?php echo CHtml::submitButton('登录',array('class'=>'button button-green right')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>