<div class="popup-sidebar-list">
    <?php
    echo CHtml::link($data->name, array(
        'sourcefile',
        'id' => Yii::app()->request->getParam('id'),
        'type' => Yii::app()->request->getParam('type'),
        'gather_id' => $data->id,
        'category' => Yii::app()->request->getParam('category'),
        'multi' => Yii::app()->request->getParam('multi')), 
        array(
            'class' => 'select-gather-item',
        )
    );
    ?>
</div>