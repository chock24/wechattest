<?php
/* @var $this PosterController */
/* @var $data Poster */

?>


<tbody>
<tr>
    <td><input type="checkbox" data-id="data-checkbox" value="checkbox"></td>
    <td><?php echo CHtml::encode($data->id); ?></td>
    <td><?php echo $data->typename; ?></td>
    <td><?php echo date('Y-m-d',$data->time_created); ?></td>
    <td>
        <a title="编辑" href="<?php echo Yii::app()->createUrl('systems/Poster/update', array('id' => $data->id)); ?>" class="left"><i class="icon icon-text"></i></a>
        <a title="删除" href="<?php echo Yii::app()->createUrl('systems/Poster/delete', array('id' => $data->id)); ?>" class="right"><i class="icon icon-del"></i></a>
    </td>
</tr>
</tbody>
