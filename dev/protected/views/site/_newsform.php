<?php
/* @var $this WcpublicController */
/* @var $model WcPublic */
/* @var $form CActiveForm */
?>



<div class="form form-compile">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'news-form',
        'enableAjaxValidation'=>false,
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
    )); ?>

    <?php echo $form->errorSummary($model); ?>
	<div class="row form-compile-list">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
    <div class="row form-compile-list">
		<?php echo $form->labelEx($model,'type'); ?>
               	<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
    
       <div class="row form-compile-list">
		<?php echo $form->labelEx($model,'sort'); ?>
		<?php echo $form->textField($model,'sort',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'sort'); ?>
	</div>
         <div class="row form-compile-list">
           <?php echo $form->labelEx($model, 'content'); ?>
          
             <div style="width: 600px; overflow: hidden">
                 <?php echo $form->textArea($model, 'content'); ?>
                      <?php
                $this->widget('ext.ueditor.Ueditor', array(
                    'getId' => 'News_content',
                    'UEDITOR_HOME_URL' => "/",
                    'options' => '
                                        toolbars:[["fontfamily","fontsize","forecolor","bold","italic","underline","strikethrough","backcolor","removeformat","|","indent","|","justifyleft","justifycenter","justifyright","justifyjustify","|",
                "rowspacingtop","rowspacingbottom","lineheight","|","insertunorderedlist","insertorderedlist","blockquote","horizontal","|","insertvideo","insertimage","|",
                "link","unlink","highlightcode","|","undo","redo","source"]],
                                    wordCount:true,
                                    elementPathEnabled:false,
                                    initialContent:"",
                                    imageUrl:"' . Yii::app()->createUrl('/basis/sourcefile/imageupload') . '",
                                    imagePath:"",
                                    imageManagerUrl:"' . Yii::app()->createUrl('/basis/sourcefile/onlineimage') . '",
                                    imageManagerPath:"",
                                    ',
                ));
                ?>
                 
             </div>
        	<?php echo $form->error($model,'content'); ?>
	</div>
    	
	<div class="row form-compile-list buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '创建问题' : '保存修改',array('onclick'=>'js:return confirm("如果您当前未选择公众号，或者您修改了当前的公众号，您将会自动退出，修改设置即时生效。")','class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->