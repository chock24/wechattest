<div class="right content-main">
    <h2 class="content-main-title">多图文库</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <ul>
<!--                    <li>
                        <?php //echo CHtml::link('单图文库', array('news')); ?>
                    </li>-->
                    <li class="active">
                        <?php echo CHtml::link('单/多图文库', array('morenews')); ?>
                    </li>
                    <li>
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
                        <input type="button" class="margin-right-5 button button-gray operation-button" value="移动分组"  gather_id='0' type1="5" multi='1' base_url="<?php echo Yii::app()->request->hostInfo . Yii::app()->createUrl('basis/sourcefilegather/group'); ?>"  onclick="select_data_id($(this), $('.items').find('.fodder'))">
                        <input type="button" class="button button-gray operation-button" value="删除" data-href="http://wechat.demo.cn/basis/sourcefile/delete" onclick="select_data_id($(this), $('.items').find('.fodder'))">
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
                        <?php echo CHtml::link('<i class="mage-text-add-icon-appmsgmore"></i><strong>新建图文</strong>', array('moremsg', 'type' => 5, 'multi' => 1), array('class' => 'ie7margin-top33 right button button-green', 'target' => '_blank')); ?>
                    </div>

                    <div class="left width880">
                        <div class="overflow padding10 wechat-fodder">

                            <!--<div class="mage-text-add">
                                <i class="mage-text-add-icon-add"></i>
                            <?php /* echo CHtml::link('<i class="mage-text-add-icon-appmsg"></i><strong>单图文</strong>', array('create', 'type' => 5, 'multi' => 0), array('class' => 'mage-text-add-appmsg', 'target'=>'_blank')); */ ?>
                            <?php /* echo CHtml::link('<i class="mage-text-add-icon-appmsgmore"></i><strong>多图文</strong>', array('create', 'type' => 5, 'multi' => 1), array('class' => 'mage-text-add-appmsgmore', 'target'=>'_blank')); */ ?>
                            </div>-->

                            <!--<div class="mage-text-add">
                                <i class="mage-text-add-icon-add"></i>
                                <?php /*echo CHtml::link('<i class="mage-text-add-icon-appmsg"></i><strong>单图文</strong>', array('onlymsg', 'type' => 5, 'multi' => 0), array('class' => 'mage-text-add-appmsg', 'target' => '_blank')); */?>
                                <?php /*echo CHtml::link('<i class="mage-text-add-icon-appmsgmore"></i><strong>多图文</strong>', array('moremsg', 'type' => 5, 'multi' => 1), array('class' => 'mage-text-add-appmsgmore', 'target' => '_blank')); */?>
                            </div>-->

                            <?php
                            $this->widget('zii.widgets.CListView', array(
                                'dataProvider' => $dataProvider,
                                'itemView' => '_morenews',
                                'emptyText' => '<div class="margin-top-15 margin-left-5 left">没有多图文素材数据，您可以创建一个新的素材</div>',
                                'ajaxUpdate' => false,
                                'ajaxVar' => '',
                                'template' => '{items} <div class="clear"></div> {summary} {pager}',
                                'summaryText' => '多图文数:<span>{count}</span>  总页数:<span>{pages}</span>',
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
                    <div class="left sidebar">
                        <?php
                        $trust = $publicmodel->trust;
                        if ($trust > 0) {
                            ?>
                            <div class="sidebar-list">
                                <?php echo CHtml::link('[数据模版]', Yii::app()->createUrl('basis/sourcefile/morenews', array('template' => '1')), array('class' => 'select-gather-item')); ?>
                            </div>
                        <?php } ?>
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
                            <?php echo CHtml::link('+添加分组', array('/basis/sourcefilegather/create', 'type' => '5', 'multi' => '1'), array('class' => 'create-gather-item', 'onclick' => 'js:return popup($(this), "添加分組", 390, 175);')); ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /*显示多余图片样式*/
    $(function () {
        element_del($('.icon-del'), '你确定要删除吗？');
        $('.mage-text-more').hide();
        $('.mage-text').each(function () {
            //$(this).children().eq(1).show();
            if ($(this).children('.mage-text-more').length <= 1) {
                $(this).find('.mage-text-more-pulldown').html('');
            } else {
                $(this).find('.mage-text-more-pulldown').toggle(function () {
                    $(this).parent().find('.mage-text-more').show();
                    $(this).html('&and;')
                }, function () {
                    $(this).parent().find('.mage-text-more').hide();
                    //$(this).parent().find('.mage-text-more').eq(0).show();
                    $(this).html('&or;')
                });
            }
        });
        checkboxSelect($('.selector'), $('.options'), $('.operation-button'));
    })
</script>