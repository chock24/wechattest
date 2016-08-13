<div class="gather-item">
    <?php
        echo CHtml::link(
                $data->name . '(' . $data->gatherCount . ')', 
                'javascript:;', 
                array(
                    'class' => 'select-gather-item', 
                    'data-url' => Yii::app()->createUrl(
                            $this->route, 
                            array(
                                'id' => Yii::app()->request->getParam('id'), 
                                'genre' => Yii::app()->request->getParam('genre'), 
                                'gather' => $data->id, 
                                'type' => $data->type, 
                                'multi' => $data->multi, 
                                'count' => Yii::app()->request->getParam('count'), 
                                'userarr' => Yii::app()->request->getParam('userarr')
                            )
                    ),
                    'onclick'=>'js:return operation(this,"open","part")', 
                    'title' => $data->name,
                )
        ); ?>
    <div class="clear"></div>
</div>