<?php
/* @var $this PushController */
/* @var $model Push */

$this->breadcrumbs = array(
    '基础功能' => array('/basis'),
    '群发功能' => array('admin'),
    '查看信息',
);
?>


<div class="right content-main">
    <h2 class="content-main-title">查看信息 #<?php echo $model->id; ?></h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <div class="clear"></div>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'push-view-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="padding10 tabhost-center">
                <div class="form-compile">

                    <?php if (Yii::app()->user->hasFlash('success')): ?>
                        <div class="flash-success">
                            <?php echo Yii::app()->user->getFlash('success'); ?>
                        </div>
                    <?php elseif (Yii::app()->user->hasFlash('error')): ?>
                        <div class="flash-error">
                            <?php echo Yii::app()->user->getFlash('error'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-compile-list">
                        <label>ID：</label>
                        <div class="margin-top-8"><?php echo $model->id; ?></div>
                    </div>
                    <div class="form-compile-list">
                        <label>发送用户：</label>
                        <div class="margin-top-8"><?php echo Yii::app()->params->PUSHGENRE[$model->genre] ?></div>
                    </div>
                    <div class="form-compile-list">
                        <label>发送用户/用户组数量：</label>
                        <div class="margin-top-8"><?php echo $model->count; ?></div>
                    </div>
                    <div class="form-compile-list">
                        <label>发送类型：</label>
                        <div class="margin-top-8"><?php echo Yii::app()->params->TYPE[$model->type] ?></div>
                    </div>
                    <div class="form-compile-list">
                        <label>是否为多图文：</label>
                        <div class="margin-top-8"><?php echo Yii::app()->params->WHETHER[$model->multi] ?></div>
                    </div>
                    <div class="form-compile-list">
                        <label>发送状态：</label>
                        <div class="margin-top-8"><?php echo Yii::app()->params->PUSHSTATUS[$model->status] ?></div>
                    </div>
                    <div class="form-compile-list">
                        <label>创建时间：</label>
                        <div class="margin-top-8"><?php echo date("y-m-d h:i:s", $model->time_created) ?></div>
                    </div>
                    <?php if ($model->status == 1) { ?>
                        <div class="form-compile-list audit-show-hide">
                            <label>是否通过审核：</label>
                            <div class="margin-top-8">
                                <select data-val="" name="Client[source_id]">
                                    <option value="1">通过审核</option>
                                    <option value="2">不通过审核</option>
                                </select>

                            </div>
                        </div>
                        <div class="none form-compile-list">
                            <label>审核不通过原因：</label>
                            <div class="margin-top-8">
                                <?php echo $form->textarea($model, 'remark', array('cols' => "100", 'rows' => "4")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($model->status == 3) { ?>
                        <div class="form-compile-list">
                            <label>是否通过审核：</label>
                            <div class="margin-top-8">
                                不通过审核
                            </div>
                        </div>
                        <div class="form-compile-list">
                            <label>审核不通过原因：</label>
                            <div class="margin-top-8 left width-60">
                               <?php echo $model->remark;?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                    <div class="form wide">
                        <?php echo $form->errorSummary($model); ?>
                        <div class="row">
                            <?php if ($model->status == 2): ?>
                                <div class="form-compile-list">
                                    <label><?php echo $form->label($model, 'openid', array('class' => 'margin-top-5 left')); ?></label>
                                    <?php echo $form->textField($model, 'openid', array('class' => 'margin-top-5 margin-left-5 left')); ?>
                                    <?php echo CHtml::htmlButton('发送预览', array('name' => 'Push[preview]', 'value' => 1, 'type' => '', 'class' => 'button', 'style' => 'margin-left: 20px;', 'onclick' => 'js:return confirm("您确定发送预览数据吗？");')); ?>
                                </div>
                                <div class="form-compile-list buttons">
                                    <?php echo CHtml::htmlButton('确认发送', array('name' => 'Push[status]', 'value' => 2, 'type' => '', 'class' => 'margin-top-15 button button-green', 'onclick' => 'js:return confirm("您确定发送群发信息吗？");')); ?>
                                    <?php elseif ($model->status == 3): ?>
                                        <div class="form-compile-list buttons">
                                            <?php echo CHtml::htmlButton('撤销发送', array('name' => 'Push[status]', 'value' => 3, 'type' => '', 'class' => 'margin-top-15 button', 'onclick' => 'js:return confirm("您确定撤销该群发信息吗？");')); ?>
                                        </div>
                                        <div class="form-compile-list buttons">
                                            <?php elseif ($model->status == 1): ?>
                                        </div>
                                        <div class="form-compile-list buttons">
                                            <?php echo $form->hiddenField($model, 'success', array('value' => '1')); ?>
                                            <?php echo CHtml::htmlButton('确认审核', array('name' => 'Push[status]', 'value' => 1, 'type' => '','showtext'=>'', 'class' => 'margin-top-15 button button-green', 'onclick' => 'js:return confirm("你确定该消息" + $(".audit-show-hide").find("select").find("option:selected").text()+"吗？");')); ?>
                                        </div>
                                        <div class="clear"></div>
                                    <?php endif; ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
          
            <?php $this->endWidget(); ?>
        </div>
    </div>


</div>
<script type="text/javascript">
    $(function(){
        $('.audit-show-hide').find('select').change(function(){
            $('#Push_success').val($(this).val());
            if($(this).val()==2){
                $(this).parent().parent().next().show();
            }else{
                $(this).parent().parent().next().hide();
            }
        });
    })
</script>