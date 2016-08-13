<div class="sidebar-list">
    <?php echo CHtml::link($data->name, Yii::app()->createUrl($this->route, array('gather_id' => $data->id)), array('class' => 'left select-gather-item')); ?>
    <?php echo CHtml::link('<i class="icon icon-del"></i>', array('/basis/sourcefilegather/delete', 'id' => $data->id), array('class' => 'right none select-gather-del')); ?>
    <a href="<?php echo Yii::app()->createUrl('/basis/sourcefilegather/update',array('id' => $data->id)); ?>" class="margin-right-5 right none select-gather-update" onclick="js:return popup($(this), '修改分组名称', 390, 190);"><i class="icon icon-text"></i></a>
</div>