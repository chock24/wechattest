<!--单图文模块-->
<div class="news-item left option" data-id="<?php echo CHtml::encode($data->id); ?>" onclick="return checked($(this))">
    <p class="news-item-title"><?php echo CHtml::encode(PublicStaticMethod::truncate_utf8_string($data->title,5,'')); ?></p>
    <p class="news-item-date"><?php echo Yii::app()->format->formatDate($data->time_created); ?></p>
    <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($data->filename,$data->ext,'image', 'thumb'),$data->title,array('title'=>$data->title)); ?>
    <p class="news-item-description" title="<?php echo CHtml::encode($data->description); ?>"><?php echo CHtml::encode(PublicStaticMethod::truncate_utf8_string($data->description,10,'')); ?></p>
    <div class="checked-item"></div>
</div>