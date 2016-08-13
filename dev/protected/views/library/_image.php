<!--<div class="relative popup-fodder popup-fodder-teletext" data-id="<?php /*echo CHtml::encode($data->id); */?>" data-multi="0" data-type="5" onclick="return popupSelect($(this),$('#select-result'));">
 
    <div class="popup-fodder-center">
        <h4><?php /*echo PublicStaticMethod::truncate_utf8_string($data->title,10); */?></h4>
        <div class="popup-fodder-img popup-fodder-img-teletext">
            <?php /*echo CHtml::image(PublicStaticMethod::returnFile('sourcefile', $data->filename, $data->ext, 'image', 'medium')) */?>
        </div>
        <p class="popup-fodder-introduce"><?php /*echo PublicStaticMethod::truncate_utf8_string($data->description,10); */?></p>
    </div>
    <div class="none popup-selected">
        <i class="icon-50 icon-50-icon-50-ok"></i>
        <div class="popup-selected-bj"></div>
    </div>
</div>-->

<!-- <div class="popup-fodder popup-fodder-mage-img" data-id="<?php //echo CHtml::encode($data->filename.".".$data->ext); ?>" data-multi="0" data-type="2" onclick="return popupSelect($(this),$('#select-result'));">-->
     <div class="popup-fodder popup-fodder-mage-img" data-id="<?php echo CHtml::encode($data->id); ?>" data-multi="0" data-type="2" onclick="return popupSelect($(this),$('#select-result'));">
    <div class="popup-fodder-center popup-fodder-mage-img-center">
        <div class="popup-fodder-img popup-fodder-mage-img-img">
            <?php echo CHtml::image(PublicStaticMethod::returnFile('sourcefile', $data->filename, $data->ext, 'image', 'medium')) ?>
        </div>
        <div class="popup-fodder-introduce"><?php echo PublicStaticMethod::truncate_utf8_string($data->title,10); ?></div>
    </div>
    <div class="none popup-selected">
        <i class="icon-50 icon-50-icon-50-ok"></i>
        <div class="popup-selected-bj"></div>
    </div>
</div>