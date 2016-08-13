<?php
/* @var $this UsergroupController */
/* @var $model UserGroup */


$this->breadcrumbs = array(
    '管理' => array('/users'),
    '用户分组管理' => array('admin'),
    '修改用户分组',
);
?>

<!--<h1>修改用户分组 <?php /* echo $model->id; */ ?></h1>-->

<?php $this->renderPartial('_form', array('model' => $model)); ?>