<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>
<div class="block_file img_txt_file">
    <div class="block_file_ct img_txt_file_ct select-item <?php echo $data->id==$selectedId?'current':''; ?>" data-id="<?php echo CHtml::encode($data->id); ?>">
        <h4 class="title img_txt_tit"><?php echo CHtml::encode($data->title); ?></h4>
        <div class="img_txt_date">
            <em><?php echo CHtml::encode(date('Y-m-d',$data->time_created)); ?></em>
        </div>
        <div class="img_txt_info">
            <a href="javascript:;" onclick="javascript:;" >
                <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($data->filename,$data->ext,'image', 'thumb'),$data->title,array('title'=>$data->title,'id'=>$data->id)); ?>
            </a>
        </div>
        <p class="img_text_desc"><?php echo CHtml::encode($data->description); ?></p>
        <div class="sign"></div>
    </div>
</div>
