<div class="right content-main">
    <h2 class="content-main-title">图片库</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <ul>
                            <!--    <li class="active">
                        <?php //echo CHtml::link('单图文库', array('news')); ?>
                    </li>-->
                    <li>
                        <?php echo CHtml::link('单/多图文库', array('morenews')); ?>
                    </li>
                    <li class="active">
                        <?php echo CHtml::link('图片库', array('image')); ?>
                    </li>
                    <li>
                        <?php echo CHtml::link('音频库', array('voice')); ?>
                    </li>
                    <li>
                        <?php echo CHtml::link('视频库', array('video')); ?>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tabhost-center">
                <div class="padding30 tabhost-center">

                    <!--全选移动-->
                    <div class="fodder-group-move">

                        <label class="left margin-top-8 margin-right-15 fodder-group-checked">
                            <?php echo CHtml::checkBox('SourceFile[all]', false, array('value' => 1, 'class' => 'left margin-right-5 fodder-group-move-checkbox selector')); ?>
                            <span class="fodder-group-move-text">全选</span>
                        </label>

                        <input type="button" class="margin-right-5 button button-gray operation-button" value="移动分组"   type1="2"  base_url="<?php echo Yii::app()->request->hostInfo . Yii::app()->createUrl('basis/sourcefilegather/group'); ?>"  onclick="select_data_id($(this), $('.items').find('.fodder'))">     
                        <input type="button" class="button button-gray operation-button" value="删除" data-href="<?php echo Yii::app()->request->hostinfo; ?>/basis/sourcefile/delete" onclick="select_data_id($(this), $('.items').find('.fodder'))">
                        <div class="right wechat-fodder-seek">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'action' => Yii::app()->createUrl($this->route),
                                'method' => 'get',
                            ));
                            ?>
                            <?php echo $form->textField($model, 'title', array('class' => 'left wechat-seek-input', 'size' => 20, 'placeholder' => '标题')); ?>
                            <?php echo CHtml::submitButton('', array('class' => 'left wechat-seek-button')); ?>
                            <?php $this->endWidget(); ?>
                        </div>

                        <?php echo CHtml::link('新建图片', array('create', 'type' => 2), array('class' => 'ie7margin-top33 right button button-green', 'target' => '_blank')) ?>

                    </div>


                    <div class="left width880">
                        <div class="overflow padding10 wechat-fodder">

                            <?php
                            $this->widget('zii.widgets.CListView', array(
                                'dataProvider' => $dataProvider,
                                'itemView' => '_image',
                                'emptyText' => '没有图片素材数据，您可以创建一个新的素材',
                                'ajaxUpdate' => false,
                                'ajaxVar' => '',
                                'template' => '{items} <div class="clear"></div> {summary} {pager}',
                                'summaryText' => '图片数:<span>{count}</span>  总页数:<span>{pages}</span>',
                                'pager' => array(
                                    'class' => 'CLinkPager',
                                    'header' => '',
                                    'maxButtonCount' => 5,
                                    'nextPageLabel' => '&gt;',
                                    'prevPageLabel' => '&lt;',
                                ),
                            ));
                            ?>

                        </div>
                    </div>

                    <!--分页功能-->
                    <div class="left sidebar img-watermark">
                        <h4>图片水印设置</h4>
                        <div class="sidebar-list">
                            <a href="javascript:;" class="left select-gather-item"><input type="radio" checked="checked">使用微信号</a>
                            <a class="margin-right-5 right none select-gather-update" href="javascript:;"><i class="icon icon-text"></i></a>
                        </div>
                    </div>
                    <div class="left sidebar">
                        <div class="sidebar-list">
                            <?php echo CHtml::link('显示全部', Yii::app()->createUrl($this->route), array('class' => 'select-gather-item')); ?>
                        </div>
                        <?php
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider' => $sourceFileGather,
                            'emptyText' => '<div class="sidebar-list"><a href="javascript:;">暂时没有分组数据</a></div>',
                            'itemView' => '_gather',
                            'template' => '{items} <div class="clear"></div> {pager}',
                        ));
                        ?>
                        <div class="sidebar-list">
                            <?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create', 'type' => '2'), array('class' => 'create-gather-item', 'onclick' => 'js:return popup($(this), "添加分組", 390, 175);')); ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        element_del($('.icon-del'), '你确定要删除吗？');
        checkboxSelect($('.selector'), $('.options'), $('.operation-button'));
    })
</script>