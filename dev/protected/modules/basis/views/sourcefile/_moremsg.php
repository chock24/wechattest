<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>


<?php $type= Yii::app()->request->getParam('type');?>

    <div class="more_img_txt_file">
        <div class="block_file_ct multi_map_psd">
            <h4 class="title img_text_tit"><a href="javascript:;"><?php echo CHtml::encode($data->title); ?></a></h4>
            <div class="more_img_txt_date">
                <em><?php echo CHtml::encode(date('Y-m-d H:i:s',$data->time_created)); ?></em>
            </div>
            <div class="move_img_txt_info">
                <a href="javascript:;" onclick="javascript:;">
                    <img id="<?php echo $data->id;?>" src="<?php echo Yii::app()->baseurl.'/upload/sourcefile/image/source/'.$data->filename.'.'.$data->ext?>">
                </a>
            </div>
            <p class="move_img_txt_desc"><?php echo CHtml::encode($data->description); ?></p>
        </div>
        <div class="tu_add"><a href="javascript:;" class="moreimg_icon" title="增加"></a></div>
    </div>
