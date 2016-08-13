<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - 出错啦';
?>

<div class="background-white content">

    <div class="padding30">
        <div class="error-figure">
            <div class="error-figure-content">
                <!--<img src="<?php /*echo Yii::app()->baseUrl; */?>/weixin_image/404.png" alt=""  />-->
                <div class="error-figure-text"><?php echo $code; ?></div>
                <p><?php echo CHtml::encode($message); ?></p>

                <div class="margin-top-15 padding30 text-center">
                    <?php echo CHtml::link('返回首页', Yii::app()->homeUrl,array('class'=>'button button-white')); ?>
                </div>
            </div>
        </div>

    </div>


</div>
