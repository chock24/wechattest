<?php
/* @var $this ReplyController */
/* @var $model Reply */

$this->breadcrumbs=array(
	'基础功能'=>array('/basis'),
	'Create',
);

?>

<h1>回复内容</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>