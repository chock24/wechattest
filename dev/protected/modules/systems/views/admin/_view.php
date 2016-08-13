<tr>
    <td><?php echo CHtml::checkBox('id',false); ?></td>
    <td><?php echo CHtml::encode($data->username); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo CHtml::encode($data->company); ?></td>
    <td><?php echo CHtml::encode($data->province); ?></td>
    <td><?php echo CHtml::encode($data->city); ?></td>
    <td><?php echo CHtml::encode($data->district); ?></td>
    <td><?php echo CHtml::encode($data->group_id); ?></td>
    <td>
        <?php echo CHtml::link('<i class="icon icon-seek"></i>',array('view','id'=>$data->id),array('title'=>'查看')); ?>
        <?php echo CHtml::link('<i class="icon icon-text"></i>',array('update','id'=>$data->id),array('title'=>'修改')); ?>
        <?php echo CHtml::link('<i class="icon icon-del"></i>',array('delete','id'=>$data->id),array('title'=>'删除')); ?>
    </td>
</tr>