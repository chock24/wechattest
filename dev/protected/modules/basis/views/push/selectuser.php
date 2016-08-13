<?php
/* @var $this PushController */
/* @var $model Push */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '群发功能' => array('/basis/push/admin'),
    '群发消息',
);
?>

<h1>选择用户/用户组</h1>

<div class="span-100">
    <div class="message-menu">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => '全部用户', 'url' => array('selectuser', 'genre' => 1), 'active' => Yii::app()->request->getParam('genre') == 1),
                array('label' => '选择用户组', 'url' => array('selectuser', 'genre' => 2), 'active' => Yii::app()->request->getParam('genre') == 2),
            ),
        ));
        ?>
        <div class="clear"></div>
    </div><!-- mainmenu -->

    <div class="message">
        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'auto-form',
                'action' => array('create'),
                'method' => 'get',
                'enableAjaxValidation' => false,
            ));
            ?>

            <!--<div class="row">
            <?php echo $form->label($model, 'timing'); ?>
            <?php echo $form->checkbox($model, 'timing'); ?>
            <?php echo $form->error($model, 'timing'); ?>
            </div>

            <div class="row">
            <?php echo $form->label($model, 'time_action'); ?>
            <?php echo $form->textField($model, 'time_action'); ?>
            <?php echo $form->error($model, 'time_action'); ?>
            </div>-->

            <?php if (Yii::app()->request->getParam('genre') == 2): ?>
                <div class="row">
                    <?php echo $form->label($model, 'group_id'); ?>
                    <?php echo $form->dropDownList($model, 'group_id',$dataProvider); ?>
                    <?php echo $form->error($model, 'group_id'); ?>
                </div>
            
                <div class="row">
                    <?php echo $form->label($model, 'sex'); ?>
                    <?php echo $form->dropDownList($model, 'sex',Yii::app()->params->SEX); ?>
                    <?php echo $form->error($model, 'sex'); ?>
                </div>
            
                <div class="row">
                    <?php echo $form->label($model, 'province'); ?>
                    <?php echo $form->dropDownList($model, 'province', $this->actionDistrict(), array('prompt' => '请选择','class'=>'select-district-province')); ?>
                    <?php echo $form->error($model, 'province'); ?>
                </div>
            
                <div class="row">
                    <?php echo $form->label($model, 'city'); ?>
                    <?php echo $form->dropDownList($model, 'city', array(), array('prompt' => '请选择','class'=>'select-district-city')); ?>
                    <?php echo $form->error($model, 'city'); ?>
                </div>
                
            <?php endif; ?>

            <div class="row">
                <?php echo $form->label($model, 'remark'); ?>
                <?php echo $form->textArea($model, 'remark', array('rows' => 5, 'cols' => 53, 'maxlength'=>255)); ?>
                <?php echo $form->error($model, 'remark'); ?>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('选择内容'); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('district', "
    $('.select-district-province').change(function(){
        var parent_id = $(this).val();
        $('.select-district-city').html('<option value>请选择</option>');
        $.getJSON('".Yii::app()->createUrl('/basis/push/district')."',{parent_id:parent_id,type:1},function(data){
            $.each(data, function(i,item){
                $('.select-district-city').append('<option value=\"'+i+'\">'+item+'</option>');
            });
        });
    })
");
?>