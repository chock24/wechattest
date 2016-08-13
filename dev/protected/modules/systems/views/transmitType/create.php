<?php

/* @var $this TransmitTypeController */
/* @var $model TransmitType */

$this->breadcrumbs = array(
    'Transmit Types' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List TransmitType', 'url' => array('index')),
    array('label' => 'Manage TransmitType', 'url' => array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model' => $model, 'parent_id' => $parent_id)); ?>