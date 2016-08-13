<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerCss('checkbox', "		
	.checkboxarea{padding:1px;border:1px solid #a9a9a9;}
	.checkboxarea label{	display:inline;}
	.checkboxarea .firstbox{border-bottom:1px solid #E0E0E0;background:#F4F4F4;font-size:14px;padding:0 0 0 5px;margin-bottom:5px;color:#1670a7;}
	.checkboxarea .firstbox input{margin-bottom:4px;}
	.checkboxarea .group{float:left;width:200px;padding-left:5px;}			
");
?>




<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row user-control-seek-list">
        <div class="left margin-right-15">
            <?php echo $form->label($model, 'nickname'); ?>
            <?php echo $form->textField($model, 'nickname', array('maxlength' => 55, 'placeholder' => '微信昵称')); ?>
        </div>

            <?php //echo $form->textField($model, 'remark', array('maxlength' => 55, 'placeholder' => '备注名')); ?>
      
        <div class="left margin-top-8">
            <?php echo $form->label($model, 'star'); ?>
            <?php echo $form->dropDownList($model, 'star', Yii::app()->params->WHETHER, array('prompt' => '请选择')); ?>
        </div>
    </div>

    <div class="row user-control-seek-list">
        <div class="group-title">
            <?php echo $form->labelEx($model, 'group_id'); ?>
            <?php echo $form->checkBoxList($model, 'group_id', $this->groupArr, array('checkAll' => '全选/不选', 'separator' => '</div><div class="group">')); ?>
        </div>
        <?php echo $form->error($model, 'group_id'); ?>
    </div>

    <div class="row user-control-seek-list">
        <div class="group-title">
            <?php echo $form->labelEx($model, 'sex'); ?>
            <?php echo $form->checkBoxList($model, 'sex', Yii::app()->params->SEX, array('checkAll' => '全选/不选', 'separator' => '</div><div class="group">')); ?>
        </div>
        <?php echo $form->error($model, 'sex'); ?>
    </div>

    <div class="row user-control-seek-list user-control-seek-show-hide">
        <div class="group-title">
            <a href="javascript:;" class="right margin-right-15 user-control-seek-show-hide-more">更多>></a>
            <?php echo $form->labelEx($model, 'province'); ?>
            <?php echo $form->checkBoxList($model, 'province', CHtml::listData($this->getProvinceArr(), 'id', 'name'), array('checkAll' => '全选/不选', 'separator' => '</div><div class="group">')); ?>
        </div>
        <?php echo $form->error($model, 'province'); ?>
    </div>

    <div class="margin-top-8 row buttons">
        <?php echo CHtml::submitButton('筛选', array('class' => 'button web-menu-btn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->

<script type="text/javascript">
    $(function () {
        $(".user-control-seek-show-hide-more").toggle(
                function () {
                    $(this).html('收起^');
                    $(this).parent().parent().css('height', 'auto');
                },
                function () {
                    $(this).html('更多>>');
                    $(this).parent().parent().css('height', '71');
                }
        );
//        $('#User_nickname').blur(function(){
//            $('#User_remark').val($(this).val());
//        });
    })
</script>