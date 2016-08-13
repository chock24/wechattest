<div class="background-white content">
    <div class="padding30">
        <h2 class="content-main-title">系统设置</h2>
        <div>
            <div class="tabhost">
                <div class="tabhost-title">
                    <ul>
                        <li class="active">
                            <?php echo CHtml::link('系统设置', array('/systems/system/index')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('管理员列表', array('/systems/admin/index')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('创建管理员', array('/systems/admin/create')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('登录日志', array('/systems/system/logaccess')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('错误日志', array('/systems/system/logerror')); ?>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="tabhost-center">
                    <div class="tabhost-center">

                        <div class="form-compile">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'system-form',
                                'enableAjaxValidation' => false,
                            ));
                            ?>
                            <div class="form-compile-list">
                                <?php echo $form->labelEx($model, 'title'); ?>
                                <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
                                <?php echo $form->error($model, 'title'); ?>
                            </div>

                            <div class="form-compile-list">
                                <?php echo $form->labelEx($model, 'keyword'); ?>
                                <?php echo $form->textField($model, 'keyword', array('size' => 60, 'maxlength' => 255)); ?>
                                <?php echo $form->error($model, 'keyword'); ?>
                            </div>

                            <div class="form-compile-list">
                                <?php echo $form->labelEx($model, 'description'); ?>
                                <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 255)); ?>
                                <?php echo $form->error($model, 'description'); ?>
                            </div>

                            <div class="form-compile-list">
                                <?php echo $form->labelEx($model, 'safe'); ?>
                                <?php echo $form->checkBox($model, 'safe', array('class'=>'margin-top-8')); ?>
                                <?php echo $form->error($model, 'safe'); ?>
                            </div>

                            <div class="form-compile-list">
                                <?php echo $form->labelEx($model, 'white_ip'); ?>
                                <?php echo $form->textArea($model, 'white_ip', array('rows' => 6, 'cols' => 50)); ?>
                                <span class="color-9">*白名单是一直可以访问本站的。</span>
                                <?php echo $form->error($model, 'white_ip'); ?>
                            </div>

                            <div class="form-compile-list">
                                <?php echo $form->labelEx($model, 'black_ip'); ?>
                                <?php echo $form->textArea($model, 'black_ip', array('rows' => 6, 'cols' => 50)); ?>
                                <span class="color-9">*开启安全模式后，黑名单ip是无法访问本站的。</span>
                                <?php echo $form->error($model, 'black_ip'); ?>
                            </div>

                            <div class="form-compile-list buttons">
                                <?php echo CHtml::submitButton('保存设置', array('class' => 'button button-green web-menu-btn')); ?>
                            </div>

                            <?php $this->endWidget(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>