<?php
/* @var $this MenuController */
/* @var $model Menu */
?>

<h1>修改菜单动作:<?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'action'=>$action)); ?>
