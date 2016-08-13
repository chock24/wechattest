<div class="background-white content">

    <div class="padding30">
        <h2 class="content-main-title">创建管理员</h2>
        <div>
            <div class="tabhost">
                <div class="tabhost-title">
                    <ul>
                        <li>
                            <?php echo CHtml::link('系统设置', array('/systems/system/index')); ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('管理员列表', array('/systems/admin/index')); ?>
                        </li>
                        <li class="active">
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
                    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
                </div>
            </div>
        </div>
    </div>

</div>