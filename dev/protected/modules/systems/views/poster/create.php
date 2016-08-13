<?php

/* @var $this TransmitController */
/* @var $model Transmit */

$this->breadcrumbs = array(
    'Transmits' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Transmit', 'url' => array('index')),
    array('label' => 'Manage Transmit', 'url' => array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model' => $model,'postertype'=>$postertype)); ?>