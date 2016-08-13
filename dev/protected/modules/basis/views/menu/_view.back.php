<?php
/* @var $this MenuController */
/* @var $data Menu */
?>

<div class="view">
    <?php echo CHtml::link($data->title, array('index', 'id' => $data->id), array('class' => 'view-item')); ?>
    <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/round_add.png', '添加子菜单项', array('title' => '添加子菜单项')), array('/basis/menu/create', 'id' => $data->id), array('class' => 'create-item')); ?>
    <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/edit.png', '修改菜单项', array('title' => '修改菜单项')), array('/basis/menu/update', 'id' => $data->id), array('class' => 'update-item')); ?>
    <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/trash.png', '删除本菜单项', array('title' => '删除本菜单项')), array('/basis/menu/delete', 'id' => $data->id), array('class' => 'delete-item')); ?>
</div>
<?php if ($data->childrens): ?>
    <?php foreach ($data->childrens as $value): ?>
        <div class="children-view view">
            <?php echo CHtml::link($value->title, array('index', 'id' => $value->id), array('class' => 'view-item')); ?>
            <?php if ($value->type == 1)://发送内容?>
                <?php if ($value->category == 1 && empty($value->description))://文本内容?>
                    <span class="menu-error">无内容</span>
                <?php elseif ($value->category == 5 && !$value->source_file_id)://图文内容?>
                    <span class="menu-error">无内容</span>
                <?php endif; ?>
            <?php elseif ($value->type == 2)://跳转链接?>
                <?php if (empty($value->url)): ?>
                    <span class="menu-error">无内容</span>
                <?php endif; ?>
            <?php else: ?>
                <span class="menu-error">无内容</span>
            <?php endif; ?>
            <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/edit.png', '修改菜单项', array('title' => '修改菜单项')), array('/basis/menu/update', 'id' => $value->id), array('class' => 'update-item')); ?>
            <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/trash.png', '删除本菜单项', array('title' => '删除本菜单项')), array('/basis/menu/delete', 'id' => $value->id), array('class' => 'delete-item')); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
