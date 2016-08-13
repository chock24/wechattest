<div class="fodder mage-text" data-id="<?php echo $data->id;?>">
    <div class="fodder-center">
        <h4>
            <?php echo CHtml::link(PublicStaticMethod::truncate_utf8_string($data->title,10),array('/site/view','id'=>$data->id),array('target'=>'_blank')); ?>
        </h4>
        <em class="fodder-date"><?php echo Yii::app()->format->formatDate($data->time_created); ?></em>
        <div class="fodder-img mage-text-img">
            <?php
                echo CHtml::link(CHtml::image(PublicStaticMethod::returnSourceFile($data->filename, $data->ext, 'image', 'medium')),array('/site/view','id'=>$data->id),array('target'=>'_blank'));
            ?>
            <i class="add-mage-text-img-background">亲，没有图片哦!</i>
        </div>
        <p class="fodder-introduce">
            <?php echo CHtml::checkBox('SourceFile[id][]',false,array('value'=>$data->id,'class'=>'margin-right-5 options')); ?>
            <?php echo PublicStaticMethod::truncate_utf8_string($data->description,10); ?>
        </p>
    </div>
    <div class="operation operation-fodder-h44">
        <ul>
            <li class="left">
                
                <a href="<?php echo Yii::app()->createUrl('basis/sourcefilegather/group',array('id'=>$data->id,'gather_id'=>'0','type'=>'5','multi'=>'0'));?>" onclick="js:return popup($(this), '移动单图文分组', 390, 190);"><i class="icon icon-move"></i></a>
            </li>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-text"></i>',array('updatemsg','id'=>$data->id)); ?>
            </li>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-del"></i>',array('delete','id'=>$data->id)); ?>
            </li>
        </ul>
    </div>
</div>