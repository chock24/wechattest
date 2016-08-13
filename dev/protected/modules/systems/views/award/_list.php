<?php if ($index == 0) { ?>
    <thead>
        <tr>
            <th>ID</th>
            <th>微信昵称</th>
            <th>手机号码</th>
            <th>奖品</th>
            <th>活动名称</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
    </thead>
<?php } ?>
<tbody>
    <tr>
        <td><?php echo CHtml::encode($data->id); ?></td>
        <td><?php echo CHtml::encode($data->nickname); ?></td>
        <td><?php echo CHtml::encode($data->users->mobile); ?></td>
        <td><?php echo CHtml::encode($data->gift_name); ?></td>
        <td><?php echo CHtml::encode($data->transmits->title); ?></td>
        <td><?php echo date('Y-m-d', $data->time_created); ?></td>
        <td>
            <a class="inline-block" href="javascript:;" title="删除"><i class="icon icon-del"></i></a>
        </td>
    </tr>
</tbody>