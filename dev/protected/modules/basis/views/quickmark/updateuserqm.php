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

    <h2 class="content-main-title">修改所有用户自动生成二维码分组</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">


                <?php
                /* @var $this QuickmarkController */
                /* @var $model Quickmark */
                /* @var $form CActiveForm */
                ?>

                <div class="padding10 form form-compile">

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'quickmark-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'enableAjaxValidation' => false,
                    ));
                    ?>

                    <?php echo $form->errorSummary($model); ?>

                    <div class="row form-compile-list">
                        <?php echo $form->labelEx($model, 'group_id'); ?>
                        <?php echo $form->dropDownList($model, 'group_id', $this->userGroup(), array('class' => 'margin-top-5')); ?>
                        <?php echo $form->error($model, 'group_id'); ?>
                    </div>
                    <div class="row form-compile-list buttons">
                        <?php echo CHtml::submitButton('修改分组', array('class' => 'button')); ?>
                    </div>

                    <?php $this->endWidget(); ?>

                </div><!-- form -->




            </div>
        </div>
    </div>

</div>
