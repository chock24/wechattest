<?php
/* @var $this MenuController */
/* @var $model Menu */
/* @var $form CActiveForm */

?>
<div class="form modify-section">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'menu-form',
    ));
    ?>	
    <?php
    echo CHtml::link('发送内容', array('index', 'id' => $model->id, 'type' => 1), array('class' => Yii::app()->request->getParam('type')==1?'left web-menu-btn yellow':'left web-menu-btn'));
    echo CHtml::link('跳转链接', array('index', 'id' => $model->id, 'type' => 2), array('class' => Yii::app()->request->getParam('type')==2?'left web-menu-btn yellow':'left web-menu-btn'));
    ?>
    <div class="clear"></div>
    <hr />
    <?php
    if (Yii::app()->request->getParam('type') == 1) {
        echo CHtml::link('文本消息', array('index', 'id' => $model->id, 'type' => 1, 'category' => 1, 'multi' => 0), array('class' => Yii::app()->request->getParam('category')==1?'left web-menu-btn yellow':'left web-menu-btn'));
        echo CHtml::link('单图文消息', array('index', 'id' => $model->id, 'type' => 1, 'category' => 5, 'multi' => 0), array('class' => Yii::app()->request->getParam('category')==5 && Yii::app()->request->getParam('multi')==0?'left web-menu-btn yellow':'left web-menu-btn'));
        echo CHtml::link('多图文消息', array('index', 'id' => $model->id, 'type' => 1, 'category' => 5, 'multi' => 1), array('class' => Yii::app()->request->getParam('category')==5 && Yii::app()->request->getParam('multi')==1?'left web-menu-btn yellow':'left web-menu-btn'));
    }
    ?>
    <div class="clear"></div>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'sort'); ?>
        <?php echo $form->textField($model, 'sort'); ?>
        <?php echo $form->error($model, 'sort'); ?>
    </div>

    <?php if (Yii::app()->request->getParam('type') == 2): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'url'); ?>
            <?php echo $form->textArea($model, 'url', array('rows' => 4, 'cols' => 50, 'size' => 60, 'maxlength' => 200)); ?>
            <span>例如：http://www.baidu.com</span>
            <?php echo $form->error($model, 'url'); ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::app()->request->getParam('category') == 1 && Yii::app()->request->getParam('type') == 1): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'description'); ?>
            <div class="preview">
                <?php echo PublicStaticMethod::replaceQqFace($model->description); ?>
            </div>

            <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50, 'maxlength' => 255)); ?>
            <p><span class="emotion">表情</span></p>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <?php
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/reset.css");
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.qqFace.js");
        Yii::app()->clientScript->registerScript('qqfaceInput', "	
                $('.emotion').qqFace({
                    id: 'facebox',
                    assign: 'Menu_description',
                    path: '" . Yii::app()->baseUrl . "/images/arclist/',
                });
        ");
        ?>
    <?php elseif (Yii::app()->request->getParam('category') == 5): ?>
        <hr />
        <?php if(Yii::app()->request->getParam('multi')==1): ?>
            <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/menu/more_news.css"); ?>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $sourceFileDataProvider,
                'itemView' => '_more_news',
                'viewData' => $modelDataProvider,
                'id' => 'ajaxListView',
                'template' => '{items} <div class="clear"></div> {summary} {pager}',
            ));
            ?> 
        <?php else: ?>
            <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/menu/news.css"); ?>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $sourceFileDataProvider,
                'itemView' => '_news',
                'viewData' => $modelDataProvider,
                'id' => 'ajaxListView',
                'template' => '{items} <div class="clear"></div> {summary} {pager}',
            ));
            ?> 
        <?php endif; ?>
    <?php endif; ?>


    

    <div class="row buttons">
        <hr>
        <?php echo $form->hiddenField($model, 'source_file_id', array('class'=>'source_file_id')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? '确定创建' : '保存修改', array('class' => 'left form-button')); ?>
    </div>

    <?php $this->endWidget(); ?>
    <div class="clear"></div>
</div><!-- form -->


<script type="text/javascript">
function selectItem(object) {
    $('.select-item').removeClass('current');
    if (object.hasClass('current')) {
        object.removeClass('current');
        $('input[class=\'source_file_id\']').val();
    } else {
        object.addClass('current');
        var data_id = object.attr('data-id');
        $('input[class=\'source_file_id\']').val(data_id);
    }
}
</script>