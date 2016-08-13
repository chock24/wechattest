<div class="form-compile">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'admin-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <?php if (Yii::app()->user->getState('roles') == 1): ?>
        <?php if($model->id!=Yii::app()->user->id)://如果修改的管理员不是本身 ?>
            <div class="form-compile-list">
                <?php echo $form->labelEx($model, 'role_id'); ?>
                <?php echo $form->dropDownList($model, 'role_id', Yii::app()->params->ADMINROLE,array('class'=>'margin-top-8')); ?>
                <?php echo $form->error($model, 'role_id'); ?>
            </div>
        <?php endif; ?>

        <div class="form-compile-list">
            <?php echo $form->labelEx($model, 'unicom'); ?>
            <?php echo $form->checkbox($model, 'unicom',array('class'=>'margin-top-8')); ?>
            <?php echo $form->error($model, 'unicom'); ?>
        </div>

        <div class="form-compile-list">
            <?php echo $form->labelEx($model, 'bound'); ?>
            <?php echo $form->textField($model, 'bound', array('size' => 55, 'maxlength' => 4)); ?>
            <?php echo $form->error($model, 'bound'); ?>
        </div>
    <?php endif; ?>
    <?php if($model->isNewRecord): ?>
        <div class="form-compile-list">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('size' => 55, 'maxlength' => 55)); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
    <?php else: ?>
        <div class="form-compile-list">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo CHtml::textField('username', $model->username, array('size' => 55, 'maxlength' => 55, 'disabled'=>true)); ?>
        </div>
    <?php endif;?>
    <div class="form-compile-list">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 55, 'maxlength' => 200, 'value' => '')); ?>
        <?php if (!$model->isNewRecord): ?>
            <span>*如不修改请留空。</span>
        <?php endif; ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="form-compile-list">
        <?php echo $form->labelEx($model, 'repeat'); ?>
        <?php echo $form->passwordField($model, 'repeat', array('size' => 55, 'maxlength' => 200, 'value' => '')); ?>
        <?php if (!$model->isNewRecord): ?>
            <span>*如不修改请留空。</span>
        <?php endif; ?>
        <?php echo $form->error($model, 'repeat'); ?>
    </div>

    <div class="form-compile-list">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 55, 'maxlength' => 55)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="form-compile-list province">
        <?php echo $form->labelEx($model, 'province'); ?>
        <?php echo $form->dropDownList($model, 'province', array('0' => '广东省', '1' => '北京市'), array('prompt'=>'请选择','class'=>'margin-top-8 city-one')); ?>
        <?php echo $form->dropDownList($model, 'city', array('0' => '广州市', '1' => '北京市'), array('prompt'=>'请选择','class'=>'margin-top-8 city-two')); ?>
        <?php echo $form->dropDownList($model, 'district', array('0' => '白云区', '1' => '北京市'), array('prompt'=>'请选择','class'=>'margin-top-8 city-three')); ?>
        <?php echo $form->error($model, 'province'); ?>
    </div>

    <div class="form-compile-list">
        <?php echo $form->labelEx($model, 'company'); ?>
        <?php echo $form->textField($model, 'company', array('size' => 55, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'company'); ?>
    </div>

    <div class="form-compile-list">
        <?php echo $form->labelEx($model, 'phone'); ?>
        <?php echo $form->textField($model, 'phone', array('size' => 55, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>

    <div class="form-compile-list buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? '确定创建' : '保存修改',array('class'=>'button button-green')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>


<script type="text/javascript">
    province_seek ($('.province'));
</script>