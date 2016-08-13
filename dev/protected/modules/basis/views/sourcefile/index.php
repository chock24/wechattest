<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '管理' => array('/managers'),
    '素材管理',
);
?>

<h1>素材管理</h1>


<div class="span-100">
    <?php $this->renderpartial('header'); ?>
    <div class="message">
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view',
        ));
        ?>
    </div>
</div>

