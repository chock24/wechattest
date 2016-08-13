<?php if ($index == 0) { ?>

    <thead>
        <tr>
            <th><input type="checkbox" value="checkbox" data-id="data-checkbox"></th>
            <th>ID</th>
            <th>用户名</th>
            <th>礼品名称</th>
            <th>收货人</th>
            <th>收货地址</th>
            <th>邮编</th>
            <th>电话</th>
            <th>积分</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th width="30"></th>
        </tr>
    </thead>
<?php } ?>
<tbody>
    <tr>
        <td><input type="checkbox" value="checkbox" data-id="data-checkbox"></td>
        <td><?php echo CHtml::encode($data->id); ?></td>
        <td><?php echo CHtml::encode($data->user->nickname); ?></td>
        <td><?php echo $data->gift_name; ?></td>
        <td><?php echo $data->name; ?></td>
        <td><?php echo $data->sheng->name . $data->shi->name . $data->qu->name . $data->address_other; ?></td>
        <td><?php echo CHtml::encode($data->postcode); ?></td>
        <td><?php echo CHtml::encode($data->tel); ?></td>
        <td><?php echo CHtml::encode($data->score); ?></td>
        <td>
            <select id="GiftExchange_status" name="GiftExchange[status]">
                <option <?php
                if ($data->status == 0) {
                    echo 'selected="selected"';
                }
                ?> value="0">未发货</option>
                <option <?php
                if ($data->status == 1) {
                    echo 'selected="selected"';
                }
                ?>  value="1">已发货</option>
            </select>

        <td><?php echo date('Y-m-d', $data->time_created); ?></td>
        <td><?php echo date('Y-m-d', $data->time_updated); ?></td>
        <td><a title="编辑" href="<?php echo Yii::app()->createUrl('systems/giftExchange/update', array('id' => $data->id)); ?>" class="margin-left-5 left"><i class="icon icon-text"></i></a></td>
    </tr>
</tbody>
