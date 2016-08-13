<?php
/* @var $this CouponController */
/* @var $model Coupon */

$this->breadcrumbs=array(
	'Coupons'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Coupon', 'url'=>array('index')),
	array('label'=>'Create Coupon', 'url'=>array('create')),
	array('label'=>'View Coupon', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Coupon', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>