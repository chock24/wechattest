<!--内容页菜单部分-->
<div class="content-menu">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'encodeLabel' => false,
        'items' => array(
            array('label' => '文本', 'url' => 'javascript:;', 'itemOptions' => array('class' => 'left', 'data-url' => Yii::app()->createUrl($this->route, array('id' => Yii::app()->request->getParam('id'), 'type' => 1)), 'onclick' => "js:operation(this,'open','part')")),
            //array('label' => '图片', 'url' => 'javascript:;', 'itemOptions' => array('class' => 'left', 'data-url' => Yii::app()->createUrl($this->route, array('id' => Yii::app()->request->getParam('id'), 'type' => 2)), 'onclick' => "js:operation(this,'open','part')")),
            //array('label' => '音频', 'url' => 'javascript:;', 'itemOptions' => array('class' => 'left', 'data-url' => Yii::app()->createUrl($this->route, array('id' => Yii::app()->request->getParam('id'), 'type' => 3)), 'onclick' => "js:operation(this,'open','part')")),
            //array('label' => '视频', 'url' => 'javascript:;', 'itemOptions' => array('class' => 'left', 'data-url' => Yii::app()->createUrl($this->route, array('id' => Yii::app()->request->getParam('id'), 'type' => 4)), 'onclick' => "js:operation(this,'open','part')")),
            array('label' => '单图文', 'url' => 'javascript:;', 'itemOptions' => array('class' => 'left', 'data-url' => Yii::app()->createUrl($this->route, array('id' => Yii::app()->request->getParam('id'), 'type' => 5, 'multi' => 0)), 'onclick' => "js:operation(this,'open','part')")),
            array('label' => '多图文', 'url' => 'javascript:;', 'itemOptions' => array('class' => 'left', 'data-url' => Yii::app()->createUrl($this->route, array('id' => Yii::app()->request->getParam('id'), 'type' => 5, 'multi' => 1)), 'onclick' => "js:operation(this,'open','part')")),
        ),
    ));
    ?>
    <div class="clear"></div>
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'operation-form',
    'enableAjaxValidation' => false,
));
?>
<!--内容页内容部分-->
<div class="content-view">
    <?php
    switch (Yii::app()->request->getParam('type')):
        case 2:
            $page = '//library/image';
            break;
        case 3:
            $page = '//library/voice';
            break;
        case 4:
            $page = '//library/video';
            break;
        case 5:
            if (Yii::app()->request->getParam('multi') == 1) {
                $page = '//library/morenews';
            } else {
                $page = '//library/news';
            }
            break;
        default :
            $page = '//library/text';
            break;
    endswitch;
    $this->renderPartial($page, array('model' => $model, 'form' => $form, 'dataProvider' => $dataProvider));
    ?>
    <?php if ($sourceFileGather): ?>
        <div class="sidebar-part right">
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $sourceFileGather,
                'itemView' => '//library/_gather',
                'id' => 'ajaxListView',
                'template' => '<div class="gather-item">
                ' . CHtml::link('显示全部', 'javascript:;', array(
                    'class' => 'select-gather-item left',
                    'data-url' => Yii::app()->createUrl(
                            $this->route, array(
                        'id' => Yii::app()->request->getParam('id'),
                        'genre' => Yii::app()->request->getParam('genre'),
                        'type' => Yii::app()->request->getParam('type'),
                        'multi' => Yii::app()->request->getParam('multi'),
                        'count' => Yii::app()->request->getParam('count'),
                        'userarr' => Yii::app()->request->getParam('userarr')
                            )
                    ),
                    'onclick' => 'js:return operation(this,"open","part")'
                        )
                ) . '
                <div class="clear"></div>
                </div>{items} <div class="clear"></div> {pager}',
            ));
            ?>
        </div>
    <?php endif; ?>
    
    <div class="clear"></div>
    <br />
    <hr />
    <?php echo $form->hiddenField($model,'source_file_id',array('class'=>'checked-field')); ?>
    <?php echo $form->error($model,'source_file_id'); ?>
    <?php 
        echo CHtml::submitButton('选定', 
            array(
                'class' => 'form-button web-menu-btn',
                'onclick' => 'js:return submitForm('.(Yii::app()->request->getParam('type')?Yii::app()->request->getParam('type'):1).');'
            )
        ); 
    ?>
</div>

<?php $this->endWidget(); ?>