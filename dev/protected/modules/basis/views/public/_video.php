<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>

 <div class="block_file img_file">
    <div class="block_file_ct img_file_ct">
        <div class="video_info select-item <?php echo $data->id==$selectedId?'current':''; ?>" data-id="<?php echo CHtml::encode($data->id); ?>" style="margin: 0;">
            <h4 style="margin: 0;padding: 3px;color: #666;">会尽快</h4>
            <?php echo CHtml::image(Yii::app()->baseUrl.'/images/video_slt.jpg',$data->title,array('title'=>$data->title,'style'=>'width:200px;height:125px;')); ?>
            <div class="sign"></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
 
