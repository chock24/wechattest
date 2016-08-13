<li class="index-affiche-list">
    <a href="<?php echo Yii::app()->createUrl('publics/wcpublic/public_news',array('id'=>$data->id)) ?>">
        <strong><?php echo CHtml::encode($data->title) ?>   </strong>
    </a>
    <a href="<?php echo Yii::app()->createUrl('publics/wcpublic/deletenews',array('id'=>$data->id));?>" title="删除" class="right margin-top-10 del"><i class="icon icon-del"></i></a>
    <a href="<?php echo Yii::app()->createUrl('publics/wcpublic/updatenews',array('id'=>$data->id));?>" title="编辑" class="right margin-top-10 margin-left-20"><i class="icon icon-text"></i></a>
    <span class="right margin-right-15 color-9">
        <?php echo Yii::app()->format->formatDate($data->time_created); ?>
    </span>
</li>