<div class="admin-list investgames-list">
    <a class="admin-list-click" href="<?php echo Yii::app()->createUrl('/publics/wcpublic/change',array('id'=>$data->id)); ?>">
        <div class="left admin-list-img">
            <?php
            CHtml::image(PublicStaticMethod::returnFile("public", $data->headimage, "", "headimage"))
            ?>
        </div>
        <div class="left admin-list-text investgames-list-text">
            <div class="admin-list-text-title">
                <?php echo CHtml::encode($data->title); ?>
                <span class="investgames-list-title-subscription">[<?php echo CHtml::encode(Yii::app()->params->PUBLICTYPE[$data->type]); ?>]</span>
            </div>
            <div class="admin-list-text-p investgames-list-text-p">
                微信号：<?php echo CHtml::encode($data->wechat); ?>
            </div>
        </div>
    </a>
    <div class="right admin-list-a">
        <?php echo CHtml::link('修改', array('update', 'id' => $data->id)); ?>
        |
        <?php echo CHtml::link('删除', array('delete', 'id' => $data->id)); ?>
    </div>
</div>
