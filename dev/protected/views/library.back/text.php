<hr />
<h4>文本内容：</h4>

<div class="form">
    <div class="row">
        <?php echo $form->textArea($model,'content',array('id'=>'operationText','rows' => 10, 'cols' => 80)); ?>
        <?php echo $form->error($model,'content'); ?>
        <p><span class="emotion">表情</span></p>
    </div>
</div>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/reset.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.qqFace.js");

Yii::app()->clientScript->registerScript('qqfaceInput', "	
    $('.emotion').qqFace({
        id: 'facebox',
        assign: 'operationText',
        path: '" . Yii::app()->baseUrl . "/images/arclist/',
    });
");
?>