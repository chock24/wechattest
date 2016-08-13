<?php if (isset($data->sourceDetail))://如果存在素材细节 ?>
    <div class="popup-fodder popup-fodder-teletext" data-id="<?php echo CHtml::encode($data->id); ?>" data-multi="1" data-type="5" onclick="return popupSelect($(this),$('#select-result'));">
        <?php foreach ($data->sourceDetail as $key => $value)://循环素材细节 ?>

            <?php if ($key == 0)://如果是第一个单图文 ?>
                <div class="popup-fodder-center">
                    <div class="popup-fodder-img popup-fodder-img-teletext">
                        <?php echo @CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium')); ?>
                    </div>
                    <div class="popup-fodder-mage-text-img-title">
                        <?php echo @CHtml::encode(PublicStaticMethod::truncate_utf8_string($value->sourceFile->title, 10), array('title' => $data->title)); ?>
                    </div>
                </div>
            <?php else://如果不是第一个单图文 ?>
                <div class="popup-fodder-mage-text-more">
                    <h4 class="left">
                        <?php echo @CHtml::encode(PublicStaticMethod::truncate_utf8_string($value->sourceFile->title, 10), array('title' => $value->sourceFile->title)); ?>
                    </h4>
                    <div class="right popup-fodder-mage-text-more-img">
                        <?php
                        echo @CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium'));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; //结束素材细节循环 ?>
        <div class="none popup-selected">
            <i class="icon-50 icon-50-icon-50-ok"></i>
            <div class="popup-selected-bj"></div>
        </div>
    </div>
<?php endif; ?>
