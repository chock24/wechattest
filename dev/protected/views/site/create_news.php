<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/index.css" rel="stylesheet" type="text/css" />

<div class="right content-main">
    <h2 class="content-main-title">创建系统公告</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">
                <div class="tabhost-center">
                    <?php $this->renderPartial('_newsform', array('model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>

</div>
                   
               