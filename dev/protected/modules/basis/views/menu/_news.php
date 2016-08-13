<?php
/* @var $this SourcefileController */
/* @var $data SourceFile */
?>

<div class="view select-item left <?php echo $data->id==$selectedId?'current':''; ?>" data-id="<?php echo CHtml::encode($data->id); ?>" onclick="return selectItem($(this));">
    <h4 class="item-title" title="<?php echo CHtml::encode($data->title); ?>"><?php echo PublicStaticMethod::truncate_utf8_string($data->title, 10); ?></h4>
    <p class="item-date"><?php echo Yii::app()->format->formatDate($data->time_created); ?></p>
    <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($data->filename,$data->ext,'image', 'medium'),$data->title,array('title'=>$data->title)); ?>
    <p class="item-description" title="<?php echo CHtml::encode($data->description); ?>"><?php echo PublicStaticMethod::truncate_utf8_string($data->description, 10); ?></p>
    <div class="sign"></div>
</div>