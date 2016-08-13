<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/fodder.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/popup_fodder.css" rel="stylesheet" type="text/css" />

<div class="padding30 popup-content-fodder">

    <div class="popup-content-fodder-seek">
        <div class="left">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'search-form',
                'method' => 'get',
                'action' => array('sourcefile'),
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <?php echo $form->textField($model, 'title', array('class' => 'left wechat-seek-input', 'size' => 30)); ?>
            <?php echo CHtml::submitButton('', array('class' => 'left wechat-seek-button')); ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <div class="clear"></div>

    <div class="padding10 popup-content-fodder-content">
        <?php if (isset($model->type))://单图文内容 ?>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'template' => '{items}',
                'itemView' => '//library/_news', // refers to the partial view named '_post'
            ));
            ?>
        <?php else://多图文 ?>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'template' => '{items}',
                'itemView' => '//library/_morenews', // refers to the partial view named '_post'
            ));
            ?>
        <?php endif; ?>
    </div>
    <div class="left popup-sidebar">
        <div class="popup-sidebar-list">
            <?php
                echo CHtml::link('显示全部', array(
                    'sourcefile',
                    'id'=>Yii::app()->request->getParam('id'),
                    'type'=>Yii::app()->request->getParam('type'),
                    'multi'=>Yii::app()->request->getParam('multi')), array(
                    'class' => 'select-gather-item',
                ));
            ?>
        </div>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $sourceFileGather,
            'itemView' => '//library/_gather',
            'id' => 'ajaxListView',
            'template' => '{items} {pager}',
        ));
        ?>
    </div>

</div>

<?php
Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
    var url = $(this).attr('action');
    $('#search-result').html('');
    $.get(url, $(this).serialize(), function(data){
        $('#search-result').html(data);
    });
    return false;
});
");

Yii::app()->clientScript->registerScript('gather', "
$('.select-gather-item').click(function(){
    var url = $(this).attr('href');
    $('#search-result').html('');
    $.get(url, '', function(data){
        $('#search-result').html(data);
    });
    return false;
});
");
?>