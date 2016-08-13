<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>

<div class="view select-item left <?php echo $data->id==$selectedId?'current':''; ?>" data-id="<?php echo CHtml::encode($data->id); ?>" onclick="return selectItem($(this));">
    <p class="item-date"><?php echo Yii::app()->format->formatDate($data->time_created); ?></p>
    <?php
    if ($data->sourceDetail):
        foreach ($data->sourceDetail as $key => $value) :
            if (!$key) :
                ?>
                <div class="children-item first-item">
                    <?php echo @CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'thumb'), $value->sourceFile->title, array('title' => $value->sourceFile->title)); ?>
                    <p class="item-title" title="<?php echo CHtml::encode($data->title); ?>"><?php echo PublicStaticMethod::truncate_utf8_string($data->title, 10); ?></p>
                </div>
            <?php else: ?>
                <div class="img_txt_item">
                    <div class="children-item other-item">
                        <?php echo @CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'icon'), $value->sourceFile->title, array('title' => $value->sourceFile->title, 'class' => 'right')); ?>
                        <p class="item-title left" title="<?php echo CHtml::encode($value->sourceFile->title); ?>"><?php echo PublicStaticMethod::truncate_utf8_string($value->sourceFile->title, 10); ?></p>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php
            endif;
        endforeach;
    endif;
    ?>
    <div class="sign"></div>
</div>