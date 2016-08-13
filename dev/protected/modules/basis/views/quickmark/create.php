<?php
/* @var $this QuickmarkController */
/* @var $model Quickmark */

$this->breadcrumbs = array(
    '管理' => array('/basis'),
    '二维码管理' => array('admin'),
    '创建二维码',
);
?>

<div class="right content-main">

    <h2 class="content-main-title">创建二维码</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">
                <?php $this->renderPartial('_form', array('model' => $model)); ?>
            </div>
        </div>
    </div>

</div>
