<div class="fodder mage-voice" data-id='<?php echo @$data->id; ?>'>
    
    <div class="fodder-center" data-id='<?php echo @$data->id; ?>'>
        <div class="fodder-img mage-voice-img">
            <embed src="<?php echo Yii::app()->baseUrl.'/upload/sourcefile/voice/'.$data->filename.'.'.$data->ext?>" autostart="false" name="voi"></embed>
        </div>
        <div class="mage-voice-introduce">
            <h4>
                <?php echo CHtml::checkBox('SourceFile[id][]',false,array('value'=>@$data->id,'class'=>'ie7margin-top20 options')); ?>
                <?php echo PublicStaticMethod::truncate_utf8_string(@$data->title,10); ?>
            </h4>
            
            <div class="mage-voice-size"><?php echo CHtml::encode(@$data->size); ?></div>
        </div>
    </div>
    <div class="operation operation-fodder-h30">
        <ul>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-download"></i>',array('sourcefile/index','type'=>'3','action'=>'dw','name'=>@$data->filename)); ?>
                 
            </li>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-text" ></i>',array('update','id'=>$data->id,'type'=>'3'), array('onclick'=>'js:return popup($(this), "修改音频信息", 420, 180);')); ?>
            </li>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-del"></i>',array('delete','id'=>@$data->id,'type'=>'3')); ?>
                
            </li>
        </ul>
    </div>
</div>