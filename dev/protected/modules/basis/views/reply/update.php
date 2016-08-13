<?php
/* @var $this ReplyController */
/* @var $model Reply */

$this->breadcrumbs=array(
	'Replies'=>array('index'),
	
	'Update',
);

$this->menu=array(
	array('label'=>'List Reply', 'url'=>array('index')),
	array('label'=>'Create Reply', 'url'=>array('create')),
	array('label'=>'View Reply', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Reply', 'url'=>array('admin')),
);
?>

<!--<h1>Update Reply <?php /*echo $model->id; */?></h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>