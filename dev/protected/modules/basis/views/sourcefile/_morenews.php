<?php if ($data->sourceDetail)://如果存在素材细节    ?>

    <div class="fodder mage-text">
        <?php foreach ($data->sourceDetail as $key => $value)://循环素材细节 ?>
            <?php if ($key == 0)://如果是第一个单图文 ?>
                <div class="fodder-center">
                    <em class="fodder-date">
                        <?php echo Yii::app()->format->formatDate($data->time_created); ?>
                        <?php echo CHtml::checkBox('SourceFile[id][]', false, array('value' => $data->id, 'class' => 'right ie7margin-top20 options')); ?>
                    </em>
                    <div class="relative fodder-img mage-text-img">
                        <?php
                        echo @CHtml::link(CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium')), array('/site/view', 'id' => $value->sourceFile->id), array('target' => '_blank'));
                        ?>
                        <i class="add-mage-text-img-background">亲，没有图片哦!</i>
                        <div class="mage-text-img-title">
                            
                            <?php echo CHtml::link(PublicStaticMethod::truncate_utf8_string(@$value->sourceFile->title, 10), array('/site/view', 'id' => @$value->sourceFile->id), array('target' => '_blank', 'title' => $data->title)); ?>
                        </div>
                    </div>
                </div>
            <?php else://如果不是第一个单图文 ?>
                <div class="mage-text-more">
                    <h4 class="left">
                        <?php echo CHtml::link(PublicStaticMethod::truncate_utf8_string(@$value->sourceFile->title, 10), array('/site/view', 'id' => @$value->sourceFile->id), array('target' => '_blank', 'title' => @$value->sourceFile->title)); ?>
                    </h4>
                    <div class="right mage-text-more-img">
                        <?php
                        echo @CHtml::link(CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium')), array('/site/view', 'id' => $value->sourceFile->id), array('target' => '_blank'));
                        ?>
                        <i class="add-mage-text-img-background">暂无图!</i>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; //结束素材细节循环 ?>
        <div class="mage-text-more-pulldown">&or;</div>

        <div class="operation operation-fodder-h44">
            <ul>
                <li class="left">

                    <a href="<?php echo Yii::app()->createUrl('basis/sourcefilegather/group', array('id' => $data->id, 'gather_id' => '0', 'type' => '5', 'multi' => '1')); ?>" onclick="js:return popup($(this), '移动多图文分组', 390, 190);">
                        <i class="icon icon-move"></i></a>

                </li>
                <li class="left">
                    <?php echo CHtml::link('<i class="icon icon-text"></i>', array('moremsg', 'id' => $data->id)); ?>
                </li>
                <li class="left">
                    <?php echo CHtml::link('<i class="icon icon-del"></i>', array('delete', 'id' => $data->id,'type'=>'sourcefilegroup')); ?>
                </li>
            </ul>
        </div>
    </div>
<?php endif; ?>
    