<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs=array(
	'公众号中心'=>array('/publics'),
	'多客服管理'=>array('admin'),
        '创建客服',
);
?>

<h1>创建客服</h1>

<div class="message">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>