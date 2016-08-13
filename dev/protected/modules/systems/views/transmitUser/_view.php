<?php if ($index == 0) { ?>

    <thead>
        <tr>
            <th><input type="checkbox" value="checkbox" data-id="data-checkbox"></th>
            <th>ID</th>
            <th>活动名称</th>
            <th>用户昵称</th>
            <th>备注</th>
            <th>转发时间</th>
        </tr>
    </thead>
<?php } ?>
<tbody>
    <tr>
        <td><input type="checkbox" value="checkbox" data-id="data-checkbox"></td>
        <td><?php echo CHtml::encode($data->id); ?></td>
        <td><?php echo CHtml::encode($data->transmits->title); ?></td>
        <td><?php echo CHtml::encode($data->users->nickname); //昵称?></td>
        <td><?php echo CHtml::encode($data->remark); ?></td>
        <td><?php echo date('Y-m-d', $data->time_created); ?></td>
    </tr>
</tbody>
