<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/common.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/fodder.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/popup.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/weixin_js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/weixin_js/laydate/laydate.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/weixin_js/common.js" type="text/javascript"></script>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php
        Yii::app()->clientScript->registerMetaTag('keywords', '关键字');
        Yii::app()->clientScript->registerMetaTag('description', '描述');
        Yii::app()->clientScript->registerMetaTag('author', '作者');
        ?>
    </head>

    <body>
        <div class="background-white content popup-fileupdate">
            <?php echo $content; ?>
        </div>
        <!--弹出框-->
        <div class="none popup">
            <div class="popup-background"></div>
            <div class="popup-content">
                <div class="popup-title">
                    <h3></h3>
                    <a class="closed icon-16 icon-16-close" href="javascript:;"></a>
                </div>
                <div class="popup-data">

                </div>
            </div>
        </div>

    </body>
</html>
<script src="<?php echo Yii::app()->baseUrl; ?>/weixin_js/jquery.cookie.js" type="text/javascript"></script>