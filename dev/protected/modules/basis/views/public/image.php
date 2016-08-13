<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */
?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/common.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/image.css");
?>


<div class="span-100">

    <div class="content" id="images">

        <div id="voice" style="padding-top: 10px;">
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '/public/_image',
                'viewData' => $modelDataProvider,
                'id' => 'ajaxListView',
                'template' => '{items} <div class="clear"></div> {summary} {pager}',
            ));
            ?>
        </div>
    </div>
    <div class="sidebar">
        <dl>
            <dd>
                <?php echo CHtml::link('显示全部', array('/basis/welcome/index','type'=>2)); ?>
            </dd>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $sourceFileGather,
                'itemView' => '/public/_gather',
                
                'id' => 'gatherListView',
                'template' => '{items}',
            ));
            ?>
            <dd>
                <?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create/', 'type' => 2), array('class' => 'create-gather-item')); ?>
            </dd>
        </dl>
    </div>
    <div class="clear"></div>
</div> 
