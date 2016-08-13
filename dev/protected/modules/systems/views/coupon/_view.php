<?php if ($index == 0) { ?>
    <thead>
        <tr>
            <th><input type="checkbox" value="checkbox" data-id="data-checkbox"></th>
            <th>ID</th>
            <th>优惠劵编号</th>
            <th>价格</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th width="300">使用条件</th>
            <th>状态</th>
            <th>创建时间</th>
        </tr>
    </thead>
<?php } ?> 
<tbody>
    <tr>
        <td><input type="checkbox" value="checkbox" data-id="data-checkbox"></td>
        <td><?php echo $index+1;?></td>
        <td><?php echo CHtml::encode($data->number)?></td>
        <td><?php echo CHtml::encode($data->price)?></td>
        <td><?php echo date('Y-m-d',$data->time_start);?></td>
        <td><?php echo date('Y-m-d',$data->time_end)?></td>
        <td><?php echo CHtml::encode($data->description)?></td>
        <td><?php echo $data->status==0? '未过期':'已过期';?></td>
        <td><?php echo date('Y-m-d',$data->time_created)?></td>
    </tr>
</tbody>