<?php

/* @var $this UsergroupController */
/* @var $model UserGroup */

$this->breadcrumbs = array(
    '管理' => array('/users'),
    '用户分组管理' => array('admin'),
    '创建用户分组',
);
?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>