<?php if ($index == 0) { ?>
    <thead>
        <tr>
            <th width="50"><input type="checkbox" value="checkbox"></th>
            <th>背景</th>
            <th>栏目名称</th>
            <th>链接地址</th>
            <th>排序</th>
            <th width="60">操作</th>
        </tr>
    </thead>
<?php } ?>
<tbody>
    <tr>
        <td><input type="checkbox" value="checkbox"></td>
        <td style="display: none"><?php echo CHtml::encode($data->id); ?></td>
        <td>
            <img src="<?php echo Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['medium'] . $data->bg_img; ?>" />
        </td>
        <td><input data-id='data-title' type="text" size="25" placeholder="栏目名称" value="<?php echo $data->title ?>"></td>
        <td><input data-id='data-url' type="text" size="25" placeholder="链接地址" value="<?php echo $data->url ?>"></td>
        <td><input data-id='data-orderby' type="text" size="5" value="<?php echo $data->order_by ?>"></td>
        <td>
            <a href="<?php echo Yii::app()->createUrl('systems/userModule/update', array('id' => $data->id)) ?>" title="修改"><i class="icon icon-text"></i></a>
            <a href="<?php echo Yii::app()->createUrl('systems/userModule/delete', array('id' => $data->id)) ?>" class="right" title="删除"><i class="icon icon-del"></i></a>
        </td>
    </tr>
</tbody>