<?php
/* @var $this SourcefileController */
/* @var $model SourceFile */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'source-file-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                                        if(!hasError){
                                         $.ajax({"type":"POST","url":"' . Yii::app()->createUrl('/basis/sourcefile/update', array('id' => $model->id)) . '","data":$("#source-file-form").serialize(),
                                        "success":function(data){				
                                                window.location.reload();
                                        }
                                });
                        }
                        }'
        ),
    ));
    ?>


    <?php echo $form->errorSummary($model); ?>
    <?php
    $type = Yii::app()->request->getParam('type');
    if ($type == '3') {
        ?>
        <div class="padding10 text-center">
            <div class="margin-top-15 row">
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title'); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
            <!--<div class="margin-top-10 row">
                <?php /*echo $form->labelEx($model, 'length'); */?>
                <?php /*echo $form->textField($model, 'length'); */?>
                <?php /*echo $form->error($model, 'length'); */?>
            </div>-->

            <div class="margin-top-10 row">
                <label for="SourceFile_length">选择分组</label>

                <select data-val="" name="gather_id" class="box-select">
                    <?php
                    if (!empty($sourceFileGather)) {
                        foreach ($sourceFileGather as $s) {
                            ?>
                            <option <?php
                            if (!empty($model->gather_id)) {
                                if ($model->gather_id == $s->id) {
                                    echo 'selected';
                                }
                            }
                            ?> value="<?php echo $s->id; ?>"><?php echo $s->name; ?></option>
                                <?php
                            }
                        }
                        ?>
                </select>
            </div>
        </div>


    <?php } else if ($type == '4') { ?>
        <div class="padding20">

            <div class="margin-left-20 row">
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title'); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
            <!--<div class="margin-top-10 margin-left-20 row">
                <?php /*echo $form->labelEx($model, 'length'); */?>
                <?php /*echo $form->textField($model, 'length'); */?>
                <?php /*echo $form->error($model, 'length'); */?>
            </div>-->
            <div class="margin-top-10 margin-left-20 row">
                <?php echo $form->labelEx($model, 'description',array('class'=>'margin-right-5 left')); ?>
                <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>

            <div class="margin-top-10 margin-left-20 row">
                <label for="SourceFile_length">选择分组</label>

                <select data-val="" name="gather_id" class="margin-top-5 box-select">
                    <?php
                    if (!empty($sourceFileGather)) {
                        foreach ($sourceFileGather as $s) {
                            ?>
                            <option <?php
                            if (!empty($model->gather_id)) {
                                if ($model->gather_id == $s->id) {
                                    echo 'selected';
                                }
                            }
                            ?> value="<?php echo $s->id; ?>"><?php echo $s->name; ?></option>
                                <?php
                            }
                        }
                        ?>
                </select>
            </div>
        </div>
    <?php } else if ($type == '2') { ?>
        <div class="row margin-top-15 padding20 text-center">
            <div>
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title'); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
            <div class="margin-top-10row">
                <label for="SourceFile_length">选择分组</label>

                <select data-val="" name="gather_id" class="margin-top-5 box-select">
                    <?php
                    if (!empty($sourceFileGather)) {
                        foreach ($sourceFileGather as $s) {
                            ?>
                            <option <?php
                            if (!empty($model->gather_id)) {
                                if ($model->gather_id == $s->id) {
                                    echo 'selected';
                                }
                            }
                            ?> value="<?php echo $s->id; ?>"><?php echo $s->name; ?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

    <?php } else { ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'show_content'); ?>
            <?php echo $form->textField($model, 'show_content'); ?>
            <?php echo $form->error($model, 'show_content'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'content'); ?>
            <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'content'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'content_source_url'); ?>
            <?php echo $form->textField($model, 'content_source_url', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'content_source_url'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'path'); ?>
            <?php echo $form->textField($model, 'path', array('size' => 60, 'maxlength' => 200)); ?>
            <?php echo $form->error($model, 'path'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'ext'); ?>
            <?php echo $form->textField($model, 'ext', array('size' => 40, 'maxlength' => 40)); ?>
            <?php echo $form->error($model, 'ext'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'size'); ?>
            <?php echo $form->textField($model, 'size', array('size' => 20, 'maxlength' => 20)); ?>
            <?php echo $form->error($model, 'size'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->textField($model, 'status'); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'sort'); ?>
            <?php echo $form->textField($model, 'sort'); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'isdelete'); ?>
            <?php echo $form->textField($model, 'isdelete'); ?>
            <?php echo $form->error($model, 'isdelete'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'time_created'); ?>
            <?php echo $form->textField($model, 'time_created'); ?>
            <?php echo $form->error($model, 'time_created'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'time_updated'); ?>
            <?php echo $form->textField($model, 'time_updated'); ?>
            <?php echo $form->error($model, 'time_updated'); ?>
        </div>
    <?php } ?>
    <div class="row buttons popup-footer">
        <?php echo $form->hiddenField($model, 'gather_id'); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : '修  改', array('class' => 'button button-green')); ?>
        <input type="button" class="closed button" name="yt1" value="取消">
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(function () {
        //获得新增音频的分组值
        $('#SourceFile_gather_id').val($("select[name='gather_id']").val());
        $("select[name='gather_id']").change(function () {
            $('#SourceFile_gather_id').val($(this).val());
        });
    })
</script>