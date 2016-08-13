<?php
/* @var $this SourcefileController */
/* @var $dataProvider CActiveDataProvider */
?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/common.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/sourcefile/img_txt.css");
?>
 <a class='<?php echo  Yii::app()->request->getParam('multi') ? 'inp_style create-item' : 'inp_style active-btn create-item';?>'
    href="<?php echo Yii::app()->createUrl('basis/reply/index', array('type' => 5, 'multi' => 0,'rule_id'=>Yii::app()->request->getParam('rule_id'))); ?>" onclick="js:return popup($(this), '增加回复内容', 950, 600);" >
                      单图文                </a>
 <a class='<?php echo Yii::app()->request->getParam('multi') ? 'inp_style active-btn create-item' : 'inp_style create-item';?>'
    href="<?php echo Yii::app()->createUrl('basis/reply/index', array('type' => 5, 'multi' => 1,'rule_id'=>Yii::app()->request->getParam('rule_id'))); ?>" onclick="js:return popup($(this), '增加回复内容', 950, 600);" >
                      多图文</a>


<div class="span-100">

    <div class="content" id="images">

        <div id="voice" style="padding-top: 10px;">
            <?php
            if (Yii::app()->request->getParam('multi') == 1) {
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '/public/_more_news',
                    'viewData' => $modelDataProvider,
                    'id' => 'ajaxListView',
                    'template' => '{items} <div class="clear"></div> {summary} {pager}',
                ));
            } else {
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '/public/_news',
                    'viewData' => $modelDataProvider,
                    'id' => 'ajaxListView',
                    'template' => '{items} <div class="clear"></div> {summary} {pager}',
                ));
            }
            ?>
        </div>
    </div>
    <div class="sidebar">
        <dl>
            <dd>
                <?php echo CHtml::link('显示全部', Yii::app()->createUrl($this->route, array('type' => 5, 'multi' => Yii::app()->request->getParam('multi'))),array('class'=>'create-item')); ?>
            </dd>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $sourceFileGather,
                'itemView' => '/public/_gather',
                'id' => 'gatherListView',
                'template' => '{items} {pager}',
                'pager' => array(
                    'class' => 'CLinkPager',
                    'maxButtonCount' => 3,
                    'header' => '翻页:',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                ),
            ));
            ?>
        
            <dd>
                <?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create/', 'type' => 5, 'multi' => Yii::app()->request->getParam('multi')), array('class' => 'create-gather-item create-item')); ?>
            </dd>
        </dl>
    </div>
    <div class="clear"></div>

</div> 
