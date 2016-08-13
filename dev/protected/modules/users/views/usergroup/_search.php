<?php
/* @var $this UsergroupController */
/* @var $model UserGroup */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>



    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 55, 'maxlength' => 55)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'time_created'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language' => 'zh_cn',
            'model' => $model,
            'attribute' => 'time_start',
            'options' => array(
                'showOn' => 'button', // 'focus', 'button', 'both'  
                'buttonImage' => Yii::app()->request->baseUrl . '/images/cal.png',
                'buttonImageOnly' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'mode' => 'datetime',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'maxlength' => 10,
                'style' => 'margin:0; margin-right:5px;',
            )
        ));
        ?>

        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language' => 'zh_cn',
            'model' => $model,
            'attribute' => 'time_end',
            'options' => array(
                'showOn' => 'button', // 'focus', 'button', 'both'  
                'buttonImage' => Yii::app()->request->baseUrl . '/images/cal.png',
                'buttonImageOnly' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'mode' => 'datetime',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'maxlength' => 10,
                'style' => 'margin:0; margin-right:5px;',
            )
        ));
        ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('确认搜索'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->