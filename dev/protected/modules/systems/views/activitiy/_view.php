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
            <th>活动分类</th>
            <th>转发人数</th>
            <th>阅读人数</th>
            <th>中奖名单</th>
            <th>新增中奖</th>
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
        <td><?php
            if ($data->time_start > time()) {
                echo '活动预告';
            } else if ($data->time_end < time()) {
                echo '下线活动';
            } else {
                echo '最新活动';
            }
            //echo date('Y-m-d H:i:s',$data->time_start);
            ?></td>
        <td><?php echo CHtml::encode($data->number); ?></td>
        <td><?php echo CHtml::encode($data->read_number); ?></td>
        <td> <a class="inline-block" href="<?php echo Yii::app()->createUrl('systems/award/list', array('transmit_id' => $data->id)) ?>" title="中奖名单"><i class="icon icon-examine"></i></a></td>
        <td> <a class="inline-block" href="<?php echo Yii::app()->createUrl('systems/award/create', array('transmit_id' => $data->id)) ?>" title="新增中奖"><i class="icon icon-add"></i></a></td>
        <td><input data-id="data-by" type="text" value="<?php echo CHtml::encode($data->order_by); ?>" size="5" /></td>
        <td><?php echo date('Y-m-d', $data->time_created); ?></td>
        <td>
            <a class="left" href="<?php echo Yii::app()->createUrl('systems/activitiy/update', array('id' => $data->id)) ?>" title="编辑"><i class="icon icon-text"></i></a>
            <a class="right" href="<?php echo Yii::app()->createUrl('systems/activitiy/delete', array('id' => $data->id)) ?>" title="删除"><i class="icon icon-del"></i></a>
        </td>
    </tr>
</tbody>