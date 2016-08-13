<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <!--<div class="row">
    <?php echo $form->label($model, 'star'); ?>
    <?php echo $form->dropDownList($model, 'star', Yii::app()->params->WHETHER, array('prompt' => '请选择')); ?>
    </div>-->

    <select class="margin-right-15 left box-select" id="message-date">
        <option value="0">请选择</option>
        <option value="3" selected = "selected">今天</option>
        <option value="4">昨天</option>
        <option value="5">前天</option>
        <option value="2">最近五天</option>
        <option value="1">30天内</option>
        <option value="6">更早</option>
    </select>

    <div class="margin-right-15 margin-left-20 left row">
        <?php echo $form->label($model, 'content'); ?>
        <?php echo $form->textField($model, 'content', array('size' => 30, 'maxlength' => 55, 'placeholder' => '只能搜索文字消息')); ?>
        <!--<span>* 只能搜索文字消息</span>-->
    </div>

    <div class="left margin-left-20 margin-right-15 row">
        <?php echo $form->label($model, 'createtime'); ?>
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

    <div class="left margin-left-20 row buttons">
        <?php echo CHtml::submitButton('确认搜索', array('class' => 'button')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- search-form -->