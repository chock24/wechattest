<div class="create-menu-nav-content">
    <dl>
        <dt>
        <?php echo CHtml::link('<strong>' . $data->title . '</strong>', array('index', 'id' => $data->id), array('class' => Yii::app()->request->getParam("id") == $data->id ? "background-f4f5f9" : "view-item")); ?>
        <span class="right none margin-right-5 create-menu-nav-content-event">
            <?php echo CHtml::link('', array('create', 'id' => $data->id), array('class' => 'icon-16 icon-16-add ', 'title' => '添加二级菜单', 'onclick' => 'js:return popup($(this),"创建二级菜单",700,350);')); ?>
            <?php echo CHtml::link('', array('update', 'id' => $data->id), array('class' => 'icon-16 icon-16-text ', 'title' => '修改菜单项', 'onclick' => 'js:return popup($(this),"修改菜单项",700,350);')); ?>
            <?php echo CHtml::link('', array('delete', 'id' => $data->id), array('class' => 'icon-16 icon-16-del ', 'title' => '删除菜单项', 'onclick' => 'js:return confirm("您确定要删除这个菜单项吗？");')); ?>
        </span>
        </dt>
        <?php if ($data->childrens): ?>
            <?php foreach ($data->childrens as $value): ?>
                <?php if ($value->status == 1) { ?>
                    <dd class="lock">
                    <?php } else { ?>
                    <dd>
                    <?php } ?>
                    <?php echo CHtml::link('<span class="padding10">●</span><strong>' . $value->title . '</strong>', array('index', 'id' => $value->id), array('class' => Yii::app()->request->getParam("id") == $value->id ? "background-f4f5f9" : "view-item")); ?>
                    <span class="right none margin-right-5 create-menu-nav-content-event">
                        <?php if (Yii::app()->user->getState('public_id') == '1') { ?>
                            <?php if ($value->status == 1) { ?>
                        <a href="<?php echo Yii::app()->createUrl('basis/menu/index', array('id' => $value->id, 'status' => '0')) ?>" title="解锁菜单项" class="margin-right-5"><i class="icon-16 icon-16-lock"></i></a>
                            <?php } else { ?>
                                <a href="<?php echo Yii::app()->createUrl('basis/menu/index', array('id' => $value->id, 'status' => '1')) ?>" title="锁定菜单项" class="margin-right-5"><i class="icon-16 icon-16-unlock"></i></a>
                            <?php } ?>
                            <?php echo CHtml::link('<i class="icon-16 icon-16-text"></i>', array('update', 'id' => $value->id), array('class'=>'margin-right-5','title' => '修改菜单项', 'onclick' => 'js:return popup($(this),"修改菜单项",700,350);')); ?>
                            <?php echo CHtml::link('<i class="icon-16 icon-16-del "></i>', array('delete', 'id' => $value->id), array('class'=>'margin-right-5','title' => '删除菜单项', 'onclick' => 'js:return confirm("您确定要删除这个菜单项吗？");')); ?>
                        <?php } elseif ($value->template == '0') { ?>
                            <?php echo CHtml::link('<i class="icon-16 icon-16-text"></i>', array('update', 'id' => $value->id), array('class'=>'margin-right-5','title' => '修改菜单项', 'onclick' => 'js:return popup($(this),"修改菜单项",700,350);')); ?>
                            <?php echo CHtml::link('<i class="icon-16 icon-16-del "></i>', array('delete', 'id' => $value->id), array('class'=>'margin-right-5','title' => '删除菜单项', 'onclick' => 'js:return confirm("您确定要删除这个菜单项吗？");')); ?>
                            <?php
                        } else {
                            //删除修改内容显示
                            echo CHtml::link('<i class="icon-16 icon-16-text"></i>', array('update', 'id' => $value->id), array('class' => 'margin-right-5', 'title' => '修改菜单项', 'onclick' => 'js:return popup($(this),"修改菜单项",700,350);'));
                            echo CHtml::link('<i class="icon-16 icon-16-del "></i>', array('delete', 'id' => $value->id), array('class' => 'margin-right-5', 'title' => '删除菜单项', 'onclick' => 'js:return confirm("您确定要删除这个菜单项吗？");'));
                        }
                        ?>
                    </span>
                </dd>
            <?php endforeach; ?>
        <?php endif; ?>

    </dl>
</div>

