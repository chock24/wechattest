<?php
/* @var $this SourceFileGatherController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Source File Gathers',
);

$this->menu=array(
	array('label'=>'Create SourceFileGather', 'url'=>array('create')),
	array('label'=>'Manage SourceFileGather', 'url'=>array('admin')),
);
?>



<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
