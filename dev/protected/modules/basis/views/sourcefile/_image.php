<div class="fodder mage-img" data-id=<?php echo $data->id; ?>>
    <div class="fodder-center mage-img-center">
        <div class="fodder-img mage-img-img">
            <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($data->filename, $data->ext, 'image', 'thumb')); ?>
        </div>
        <label class="mage-img-label">
            <?php echo CHtml::checkBox('SourceFile[id][]',false,array('value'=>$data->id,'class'=>'margin-right-5 options')); ?>
            <?php echo PublicStaticMethod::truncate_utf8_string($data->title,10); ?>
        </label>
    </div>
    <div class="operation operation-fodder-h30">
        <ul>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-move"></i>',array('sourcefilegather/group','id'=>$data->id,'type'=>'2'),array('onclick'=>'js:return popup($(this), "修改分组", 390, 175);')); ?>
            </li>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-text" ></i>',array('update','id'=>$data->id,'type'=>'2'), array('onclick'=>'js:return popup($(this), "修改图片标题", 390, 175);')); ?>
            </li>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-del"></i>',array('delete','id'=>$data->id,'type'=>'2','class'=>'del-mage-img')); ?>
            </li>
        </ul>
    </div>
</div>