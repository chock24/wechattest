<div class="fodder mage-text" data-id='<?php echo $data->id ?>'>
    <div class="fodder-center">
        <h4>
            <?php echo PublicStaticMethod::truncate_utf8_string($data->title, 10); ?>
        </h4>
        <em class="fodder-date">
            <?php echo Yii::app()->format->formatDate($data->time_created); ?>
            <?php echo CHtml::checkBox('SourceFile[id][]', false, array('value' => $data->id, 'class' => 'right ie7margin-top20 options')); ?>
        </em>
        <div class="fodder-img mage-text-video">
            <?php /*echo CHtml::image(Yii::app()->baseUrl . '/weixin_image/del/getimgdata.jpg'); */?>
            <video src="<?php echo Yii::app()->baseUrl.'/upload/sourcefile/video/'.$data->filename.'.'.$data->ext?>" controls="controls">您的浏览器不支持 video 标签。</video>
        </div>
    </div>
    <div class="operation operation-fodder-h44">
        <ul>            
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-text" ></i>', array('update', 'id' => $data->id, 'type' => '4'), array('onclick' => 'js:return popup($(this), "修改视频信息", 450, 300);')); ?>
            </li>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-download"></i>', array('sourcefile/video', 'type' => '4', 'action' => 'dw', 'name' => @$data->filename)); ?>
            </li>
            <li class="left">
                <?php echo CHtml::link('<i class="icon icon-del"></i>', array('delete', 'id' => @$data->id, 'type' => '4')); ?>
            </li>
        </ul>
    </div>
</div>
<?php
if (@$_GET['action'] == 'dw') {
    $name = @$_GET['name'];
    $file = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/video/' . @$name . '.' . @$data->ext;
    $filename = @$name . '.' . @$data->ext;
    header("Content-Disposition: attachment; filename=" . ($filename));
   // readfile($file);
}
?>