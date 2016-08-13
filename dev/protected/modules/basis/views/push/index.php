<link href="<?php echo Yii::app()->baseUrl; ?>/weixin_css/reply.css" rel="stylesheet" type="text/css" />
<div class="right content-main">
    <h2 class="content-main-title">群发功能</h2>
    <div>
        <div class="tabhost">
            <div class="tabhost-title">
                <ul>
                    <li <?php if (Yii::app()->request->getParam('status') == 0) { ?>class="active"<?php } ?> ><a href="<?php echo Yii::app()->createUrl('basis/push/index', array('status' => '0')); ?>">全部</a></li>
                    <li <?php if (Yii::app()->request->getParam('status') == 1) { ?>class="active"<?php } ?> ><a href="<?php echo Yii::app()->createUrl('basis/push/index', array('status' => '1')); ?>">审核中</a></li>
                    <li <?php if (Yii::app()->request->getParam('status') == 2) { ?>class="active"<?php } ?> ><a href="<?php echo Yii::app()->createUrl('basis/push/index', array('status' => '2')); ?>">审核成功</a></li>
                    <li <?php if (Yii::app()->request->getParam('status') == 3) { ?>class="active"<?php } ?> ><a href="<?php echo Yii::app()->createUrl('basis/push/index', array('status' => '3')); ?>">审核失败</a></li>
                    <li <?php if (Yii::app()->request->getParam('status') == 4) { ?>class="active"<?php } ?> ><a href="<?php echo Yii::app()->createUrl('basis/push/index', array('status' => '4')); ?>">发送成功</a></li>
                </ul>
                <!--<a href="/basis/push/addmessages" class="right button button-white new-group-sending-input">+创建群发消息</a>-->
                <a href="<?php echo Yii::app()->createUrl('basis/push/create', array('genre' => '1')) ?>" class="right button button-white">+创建群发消息</a>
                <div class="clear"></div>
            </div>

            <div class="tabhost-center">
                <div class="margin-right-8">

                    <div class="margin-left-20 padding10 search-form">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div><!-- search-form -->

                </div>
                <div class="padding30 padding-top-10">
                    <div class="group-sending">

                        <?php
                        $status = @Yii::app()->request->getParam('status');
                            $this->widget('zii.widgets.CListView', array(
                                'dataProvider' => $dataProvider,
                                'itemView' => '_view',
                                'emptyText' => '您的公众号下面并没有群发信息数据',
                                'ajaxUpdate' => false,
                                'ajaxVar' => '',
                                'template' => '{items} {summary} {pager}',
                                'summaryText' => '消息数:<span>{count}</span>  总页数:<span>{pages}</span>',
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
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        element_del($('.group-sending-list-choice').find('a.del'), '你确定要删除吗？');
    })
</script>