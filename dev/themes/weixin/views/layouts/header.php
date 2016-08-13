<!--保存系统设置是否成功-->
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
    <script>notifyHide();</script>
<?php elseif (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
    <script>notifyHide();</script>
<?php endif; ?>
<!--保存系统设置是否成功-->
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_image/common/favicon.ico" rel="Shortcut Icon">
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_image/common/favicon.ico" rel="Bookmark">

<div class="header">
    <div class="width-1360 auto">
        <?php
        echo CHtml::link(
                CHtml::image(Yii::app()->baseUrl . '/weixin_image/common/logo.png'), Yii::app()->homeUrl, array('class' => 'logo', 'title' => '欧派微信管理平台')
        );
        ?>
        <?php if (!Yii::app()->user->isGuest)://判断已经登录 ?>
            <div class="right top-user">
                <?php if (Yii::app()->user->getState('public_id'))://判断是否已经选择了公众号 ?>
                    <?php echo CHtml::link('返回首页', array('/site/index'), array('class' => 'left')); ?>
                <?php endif; ?>
                <?php if (Yii::app()->user->getState('roles') == 1)://判断是否是管理员  ?>
                    <ul class="left public-name">
                        <li class="public-name-list">
                            <?php echo CHtml::link('系统管理 <i>&raquo;</i>', 'javascript:;', array('class' => 'left')); ?>
                            <ul class="none public-name-subdirectory">
                                <li>
                                    <?php echo CHtml::link('系统设置', array('/systems/system/index')); ?>
                                    <?php echo CHtml::link('管理员列表', array('/systems/admin/index')); ?>
                                    <?php echo CHtml::link('创建管理员', array('/systems/admin/create')); ?>
                                    <?php echo CHtml::link('登录日志', array('/systems/system/logaccess')); ?>
                                    <?php echo CHtml::link('错误日志', array('/systems/system/logerror')); ?>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
                <?php echo CHtml::link(Yii::app()->user->name, array('/systems/admin/update'), array('class' => 'left')); ?>
                <?php if (Yii::app()->user->getState('public_id'))://判断是否已经选择了公众号 ?>
                    <?php echo CHtml::link('：'.Yii::app()->user->getState('public_name'), array('/publics/wcpublic/'), array('class' => 'left investgames')); ?>
                <?php else: ?>
                    <?php echo CHtml::link('公众号列表', array('/publics/wcpublic/'), array('class' => 'left')); ?>
                <?php endif; ?>
                <?php echo CHtml::link('退出', array('/site/logout'), array('class' => 'border-none left')); ?>
            </div>
        <?php endif; ?>
    </div>
</div>