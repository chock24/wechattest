<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/weixin_css/marketing_tool.css" />

<div class="right content-main">
    <div class="margin-top-10 tabhost">
        <div class="tabhost-title">
            <ul>
                <?php $sta = Yii::app()->request->getParam('status'); ?>
                <li class="<?php echo $sta === null ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('systems/coupon/index'); ?>">优惠劵</a></li>
                <li class="<?php echo $sta === '0' ? 'active' : '' ?>" ><a href="<?php echo Yii::app()->createUrl('systems/coupon/index', array('status' => 0)); ?>">未过期优惠劵</a></li>
                <li class="<?php echo $sta === '1' ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('systems/coupon/index', array('status' => 1)); ?>">过期优惠劵</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('systems/coupon/create'); ?>">新建优惠劵</a></li>
            </ul>

            <div class="clear"></div>
        </div>
        <div class="padding20 tabhost-center">

            <table class="margin-top-15 wechat-table">

                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'emptyText' => '您的公众号下面并没有消息数据',
                    'ajaxUpdate' => false,
                    'ajaxVar' => '',
                    'template' => '{items}',
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

            </table>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_view',
                'emptyText' => '您的公众号下面并没有消息数据',
                'ajaxUpdate' => false,
                'ajaxVar' => '',
                'template' => '{summary} {pager}',
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
<script>
    $(function(){
        checkboxSelect($('.wechat-table').find('th').find('input:checkbox'), $('.wechat-table').find('td').find('input:checkbox'), $(''));//checkbook全选
    })
</script>