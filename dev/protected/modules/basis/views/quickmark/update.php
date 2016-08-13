<?php
/* @var $this QuickmarkController */
/* @var $model Quickmark */

$this->breadcrumbs=array(
	'管理'=>array('/basis'),
	'二维码管理'=>array('admin'),
        '修改二维码',
);

?>
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/member_home.css" rel="stylesheet" type="text/css" />

<div class="right content-main">
    <h2 class="content-main-title">修改ID为 <span class="color-red"><?php echo $model->id; ?></span> 的二维码</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">
                <?php $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>