<div class="admin-list user-group-management">
    <div class="left admin-list-text">
        <div class="admin-list-text-title">
            <?php echo CHtml::encode($data->name); ?>
            <span>[<?php echo CHtml::encode($data->count); ?>]</span></div>

    </div>
    <div class="right admin-list-a">
        <a href="<?php echo Yii::app()->createUrl('users/usergroup/update', array('id' => $data->id)); ?>" title="修改" onclick="js:return  popup($(this), '修改分组信息', 380, 310);"><i class="icon icon-text"></i></a>
        <a href="<?php echo Yii::app()->createUrl('users/usergroup/delete', array('id' => $data->id)); ?>" title="删除"><i class="icon icon-del"></i></a>
    </div>
</div>