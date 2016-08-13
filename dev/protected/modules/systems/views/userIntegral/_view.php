<?php if ($index == 0) { ?>

    <thead>
        <tr>
            <th><input type="checkbox" value="checkbox" data-id="data-checkbox"></th>
            <th>ID</th>
            <th>用户id</th>
            <th>积分类型</th>
            <th>分值</th>
            <th>积分说明</th>
            <th>创建时间</th>
        </tr>
    </thead>
<?php } ?>
<tbody>
    <tr>
        <td><input type="checkbox" value="checkbox" data-id="data-checkbox"></td>
        <td><?php echo CHtml::encode($data->id); ?></td>
        <td><?php echo CHtml::encode($data->user_id); ?></td>
        <td><?php echo Yii::app()->params->INTEGRALTYPE[$data->type_id]; ?></td>
        <td><?php echo CHtml::encode($data->score); ?></td>
        <td><?php echo CHtml::encode($data->cause); ?></td>
        <td><?php echo date('Y-m-d', $data->time_created); ?></td>

    </tr>
</tbody>
