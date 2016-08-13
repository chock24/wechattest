               
<?php if ($index == 0) { ?>
    <thead>
        <tr>
            <th><input type="checkbox" data-id="data-checkbox" value="checkbox"></th>
            <th>ID</th>
            <th>头像</th>
            <th>昵称</th>
            <th>分组</th>
            <th>手机号</th>
            <th width="80">添加</th>
        </tr>
    </thead>
<?php } ?>
<tbody>
    <tr class="odd">
        <td width="30">
            <input type="checkbox" value="">
        </td>
        <td><?php echo CHtml::encode($data->id); ?></td>
        <td><image src='<?php echo CHtml::encode($data->headimgurl);?>' width='64px' height='64px'/></td>
        <td><?php echo CHtml::encode($data->nickname); ?></td>
        <td><?php echo $this->groupname($data->group_id); ?></td>
        <td><?php echo CHtml::encode($data->mobile); ?></td>
        <td><a href="javascript:;" class="button web-menu-btn width-auto" onclick="js:return popup($(this), '添加分組', 590, 475);">确定</a></td>
</tbody>