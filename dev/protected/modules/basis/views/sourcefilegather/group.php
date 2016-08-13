<?php
/* @var $this SourceFileGatherController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    '素材集合',
);

$this->menu = array(
    array('label' => 'Create SourceFileGather', 'url' => array('create')),
    array('label' => 'Manage SourceFileGather', 'url' => array('admin')),
);
?>

<div class="text-center">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'source-file-gather-form2',
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
                                             $.ajax({"type":"POST","url":"' . Yii::app()->createUrl('/basis/sourcefilegather/group', array('id' => $model->id)) . '","data":$("#source-file-gather-form2").serialize(),
                                            "success":function(data){
                                                    window.location.reload();
                                            }
                                    });
                            }
                            }'
        ),
    ));
    ?>
    <div class="padding30">
        <?php
        foreach ($dataProvider as $d) {
            if ($gatherid == $d->id) {
                echo $form->radioButton($model, 'name', array('value' => $d->id, 'onclick' => 'radioclick(' . $d->id . ')', 'checked' => 'checked'));
            } else {
                echo $form->radioButton($model, 'name', array('value' => $d->id, 'onclick' => 'radioclick(' . $d->id . ')'));
            }
            echo $d->name;
        }
        ?>
        <?php
        if (Yii::app()->user->hasFlash('errors')) {
            echo Yii::app()->user->getFlash('errors');
        }
        ?>
        <?php echo $form->hiddenField($model, 'id', array('value' => $gatherid)); ?>
        <?php
        if (!empty($ids)) {
            echo $form->hiddenField($model, 'ids', array('value' => $ids));
        }
        ?>
        <?php
        if (Yii::app()->user->hasFlash('errors')) {
            echo Yii::app()->user->getFlash('errors');
        }
        ?>
        <?php echo $form->hiddenField($model, 'type', array('value' => $type)); ?>
        <div class="margin-top-15 color-red grouping_warning"></div><!--放提示语句-->
    </div>
    <div class="popup-footer">
        <?php echo CHtml::submitButton('确定', array('class' => 'button button-green', 'onclick' => 'js:return grouping_warning();')); ?>
        <input type="button" value ="取消" class="closed button" />
    </div>
    <?php $this->endWidget(); ?>
</div>

<script>
    var id = 0;
    function radioclick(id) {
        document.getElementById("SourceFileGather_id").value = id;
        //document.getElementById("SourceFileGather_name").value=id;

    }
    function dilagclose()
    {
        $('#mydialog').dialog('close');
    }
    function grouping_warning() {
        var id = $('#SourceFileGather_id').val();
        if (id == '0'|| id=='') {
            $('.grouping_warning').html('请先选择分类');
            return false;
        } else {
            $('.grouping_warning').html('');
        }
    }
</script>