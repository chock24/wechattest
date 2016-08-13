<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>

<div class="block_file img_txt_file">
    <div class="img_txt_file_ct select-item <?php echo $data->id == $selectedId ? 'current' : ''; ?>" data-id="<?php echo CHtml::encode($data->id); ?>">
        <div class="img_txt_date">
            <em><?php echo CHtml::encode(date('Y-m-d', $data->time_created)); ?></em>
        </div>
        <div class="img_txt_file_ct">
            <a href="javascript:;" onclick="javascript:;">
                <?php
                if ($data->sourceDetail):
                    foreach ($data->sourceDetail as $key => $value) :
                        if (!$key) :
                ?>
                            <div class="voice_info video_info img_txt_info">
                                <?php echo @CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename,$value->sourceFile->ext,'image', 'thumb'),$value->sourceFile->title,array('title'=>$value->sourceFile->title)); ?>
                                <div class="img_txt_float" title="<?php echo CHtml::encode($data->title); ?>"><?php echo CHtml::encode($data->title); ?></div>
                            </div>
                        <?php else: ?>
                            <div class="img_txt_item">
                                <?php echo @CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename,$value->sourceFile->ext,'image', 'icon'),$value->sourceFile->title,array('title'=>$value->sourceFile->title,'class'=>'img_txt_thumb')); ?>
                                <h4 class="img_txt_tit"><?php echo @CHtml::encode($value->sourceFile->title); ?></h4>
                            </div>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </a>
        </div>
        <div class="sign"></div>
    </div>
</div>
