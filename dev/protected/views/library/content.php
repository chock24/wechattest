<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/fodder.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/popup_fodder.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/weixin_js/jquery.wallform.js"></script>

<div class="padding30 popup-content-fodder">

    <div class="popup-content-fodder-seek">
        <div class="left">
            <?php
            if(isset($poster)&& $poster == '1'){
               // var_dump($dataProvider);exit;


            }else{
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'search-form',
                    'method' => 'get',
                    'action' => array(
                        'sourcefile',
                        'id' => Yii::app()->request->getParam('id'),
                        'type' => Yii::app()->request->getParam('type'),
                        'category' => Yii::app()->request->getParam('category'),
                        'multi' => Yii::app()->request->getParam('multi')
                    ),
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
            ?>
            <?php echo $form->textField($model, 'title', array('class' => 'left wechat-seek-input', 'size' => 30)); ?>
            <?php echo CHtml::submitButton('', array('class' => 'left wechat-seek-button')); ?>
            <?php $this->endWidget();} ?>

        </div>
    </div>

    <div class="clear"></div>

    <div class="padding10 popup-content-fodder-content">
        <?php
        if (isset($model->type)) {//单图文内容
            if ($model->type == '5') {
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'news-listview',
                    'dataProvider' => $dataProvider,
                    'template' => '{items} <div class="clear"></div> {pager}',
                    'itemView' => '//library/_news', // refers to the partial view named '_post'
                ));
            } else if ($model->type == '2') {
                //var_dump($dataProvider);exit;
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'news-listview',
                    'dataProvider' => $dataProvider,
                    'template' => '{items} <div class="clear"></div> {pager}',
                    'itemView' => '//library/_image', // refers to the partial view named '_post'
                ));
            } else if ($model->type == '3') {//音频文件
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'news-listview',
                    'dataProvider' => $dataProvider,
                    'template' => '{items} <div class="clear"></div> {pager}',
                    'itemView' => '//library/_voice', // refers to the partial view named '_post'
                ));
            } else if ($model->type == '4') {//视频文件
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'news-listview',
                    'dataProvider' => $dataProvider,
                    'template' => '{items} <div class="clear"></div> {pager}',
                    'itemView' => '//library/_video', // refers to the partial view named '_post'
                ));
            }
        }elseif(isset($poster)&& $poster == '1') {

            $this->widget('zii.widgets.CListView', array(
                'id' => 'pimage-listview',
                'dataProvider' => $dataProvider,
                'template' => '{items} <div class="clear"></div> {pager}',
                'itemView' => '//library/_pimage',
            ));
        }else {//多图文
            $this->widget('zii.widgets.CListView', array(
                'id' => 'morenews-listview',
                'dataProvider' => $dataProvider,
                'template' => '{items} <div class="clear"></div> {pager}',
                'itemView' => '//library/_morenews', // refers to the partial view named '_post'
            ));
        }
        ?>
    </div>
    <div class="left popup-sidebar">
        <div class="popup-sidebar-list">
            <?php
            if(isset($poster) && $poster == '1'){
                echo CHtml::link('显示全部', array(
                    'posterfile',
                    'id' => Yii::app()->request->getParam('id')),
                    array(
                        'class' => 'select-gather-item',
                        )
                );
            }else{
                echo CHtml::link('显示全部', array(
                    'sourcefile',
                    'id' => Yii::app()->request->getParam('id'),
                    'type' => Yii::app()->request->getParam('type'),
                    'category' => Yii::app()->request->getParam('category'),
                    'multi' => Yii::app()->request->getParam('multi')), array(
                    'class' => 'select-gather-item',
                ));
            }
            ?>
        </div>
        <?php
        if(!isset($poster)) {
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $sourceFileGather,
                'itemView' => '//library/_gather',
                'id' => 'ajaxListView',
                'template' => '{items} {pager}',
            ));
        }
        ?>
    </div>

</div>

<div class="popup-footer">
    <?php echo CHtml::button('确认提交', array('class' => 'button button-green add-mage-text-mask-add-icon', 'id' => 'select-result', 'onclick' => 'js:return popupConfirm($(this),$("#result-id"),$("#result-multi"),$("#result-type"),0)')); ?>
    <?php echo CHtml::button('取消', array('class' => 'closed button')); ?>
</div>

<?php
Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
    var url = $(this).attr('action');
    $('.popup-data').html('');
    $.get(url, $(this).serialize(), function(data){
        $('.popup-data').html(data);
    });
    return false;
});
");

Yii::app()->clientScript->registerScript('gather', "
$('.select-gather-item').click(function(){
    var url = $(this).attr('href');
    $('.popup-data').html('');
    $.get(url, '', function(data){
        $('.popup-data').html(data);
    });
    return false;
});
");
?>