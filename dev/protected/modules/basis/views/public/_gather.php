<dd>
    <a class=""  title =<?php echo $data->name; ?>    href="<?php echo Yii::app()->createUrl($this->route, array('id' => Yii::app()->request->getParam('id'), 'genre' => Yii::app()->request->getParam('genre'), 'gather' => $data->id, 'type' => $data->type, 'multi' => $data->multi, 'count' => Yii::app()->request->getParam('count'), 'userarr' => Yii::app()->request->getParam('userarr'))); ?>" onclick="js:return popup($(this), '增加回复内容', 950, 600);" >
        <?php echo $data->name . '(' . $data->gatherCount . ')'; ?></a>
    <?php echo CHtml::link('', array('/basis/sourcefilegather/delete', 'id' => $data->id), array('class' => 'delete-gather-item fu_icon del ', 'title' => '删除')); ?>
    <a class="update-gather-item fu_icon modify create-item"  title ='编辑'  href="<?php echo Yii::app()->createUrl('/basis/sourcefilegather/update',array('id' => $data->id, 'multi' => @$data->multi)); ?>" onclick="js:return popup($(this), '增加回复内容', 550, 400);" >
    </a>
</dd>