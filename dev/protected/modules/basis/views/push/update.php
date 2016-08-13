<?php
/* @var $this PushController */
/* @var $model Push */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '群发功能',
    '群发消息 #'.$model->id,
);

?>

<h1>群发消息 <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'modelDataProvider'=>$modelDataProvider,'sourceFileDataProvider' => $sourceFileDataProvider, 'sourceFileGather'=>$sourceFileGather)); ?>