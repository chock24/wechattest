<div class="right content-main">
    <h2 class="content-main-title">
        <?php if (Yii::app()->request->getParam('type') == 2): ?>
            图片库
        <?php elseif (Yii::app()->request->getParam('type') == 3): ?>
            音频库
        <?php elseif (Yii::app()->request->getParam('type') == 4): ?>
            视频库
        <?php elseif (Yii::app()->request->getParam('type') == 5): ?>
            图文库
        <?php endif; ?>
    </h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <ul>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 5 && Yii::app()->request->getParam('multi') == 0 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('单图文库', array('news')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 5 && Yii::app()->request->getParam('multi') == 1 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('多图文库', array('morenews')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 2 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('图片库', array('image')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 3 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('音频库', array('voice')); ?>
                    </li>
                    <li class="<?php echo Yii::app()->request->getParam('type') == 4 ? 'active' : ''; ?>">
                        <?php echo CHtml::link('视频库', array('video')); ?>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">
                <?php if (Yii::app()->request->getParam('type') == 2) { ?>
                    <?php
                    $this->renderPartial('_image_form', array(
                        'model' => $model,
                        'sourceFileGather' => $sourceFileGather,
                    ));
                    ?>
                <?php } ?>
                <?php if (Yii::app()->request->getParam('type') == 3) { ?>
                    <?php
                    $this->renderPartial('_voice_form', array(
                        'model' => $model,
                        'sourceFileGather' => $sourceFileGather,
                    ));
                    ?>
                <?php } ?>
                <?php if (Yii::app()->request->getParam('type') == 4) { ?>
                    <?php
                    $this->renderPartial('_video_form', array(
                        'model' => $model,
                        'sourceFileGather' => $sourceFileGather,
                    ));
                    ?>
                <?php } ?>
                <?php if (Yii::app()->request->getParam('type') == 5) { ?>
                    <?php if (Yii::app()->request->getParam('multi') == 1) { ?>
                        <?php
                        $this->renderPartial('_morenews_form', array(
                            'model' => $model,
                        ));
                        ?>
                    <?php } else { ?>           
                        <?php
                        $this->renderPartial('_news_form', array(
                            'model' => $model,
                        ));
                        ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

