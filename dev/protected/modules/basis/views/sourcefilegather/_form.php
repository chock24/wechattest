<?php
/* @var $this SourceFileGatherController */
/* @var $model SourceFileGather */
/* @var $form CActiveForm */
?>

<div class="form">
    <div class="margin-top-15 text-center">
        <?php $type= Yii::app()->request->getparam('type');?>
        <?php $actionname =  $this->getAction()->getId();
        if ($actionname=='create'){

            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'source-file-gather-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'afterValidate'=>'js:function(form,data,hasError){
                                            if(!hasError){
                                             $.ajax({"type":"POST","url":"'.Yii::app()->createUrl('/basis/sourcefilegather/create',array('id'=>$model->id,'type'=>@$type)).'","data":$("#source-file-gather-form").serialize(),
                                            "success":function(data){
                                                    window.location.reload();
                                            }
                                    });
                            }
                            }'
                ),
            ));
        }else {

            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'source-file-gather-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'afterValidate'=>'js:function(form,data,hasError){
                                            if(!hasError){
                                             $.ajax({"type":"POST","url":"'.Yii::app()->createUrl('/basis/sourcefilegather/update',array('id'=>$model->id,'type'=>@$type)).'","data":$("#source-file-gather-form").serialize(),
                                            "success":function(data){
                                                    window.location.reload();
                                            }
                                    });
                            }
                            }'
                ),
            ));

        }
        ?>
        <?php ?>

        <!--

        <?php echo $form->errorSummary($model); ?>
            <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->labelEx($model,'public_id'); ?>
            <?php echo $form->textField($model,'public_id'); ?>
            <?php echo $form->error($model,'public_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'type'); ?>
            <?php echo $form->textField($model,'type'); ?>
            <?php echo $form->error($model,'type'); ?>
        </div>

        -->
        <div class="row padding30">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>25,'maxlength'=>25)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <!--<div class="row">
            <?php echo $form->labelEx($model,'count'); ?>
            <?php echo $form->textField($model,'count'); ?>
            <?php echo $form->error($model,'count'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'status'); ?>
            <?php echo $form->textField($model,'status'); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sort'); ?>
            <?php echo $form->textField($model,'sort'); ?>
            <?php echo $form->error($model,'sort'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'isdelete'); ?>
            <?php echo $form->textField($model,'isdelete'); ?>
            <?php echo $form->error($model,'isdelete'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'time_created'); ?>
            <?php echo $form->textField($model,'time_created'); ?>
            <?php echo $form->error($model,'time_created'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'time_updated'); ?>
            <?php echo $form->textField($model,'time_updated'); ?>
            <?php echo $form->error($model,'time_updated'); ?>
        </div>


	-->

        <div class="row buttons popup-footer">

            <?php
            $multi=Yii::app()->request->getParam('multi');
            if (empty($multi))
            {
                $multi=0;
            }
            echo $form->hiddenField($model,'multi'); ?>

            <?php echo CHtml::submitButton($model->isNewRecord ? '创  建' : '修  改',array('class'=>'button button-green')); ?>
            <input type="button" value="取消" name="yt1" class="closed button">
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $('#SourceFileGather_multi').attr('value',<?php echo @$multi;?>);
</script>