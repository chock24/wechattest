<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>
<div class="block_file img_file">
    <div class="block_file_ct img_file_ct">
        <div class="img_info select-item <?php echo $data->id==$selectedId?'current':''; ?>" data-id="<?php echo CHtml::encode($data->id); ?>">
            <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($data->filename,$data->ext,'image', 'source'),$data->title,array('title'=>$data->title)); ?>
            <div class="sign"></div>
        </div>
    </div>
</div>
 