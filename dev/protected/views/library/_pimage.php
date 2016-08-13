
<div class="popup-fodder popup-fodder-mage-img" data-id="<?php echo CHtml::encode($data->img_url); ?>" data-multi="0" data-type="2" onclick="return popupSelect($(this),$('#select-result'));">
    <div class="popup-fodder-center popup-fodder-mage-img-center">
        <div class="popup-fodder-img popup-fodder-mage-img-img">
            <?php $imageurl=Yii::app()->params->WEBROOT . Yii::app()->params->FILEFOLDER . Yii::app()->params->FILEPATH['sourcefile']['image']['poster'].$data->img_url ?>
            <?php echo CHtml::image($imageurl,'',array('width'=>'100px')) ?>
</div>
</div>
<div class="none popup-selected">
    <i class="icon-50 icon-50-icon-50-ok"></i>
    <div class="popup-selected-bj"></div>
</div>
</div>