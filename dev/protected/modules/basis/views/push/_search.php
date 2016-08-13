<?php
/* @var $this PushController */
/* @var $model Push */
/* @var $form CActiveForm */
?>

<div class="margin-top-8">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="margin-top-5 left row">
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
                    'readonly'=>'readonly',
                    'maxlength' => 10,
                    'style'=>'margin:0; margin-right:5px;',
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
                    'readonly'=>'readonly',
                    'maxlength' => 10,
                    'style'=>'margin:0; margin-right:5px;',
                )
            ));
            ?>
    </div>

	<div class="margin-left-20 left row buttons">
		<?php echo CHtml::submitButton('确定搜索',array('class'=>'button')); ?>
	</div>
    <div class="clear"></div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->