<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/login.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php $this->renderPartial('//layouts/header'); ?>
    
    <?php echo $content; ?>

    <?php $this->renderPartial('//layouts/footer'); ?>
</body>
</html>
