<?php
/* @var $this TransmitController */
/* @var $data Transmit */
?>
<?php if ($index == 0) { ?>
    <thead>
        <tr>
            <th><input data-id="data-checkbox" type="checkbox" value="checkbox"></th>
            <th>ID</th>
            <th>活动名称</th>
            <th>开始时间</th>
            <th>结束时间</th>
<!--            <th>状态</th>-->
            <th>排序</th>
            <th>创建时间</th>
            <th width="50"></th>
        </tr>
    </thead>
<?php } ?>
<tbody>
    <tr>
        <td><input data-id="data-checkbox" type="checkbox" value="checkbox"></td>
        <td><?php echo CHtml::encode($data->id); ?></td>
        <td><input data-id="data-title" type="text" size="30" value="<?php echo CHtml::encode($data->title); ?>" /></td>
        <td><?php echo date('Y-m-d', $data->time_start) ?></td>
        <td><?php echo date('Y-m-d', $data->time_end); ?></td>
<!--        <td>
            <?php
            $type_parent_id = 0;
            if (!empty($data->transmit_type)) {
                $type_parent_id = $data->transmit_type->parent_id;
              
            };
            if ($type_parent_id == 15) {
                ?>
                <select data-id="data-status">
                    <option value="0" <?php if ($data->status == 0) echo 'selected'; ?>>未开始</option>
                    <option value="1" <?php if ($data->status == 1) echo 'selected'; ?>>活动中</option>
                    <option value="2" <?php if ($data->status == 2) echo 'selected'; ?>>已结束</option>
                </select>
            <?php }else if ($type_parent_id != 15) { ?>

                <select data-id="data-status">
                    <option value="0" <?php if ($data->status == 0) echo 'selected'; ?>>取消置顶</option>
                    <option value="1" <?php if ($data->status == 1) echo 'selected'; ?>>置顶</option>

                </select>
            <?php }
            ?>
        </td>-->
        <td><input data-id="data-by" type="text" value="<?php echo CHtml::encode($data->order_by); ?>" size="5" /></td>
        <td><?php echo date('Y-m-d', $data->time_created); ?></td>
        <td>
            <a class="left" href="<?php echo Yii::app()->createUrl('systems/transmit/update', array('id' => $data->id)) ?>" title="编辑"><i class="icon icon-text"></i></a>
            <a class="right" href="<?php echo Yii::app()->createUrl('systems/transmit/delete', array('id' => $data->id)) ?>" title="删除"><i class="icon icon-del"></i></a>
        </td>
    </tr>
</tbody>