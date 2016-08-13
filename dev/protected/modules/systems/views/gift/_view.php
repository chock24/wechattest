<?php if ($index == 0) { ?>

    <thead>
        <tr>
            <th><input type="checkbox" value="checkbox" data-id="data-checkbox"></th>
            <th>ID</th>
            <th>图片</th>
            <th>商品名称</th>
            <th>商品编号</th>
            <th>兑换积分</th>
            <th>库存</th>
            <th>状态</th>
            <th>更新时间</th>
            <th width="50"></th>
        </tr>
    </thead>
<?php } ?>
<tbody>
    <tr>
        <td><input type="checkbox" value="checkbox" data-id="data-checkbox"></td>
        <td><?php echo CHtml::encode($data->id); ?></td>
        <td>
            <?php
            $imgdata=rtrim($data->image_src,',');
            $img    =explode(',',$imgdata);
            ?>
            <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $img[0]; ?>"  class="zoom-limits-img" />
        </td>
        <td><input data-id='data-name' type="text" value="<?php echo CHtml::encode($data->name); ?>" ></td>
        <td><input data-id='data-number' type="text" value="<?php echo CHtml::encode($data->number); ?>" ></td>
        <td><input data-id='data-integral'type="text" value="<?php echo CHtml::encode($data->integral); ?>" size="5"></td>
        <td>
            <?php echo CHtml::encode($data->count_stock); ?>
        </td>
        <td>
            <select data-id="data-status">
                <option  value="0" <?php if ($data->status == 0) echo 'selected'; ?>>下架</option>
                <option  value="1" <?php if ($data->status == 1) echo 'selected'; ?>>在架</option>
            </select>
        </td>
        <td><?php echo date('Y-m-d', $data->time_updated); ?></td>
        <td>
            <a class="left" href="<?php echo Yii::app()->createUrl('systems/gift/update', array('id' => $data->id)); ?>" title="编辑"><i class="icon icon-text"></i></a>
            <a class="right" href="<?php echo Yii::app()->createUrl('systems/gift/delete', array('id' => $data->id)); ?>" title="删除"><i class="icon icon-del"></i></a>
        </td>
    </tr>
</tbody>

<!--                
<div class="view">

        <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('public_id')); ?>:</b>
<?php echo CHtml::encode($data->public_id); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
<?php echo CHtml::encode($data->name); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('type_id')); ?>:</b>
<?php echo CHtml::encode($data->type_id); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
<?php echo CHtml::encode($data->number); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('integral')); ?>:</b>
<?php echo CHtml::encode($data->integral); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
<?php echo CHtml::encode($data->content); ?>
        <br />

<?php /*
  <b><?php echo CHtml::encode($data->getAttributeLabel('image_src')); ?>:</b>
  <?php echo CHtml::encode($data->image_src); ?>
  <br />

  <b><?php echo CHtml::encode($data->getAttributeLabel('remark')); ?>:</b>
  <?php echo CHtml::encode($data->remark); ?>
  <br />

  <b><?php echo CHtml::encode($data->getAttributeLabel('count_stock')); ?>:</b>
  <?php echo CHtml::encode($data->count_stock); ?>
  <br />

  <b><?php echo CHtml::encode($data->getAttributeLabel('order_by')); ?>:</b>
  <?php echo CHtml::encode($data->order_by); ?>
  <br />

  <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
  <?php echo CHtml::encode($data->status); ?>
  <br />

  <b><?php echo CHtml::encode($data->getAttributeLabel('time_created')); ?>:</b>
  <?php echo CHtml::encode($data->time_created); ?>
  <br />

  <b><?php echo CHtml::encode($data->getAttributeLabel('time_updated')); ?>:</b>
  <?php echo CHtml::encode($data->time_updated); ?>
  <br />

 */ ?>

</div>-->