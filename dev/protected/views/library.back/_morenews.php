<?php if($data->sourceDetail): ?>
<!--多图文模块-->
<div class="more-news-item left option" data-id="<?php echo CHtml::encode($data->id); ?>" onclick="return checked($(this))">
    <?php foreach ($data->sourceDetail as $key => $value) : ?>
        <?php if(!$key)://如果是第一个单图文 ?>
            <div class="more-news-image cover">
                <?php echo @CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename,$value->sourceFile->ext,'image', 'thumb'),$value->sourceFile->title,array('title'=>$value->sourceFile->title)); ?>
                <p class="more-news-item-title">
                    <?php echo CHtml::encode(PublicStaticMethod::truncate_utf8_string($data->title,5,'')); ?>
                </p>
            </div>
        <?php else://其他单图文 ?>
            <div class="more-news-image item">
                <?php echo @CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename,$value->sourceFile->ext,'image', 'thumb'),$value->sourceFile->title,array('title'=>$value->sourceFile->title,'class'=>'right')); ?>
                <p class="more-news-item-title">
                    <?php echo @CHtml::encode(PublicStaticMethod::truncate_utf8_string($value->sourceFile->title,5,'')); ?>
                </p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="checked-item"></div>
</div>
<?php endif; ?>