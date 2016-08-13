<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'service-form',
        'enableClientValidation' => true,
        'action' => Yii::app()->createUrl('basis/rule/update', array('id' => $model->id)),
    ));
    ?>
    <div class="keyword_two">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('class' => 'rule_name')); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>
    <div class="keyword_two">
        <label>关键字：</label>
        <?php echo CHtml::link('+添加关键字', array('keyword/create', 'id' => $model->id), array('class' => 'create-item right')) ?>
    </div>
    <div class="keyword_two">
        <?php if ($model->keyword): ?>

            <?php foreach ($model->keyword as $key => $value): ?>
                <div class="keyword_two_count">
                    <label><?php echo CHtml::encode($value->title); ?></label>
                    <label><?php echo $value->type == 0 ? '未全匹配' : "已全匹配"; ?></label>
                    <?php echo CHtml::link('', array('keyword/update', 'id' => $value->id), array('class' => 'update-item fu_icon modify', 'title' => '修改')) ?>
                    <?php echo CHtml::link('', array('keyword/delete', 'id' => $value->id), array('class' => 'delete-item fu_icon del', 'title' => '删除')) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="keyword_two">
        <!--<hr />-->
        <label>回复内容：</label>
        <?php echo CHtml::link('+添加回复内容', array('reply/index', 'rule_id' => $model->id, 'type' => '1'), array('class' => 'create-item right')) ?>
    </div>

    <!--<div class="keyword_two">
    <?php echo $form->labelEx($model, 'entire'); ?>
    <?php echo $form->checkbox($model, 'entire'); ?>
    </div>-->
    <?php if ($model->reply): ?>
        <?php foreach ($model->reply as $key => $value): ?>
            <?php if ($value->type == 1): ?>
                <div class="keyword_reply">
                    <p class="reply-content left">
                        <?php echo $form->radioButton($value, 'first', array('rule_id' => $value->rule_id, 'id' => $value->id, 'name' => "Teletext")) ?>
                        <?php echo PublicStaticMethod::replaceQqFace($value->content); ?>
                        <?php echo CHtml::link('', array('reply/delete', 'id' => $value->id), array('class' => 'delete-item right fu_icon del', 'title' => '删除')) ?>
                        <?php echo CHtml::link('', array('reply/index', 'id' => $value->id, 'type' => '1'), array('class' => 'update-item right fu_icon modify', 'title' => '修改')) ?>
                    </p>
                </div>
            <?php else: ?>
                <?php if ($value->multi): ?>
                    <?php if ($value->multiSourceFile): ?>
                        <div class="keyword_two"><label>多图文：</label></div>
                        <div class="keyword_reply">
                            <p class="reply-content left">
                              <?php echo $form->radioButton($value, 'first', array('rule_id' => $value->rule_id, 'id' => $value->id, 'name' => "Teletext")) ?>
                                <?php echo CHtml::encode($value->multiSourceFile->title); ?>
                                <?php echo CHtml::encode($value->multiSourceFile->description); ?>
                                <?php echo CHtml::link('', array('reply/delete', 'id' => $value->id), array('class' => 'delete-item right fu_icon del', 'title' => '删除')) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($value->sourceFile): ?>
                        <div class="keyword_two"><label>单图文：</label></div>
                        <div class="keyword_reply">
                            <p class="reply-content left">

                                <?php echo $form->radioButton($value, 'first', array('rule_id' => $value->rule_id, 'id' => $value->id, 'name' => "Teletext")) ?>
                                <?php echo CHtml::image(PublicStaticMethod::returnSourceFile($value->sourceFile->filename, $value->sourceFile->ext, 'image', 'medium')); ?>
                                <?php echo CHtml::link($value->sourceFile->title, Yii::app()->createUrl('site/view', array('id' => $value->sourceFile->id))); ?>
                                <?php echo CHtml::encode($value->sourceFile->description); ?>
                                <?php echo CHtml::link('', array('reply/delete', 'id' => $value->id), array('class' => 'delete-item right fu_icon del', 'title' => '删除')) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('保存修改', array('class' => 'inp_style')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->