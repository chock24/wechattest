<?php
/* @var $this GiftController */
/* @var $model Gift */


?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />
<?php $this->renderPartial('_form', array('model'=>$model,'trantype'=>$trantype)); ?>