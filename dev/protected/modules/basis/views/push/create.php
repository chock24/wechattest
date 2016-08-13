<?php
/* @var $this PushController */
/* @var $model Push */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '群发功能' => array('admin'),
    '群发信息',
);

?>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php elseif (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model,'groupDataProvider'=>$groupDataProvider,'modelDataProvider'=>$modelDataProvider,'sourceFileDataProvider' => $sourceFileDataProvider, 'sourceFileGather'=>$sourceFileGather)); ?>